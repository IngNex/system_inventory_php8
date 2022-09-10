<?php
require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';

$pdf = new FPDF('P', 'mm', array(210, 297));/*100, 150*/

$pdf->AddPage();

$pdf->SetMargins(20, 0, 0);

$pdf->SetTitle("Acta de entrega");

$pdf->SetFont('Arial', 'B', 28);

$id = $_GET['v'];
$idadquisidor = $_GET['cl'];

$config = mysqli_query($conexion, "SELECT * FROM organizacion");
$datos = mysqli_fetch_assoc($config);

/* --- Datos de Aquisidor--- */
$clientes = mysqli_query($conexion, "SELECT * FROM adquisidor WHERE idadquisidor = $idadquisidor");
$datosC = mysqli_fetch_assoc($clientes);


$cargo = mysqli_query($conexion, "SELECT d.*, p.codmateriales, p.descripcion FROM detalle_cargo d INNER JOIN materiales p ON d.id_material = p.codmateriales WHERE d.id_cargo = $id");
$cargos_u = mysqli_fetch_assoc($cargo);

/* --- Datos de Cargo --- */
$id_cargo = $cargos_u['id_cargo'];
$cargo = mysqli_query($conexion, "SELECT * FROM cargos WHERE id = $id_cargo");
$datosCargo = mysqli_fetch_assoc($cargo);

/* --- Datos de Usuario --- */
$id_usuario = $datosCargo['id_usuario'];
$usuario = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $id_usuario");
$datosU = mysqli_fetch_assoc($usuario);

/* --- Datos de Detalle cargo --- */
$ventas = mysqli_query($conexion, "SELECT d.*, p.codmateriales, p.descripcion FROM detalle_cargo d INNER JOIN materiales p ON d.id_material = p.codmateriales WHERE d.id_cargo = $id");


/* -- Titulo de MDM-- */
$pdf->Ln(8);
$pdf->SetTextColor(194, 194, 194);
$pdf->Cell(178, 5, utf8_decode($datos['nombre']), 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(178, 5, utf8_decode("Acta de Entregas"), 0, 1, 'C');
$pdf->Ln(10);

/* Logo de MDM */
$pdf->image("../../assets/img/logo_municipalida.png", 110, 45, 80, 25, 'PNG');

/*------------Datos de la Organización--------------- */
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 5, utf8_decode("Celular: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, $datos['telefono'], 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, utf8_decode("Dirección: "), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, utf8_decode($datos['direccion']), 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 5, "Correo: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(15, 5, utf8_decode($datos['email']), 0, 1, 'L');
$pdf->Ln(8);
/* -------------- Fin organizacion ------------------ */

/* ---------- Detalle de usuario ----------------*/
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(84, 159, 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(170, 10, "Entregada por el usuario", 1, 1, 'C', 1);/* $pdf->Cell(70, 5, "", 1, 1, 'C', 1);*/
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(3);
$pdf->Cell(70, 5, utf8_decode('Usuario'), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode('Correo'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(6);
$pdf->Cell(70, 5, utf8_decode($datosU['nombre']), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode($datosU['correo']), 0, 0, 'L');
$pdf->Ln(10);
/* ---------------Fin usuario----------------- */


/* ---------- Detalle de adquisidor ----------------*/
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(84, 159, 12);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(170, 10, "Recibido por el adquisidor", 1, 1, 'C', 1);/* $pdf->Cell(70, 5, "", 1, 1, 'C', 1);*/
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(3);
$pdf->Cell(70, 5, utf8_decode('Adquisidor'), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode('Teléfono'), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode('Dirección'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(2);
$pdf->Cell(70, 5, utf8_decode($datosC['nombre']), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode($datosC['telefono']), 0, 0, 'L');
$pdf->Cell(50, 5, utf8_decode($datosC['direccion']), 0, 1, 'L');
$pdf->Ln(10);
/* ---------------Fin adquisidor----------------- */

/* Detalle de  Material*/
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(84, 159, 12);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(170, 10, "Materiales a entregar", 1, 1, 'C', 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(3);
$pdf->Cell(50, 5, utf8_decode('Descripción'), 0, 0, 'L');
$pdf->Cell(25, 5, 'Cantidad', 0, 0, 'L');
$pdf->Cell(35, 5, utf8_decode('Valorización'), 0, 0, 'L');
$pdf->Cell(35, 5, utf8_decode('Depreciación'), 0, 0, 'L');
$pdf->Cell(25, 5, 'Total', 0, 1, 'C');


$pdf->SetFont('Arial', '', 10);
$total = 0.00;
$desc = 0.00;
$pdf->Ln(2);
while ($row = mysqli_fetch_assoc($ventas)) {
    $pdf->Cell(50, 5, $row['descripcion'], 0, 0, 'L');
    $pdf->Cell(25, 5, $row['cantidad'], 0, 0, 'C');
    $pdf->Cell(35, 5, $row['monto'], 0, 0, 'C');
    $deprec = $row['depreciacion']*100;
    $pdf->Cell(35, 5, "$deprec %", 0, 0, 'C');
    $sub_total = $row['total'];
    $total = $total + $sub_total;
    $desc = $desc + $row['depreciacion'];
    $pdf->Cell(22, 5, number_format($sub_total, 2, '.', ','), 0, 1, 'R');
}


$pdf->Ln(10);
/*
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(165, 5, utf8_decode('Depreciación Total'), 0, 1, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(165, 5, number_format($desc, 2, '.', ','), 0, 1, 'R');

$pdf->Ln(2);*/
$pdf->SetFont('Arial', 'B', 12.5);
$pdf->Cell(170, 5,utf8_decode("Valorización Total"), 0, 1, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(2);
$pdf->Cell(170, 5, number_format($total, 2, '.', ','), 0, 1, 'R');

$pdf->Output("ventas.pdf", "I");

?>