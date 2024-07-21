<?php
require_once "../controladores/cargo.controlador.php";
require_once "../modelos/cargo.modelo.php";

class tablaCargo
{
  /*=============================================
    MOSTRAR TABLA CARGOS
    =============================================*/
  public function mostrarTablaCargo()
  {
    $item = null;
    $valor = null;

    $cargo = ControladorCargo::ctrMostrarCargo($item, $valor);
    
    $datosJson = '{
      "data": [';
      for ($i = 0; $i < count($cargo); $i++) {
        $nombre = "<td class='text-uppercase'>" . $cargo[$i]["nombre"] . "</td>";
        $sueldo = "<td class='text-uppercase'>" . $cargo[$i]["sueldo"] . "</td>";
        $botones = "<td><div><button class='btn btn-primary btn-sm rounded-circle mr-1 btnEditarCargo' id='" . $cargo[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarCargo'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btn-sm rounded-circle btnEliminarCargo' id='" . $cargo[$i]["id"] . "'><i class='fa fa-trash'></i></button></div></td>";
        
      $datosJson .= '[
      "' . ($i + 1) . '",
      "' . $nombre . '",
      "' . $sueldo . '",
      "' . $botones . '"
    ],';
    }

    $datosJson = substr($datosJson, 0, -1);

    $datosJson .= ']}';

    echo $datosJson;
  }
}

/*=============================================
ACTIVAR TABLA CARGOS
=============================================*/
$activarCargo = new tablaCargo();
$activarCargo->mostrarTablaCargo();
