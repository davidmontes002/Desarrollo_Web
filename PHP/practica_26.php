<?php
$tablasHTML = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $limite = intval($_POST['limite']);
    
    if ($limite > 0) {
        $tablasHTML .= "<div style='display: flex; flex-wrap: wrap; gap: 15px;'>";
        for ($i = 1; $i <= $limite; $i++) {
            $tablasHTML .= "<div style='background: #f9f9f9; padding: 15px; border: 1px solid #ccc;'>";
            $tablasHTML .= "<h3 style='color: #f07b55; margin-top:0;'>Tabla del $i</h3>";
            for ($j = 1; $j <= 10; $j++) {
                $res = $i * $j;
                $tablasHTML .= "$i x $j = <strong>$res</strong><br>";
            }
            $tablasHTML .= "</div>";
        }
        $tablasHTML .= "</div>";
    } else {
        $tablasHTML = "Ingresa un número válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 26 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Tablas Dinámicas PHP</h1>
    
    <div class="contenedor" style="max-width: 800px;">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>¿Hasta qué tabla deseas generar?</label>
                <input type="number" min="1" name="limite" required>
            </div>
            <button type="submit" class="btn-submit">Generar Tablas</button>
        </form>

        <div style="margin-top: 20px;">
            <?php echo $tablasHTML; ?>
        </div>
    </div>
</body>
</html>