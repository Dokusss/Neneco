<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelo/ventas.modelo.php";
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelo/clientes.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelo/usuarios.modelo.php";
require_once "../../../controladores/producto.controlador.php";
require_once "../../../modelo/producto.modelo.php";

class imprimirFactura{
    
    public $boleta;

    public function traerImpresionFactura() {

        //TRAEMOS LA INFORMACION DE LA VENTA
        $itemVenta = "boleta";
        $valorVenta = $this->boleta;
    
        $respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);
    
        $fecha = $respuestaVenta["fecha_venta"];
        $productos = json_decode($respuestaVenta["productos"], true);
        $totalVenta = $respuestaVenta["total"];

        //TRAEMOS LA INFORMACION DEL CLIENTE
        $itemCliente = "id";
        $valorCliente = $respuestaVenta["idCliente"];
        $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

        //TRAEMOS LA INFORMACION DEL VENDEDOR
        $itemVendedor = "id";
        $valorVendedor = $respuestaVenta["idUsuario"];
        $respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

        //REQUERIMOS LA CLASE TCPDF
        require_once('tcpdf_include.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->startPageGroup();
        $pdf->AddPage();
        
        // ---------------------------------------------------------
        $bloque1 = <<<EOF
            <table>
                <tr>
                    <td style="width:150px"><img src="images/logoMorocho.jpeg" alt="Logo Morocho"></td>
                    <td style="background-color:white; width:140px">
                        <div style="font-size:8.5px; text-align:right; line-height:15px;">
                            <br>
                            NIT: 71.759.963-9
                            <br>
                            Dirección: Calle 44B 92-11
                        </div>
                    </td>
                    <td style="background-color:white; width:140px">
                        <div style="font-size:8.5px; text-align:right; line-height:15px;">
                            <br>
                            Teléfono: 300 786 52 49
                            <br>
                            ventas@inventorysystem.com
                        </div>
                    </td>
                    <td style="background-color:white; width:110px; text-align:center; color:red"><br><br>FACTURA N.<br>$valorVenta</td>
                </tr>
            </table>

        EOF;
        $pdf->writeHTML($bloque1, false, false, false, false, '');

        // ---------------------------------------------------------
        $bloque2 = <<<EOF
            <table>
                <tr>
                    <td style="width:540px"><img src="images/back.jpg"></td>
                </tr>
            </table>
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <th style="border: 1px solid #666; background-color:white; width:390px">Cliente: $respuestaCliente[nombre]</th>
                    <td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">Fecha: $fecha</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $respuestaVendedor[nombre]</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
                </tr>
            </table>
        EOF;
        $pdf->writeHTML($bloque2, false, false, false, false, '');

        // ---------------------------------------------------------
        $bloque3 = <<<EOF
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Producto</td>
                    <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
                    <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Precio Unit.</td>
                    <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Total</td>
                </tr>
            </table>
        EOF;
        $pdf->writeHTML($bloque3, false, false, false, false, '');

        // ---------------------------------------------------------
        foreach($productos as $key => $item){
            $itemProducto = "nombre_producto";
            $valorProducto = $item["nombre"];
            $orden = null;

            $respuestaProducto= ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);

            $subTotal = number_format($respuestaProducto["precio_venta"],2);
            $nombre = $item["nombre"];
            $cantidad = $item["cantidad"];
            $total = number_format($item["total"],2);

            $bloque4 = <<<EOF
                <table style="font-size:10px; padding:5px 10px;">
                    <tr>
                        <td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">$nombre</td>
                        <td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">$cantidad</td>
                        <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">Bs $subTotal</td>
                        <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">Bs $total</td>
                    </tr>
                </table>
            EOF;
            $pdf->writeHTML($bloque4, false, false, false, false, '');
        }

        // ---------------------------------------------------------
        $bloque5 = <<<EOF
            <table style="font-size:10px; padding:5px 10px;">
                <tr>
                    <td style="color:#333; background-color:white; width:440px; text-align:center"></td>
                    <td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>
                    <td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #666; color:#333; background-color:white; width:440px; text-align:center"></td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
                    <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Total a pagar: Bs $totalVenta</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #666; color:#333; background-color:white; width:440px; text-align:center"></td>
                    <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"></td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #666; color:#333; background-color:white; width:440px; text-align:center"></td>
                    <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"></td>
                    <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
                </tr>
            </table>
        EOF;
        $pdf->writeHTML($bloque5, false, false, false, false, '');

        // ---------------------------------------------------------
        //SALIDA DEL ARCHIVO 
        $pdf->Output('factura.pdf', 'I');
    }
}
$factura = new imprimirFactura();
$factura -> boleta = $_GET["boleta"];
$factura -> traerImpresionFactura();
?>
