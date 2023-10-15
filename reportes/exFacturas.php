<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['ventas']==1)
{
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/guiaIngreso.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../public/css/bootstrap.min.css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/Venta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

//Establecemos los datos de la empresa
$empresa = " System Phone Joshua";
$documento = "10477022605";
$direccion = "Av. Dias barcenas 1013 - Abancay - Apurimac";
$telefono = "921206096";


?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="680px">
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        .::<strong> <?php echo $empresa; ?></strong>::.<br>
        <?php echo $documento; ?><br>
        <?php echo $direccion .' - '.$telefono; ?><br>
        
        </td>
    </tr>
    <tr>
      <td class="h5 text-center"><strong><?php echo $reg->tipo_comprobante; ?></strong><br></td>
    </tr>
    <tr>
        <td align="right">Fecha: <?php echo $reg->fecha; ?></td>
    </tr>
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del proveedor en el documento HTML -->
        <td>Cliente: <?php echo $reg->cliente; ?></td>
    </tr>
    <tr>
      <td>Direccion: <?php echo $reg->direccion; ?> </td>
    </tr>
    <tr>
        <td><?php echo $reg->tipo_documento.": ".$reg->num_documento; ?></td>
    </tr>
    
    <tr>
        <td>Nº de Venta: <?php echo $reg->serie_comprobante." - ".$reg->num_comprobante ; ?></td>
    </tr>    
</table>
<br>
<!-- Mostramos los detalles del ingreso en el documento HTML -->
<table class="table table-bordered border-solid m-5" align="center" width="490px">
    <tr>
        <td>CANT.</td>
        <td>DESCRIPCIÓN</td>
        <td>PRECIO VENTA</td>
        <td>DESCUENTO</td>
        <td align="right">IMPORTE</td>
    </tr>
   
    <?php
    $rsptad = $venta->ventadetalle($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td class='text-center'>".$regd->cantidad."</td>";
        echo "<td>".$regd->articulo;
        echo "<td class='text-center'>S/. ".$regd->precio_venta;
        echo "<td class='text-center'>S/. ".$regd->descuento;
        echo "<td align='right'>S/ ".$regd->subtotal."</td>";
        echo "</tr>";
        $cantidad+=$regd->cantidad;
    }
    ?>
    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>
    
    <td colspan="4" align="right"><b>TOTAL:</b></td>
    <td colspan="5"align="right"><b>S/  <?php echo $reg->total_venta;  ?></b></td>
    </tr>
    <tr>
      <td colspan="5">Nº de artículos: <?php echo $cantidad; ?></td>
    </tr>
             
</table>
<br>

      <h6 class="text-center"><strong> Gestor Logistico - Abancay 2023</strong></h6>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>
