<?php
$tablasHTML = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Al dar clic al botón, PHP genera las 10 tablas fijas
    $tablasHTML .= "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;'>";
    
    for ($i = 1; $i <= 10; $i++) {
        $tablasHTML .= "<div style='background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-top: 5px solid #004a99;'>";
        $tablasHTML .= "<h3 style='color: #004a99; text-align: center; border-bottom: 2px dashed #eee; padding-bottom: 10px; margin-top: 0;'>Tabla del $i</h3>";
        $tablasHTML .= "<ul style='list-style: none; padding: 0; margin: 0;'>";
        
        for ($j = 1; $j <= 10; $j++) {
            $multiplicacion = $i * $j;
            $fondo = ($j % 2 == 0) ? "background-color: #f9f9f9;" : ""; // Rayas alternas
            $tablasHTML .= "<li style='padding: 5px 0; text-align: center; $fondo'>$i x $j = <strong>$multiplicacion</strong></li>";
        }
        
        $tablasHTML .= "</ul></div>";
    }
    
    $tablasHTML .= "</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 25 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Generador de Tablas (1 al 10) PHP</h1>
    
    <div class="contenedor" style="max-width: 900px; background: transparent; box-shadow: none;">
        <form method="POST" action="">
            <button type="submit" class="btn-submit" style="background-color: #28a745; margin-bottom: 30px;">Generar Tablas (1 al 10)</button>
        </form>

        <?php echo $tablasHTML; ?>
    </div>
</body>
</html>