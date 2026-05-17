<?php
$resultadoHTML = "<em>Ingresa los grados Celsius para convertir...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $celsius = floatval($_POST['celsius']);
    
    // Fórmula: Fahrenheit = Celsius * 9/5 + 32
    $fahrenheit = ($celsius * 9 / 5) + 32;
    
    // number_format asegura que siempre muestre el .0 si es exacto
    $fahrenheit_formateado = number_format($fahrenheit, 1, '.', '');
    
    $resultadoHTML = "<span style='color: #004a99; font-weight: bold; font-size: 1.2em;'>$celsius Celsius = $fahrenheit_formateado Fahrenheit</span>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 28 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Conversión de Temperatura</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Grados Celsius:</label>
                <input type="number" step="any" name="celsius" placeholder="Ej. 25" required>
            </div>
            <button type="submit" class="btn-submit">Convertir a Fahrenheit</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>