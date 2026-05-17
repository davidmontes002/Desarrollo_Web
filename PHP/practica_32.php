<?php
$resultadoHTML = "<em>Ingresa tu puntuación...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $puntuacion = floatval($_POST['puntuacion']);
    
    if ($puntuacion >= 90) {
        $letra = "A";
        $color = "#28a745"; // Verde
    } elseif ($puntuacion >= 80) {
        $letra = "B";
        $color = "#17a2b8"; // Azul claro
    } elseif ($puntuacion >= 70) {
        $letra = "C";
        $color = "#ffc107"; // Amarillo
    } elseif ($puntuacion >= 60) {
        $letra = "D";
        $color = "#fd7e14"; // Naranja
    } else {
        $letra = "F";
        $color = "#dc3545"; // Rojo
    }
    
    $resultadoHTML = "Puntuación obtenida: $puntuacion <br>";
    $resultadoHTML .= "Calificación: <strong style='color: $color; font-size: 1.8em;'>$letra</strong>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 32 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Calculadora de Calificaciones</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Puntuación (0 a 100):</label>
                <input type="number" step="any" name="puntuacion" min="0" max="100" placeholder="Ej. 85" required>
            </div>
            <button type="submit" class="btn-submit">Calcular Calificación</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>