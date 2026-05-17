<?php
$resultadoHTML = "<em>Ingresa los segundos a convertir...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_segundos = intval($_POST['segundos']);
    
    // Una hora tiene 3600 segundos
    $horas = floor($total_segundos / 3600);
    
    // Lo que sobra de las horas, lo usaremos para los minutos
    $resto_segundos = $total_segundos % 3600;
    
    // Un minuto tiene 60 segundos
    $minutos = floor($resto_segundos / 60);
    
    // Lo que sobra finalmente, son los segundos restantes
    $segundos = $resto_segundos % 60;
    
    $resultadoHTML = "$total_segundos segundos corresponden a <strong>{$horas}h, {$minutos}m y {$segundos} s</strong>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 35 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Convertidor de Tiempo</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Total de Segundos:</label>
                <input type="number" min="0" name="segundos" placeholder="Ej. 3661" required>
            </div>
            <button type="submit" class="btn-submit">Convertir Formato</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>