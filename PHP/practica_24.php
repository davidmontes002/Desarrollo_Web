<?php
// date('w') devuelve 0 para domingo, 6 para sábado
$diaSemana = date('w');
// date('n') devuelve 1 para enero, 12 para diciembre
$mesNum = date('n');
$diaMes = date('j');
$anio = date('Y');

switch ($diaSemana) {
    case 0: $nombreDia = "domingo"; break;
    case 1: $nombreDia = "lunes"; break;
    case 2: $nombreDia = "martes"; break;
    case 3: $nombreDia = "miércoles"; break;
    case 4: $nombreDia = "jueves"; break;
    case 5: $nombreDia = "viernes"; break;
    case 6: $nombreDia = "sábado"; break;
}

switch ($mesNum) {
    case 1: $nombreMes = "Enero"; break;
    case 2: $nombreMes = "Febrero"; break;
    case 3: $nombreMes = "Marzo"; break;
    case 4: $nombreMes = "Abril"; break;
    case 5: $nombreMes = "Mayo"; break;
    case 6: $nombreMes = "Junio"; break;
    case 7: $nombreMes = "Julio"; break;
    case 8: $nombreMes = "Agosto"; break;
    case 9: $nombreMes = "Septiembre"; break;
    case 10: $nombreMes = "Octubre"; break;
    case 11: $nombreMes = "Noviembre"; break;
    case 12: $nombreMes = "Diciembre"; break;
}

$mensajeFecha = "Hoy es $nombreDia $diaMes de $nombreMes del año $anio";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 24 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Fecha Actual (Switch en PHP)</h1>
    
    <div class="contenedor">
        <div class="caja-resultado">
            <strong><?php echo $mensajeFecha; ?></strong>
        </div>
    </div>
</body>
</html>