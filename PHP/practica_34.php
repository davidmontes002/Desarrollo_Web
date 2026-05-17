<?php
$resultadoHTML = "<em>Ingresa los montos para calcular...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad = floatval($_POST['cantidad']);
    $tasa = floatval($_POST['tasa']);
    
    $resultado = $cantidad * $tasa;
    
    // Formatear a 2 decimales
    $resultado_formateado = number_format($resultado, 2, '.', '');
    
    $resultadoHTML = "El resultado es <strong>$resultado_formateado</strong>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 34 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Cambio de Divisas</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Cantidad:</label>
                <input type="number" step="any" name="cantidad" placeholder="Ej. 100" required>
            </div>
            <div class="grupo-input">
                <label>Tipo de cambio (tasa):</label>
                <input type="number" step="any" name="tasa" placeholder="Ej. 0.85" required>
            </div>
            <button type="submit" class="btn-submit">Calcular</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>