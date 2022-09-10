<?php
include("../conexion.php");
if ($_POST['action'] == 'sales') {
    $arreglo = array();
    $query = mysqli_query($conexion, "SELECT descripcion, existencia FROM materiales WHERE existencia <= 10 ORDER BY existencia ASC LIMIT 10");
    while ($data = mysqli_fetch_array($query)) {
        $arreglo[] = $data;
    }
    echo json_encode($arreglo);
    die();
}
if ($_POST['action'] == 'polarChart') {
    $arreglo = array();
    $query = mysqli_query($conexion, "SELECT p.codmateriales, p.descripcion, d.id_material, d.cantidad, SUM(d.cantidad) as total FROM materiales p INNER JOIN detalle_cargo d WHERE p.codmateriales = d.id_material group by d.id_material ORDER BY d.cantidad DESC LIMIT 5");
    while ($data = mysqli_fetch_array($query)) {
        $arreglo[] = $data;
    }
    echo json_encode($arreglo);
    die();
}
//
?>
