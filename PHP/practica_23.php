<?php
$resultadoHTML = "<em>Esperando datos...</em>";
$colorBorde = "#ccc";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $peso = floatval($_POST['peso']);
    $estatura = floatval($_POST['estatura']);

    if ($peso <= 0 || $estatura <= 0) {
        $resultadoHTML = "<span style='color: red;'>Por favor, ingresa valores válidos.</span>";
    } else {
        $imc = $peso / ($estatura * $estatura);
        $imc = number_format($imc, 2); // Redondea a 2 decimales en PHP

        if ($imc < 18.5) {
            $grado = "Bajo peso"; $colorBorde = "#17a2b8";
        } elseif ($imc >= 18.5 && $imc <= 24.9) {
            $grado = "Peso normal"; $colorBorde = "#28a745";
        } elseif ($imc >= 25.0 && $imc <= 29.9) {
            $grado = "Sobrepeso"; $colorBorde = "#ffc107";
        } elseif ($imc >= 30.0 && $imc <= 34.9) {
            $grado = "Obesidad Grado I"; $colorBorde = "#fd7e14";
        } elseif ($imc >= 35.0 && $imc <= 39.9) {
            $grado = "Obesidad Grado II"; $colorBorde = "#dc3545";
        } else {
            $grado = "Obesidad Grado III (Mórbida)"; $colorBorde = "#8b0000";
        }

        $resultadoHTML = "<p>Tu Índice de Masa Corporal es:</p>";
        $resultadoHTML .= "<span style='font-size: 2em; font-weight: bold; color: $colorBorde;'>$imc</span>";
        $resultadoHTML .= "<p>Grado: <strong><span style='color: $colorBorde;'>$grado</span></strong></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 23 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Calculadora IMC PHP</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Peso (kg):</label>
                <input type="number" step="0.1" name="peso" required>
            </div>
            <div class="grupo-input">
                <label>Estatura (metros):</label>
                <input type="number" step="0.01" name="estatura" required>
            </div>
            <button type="submit" class="btn-submit" style="background-color: #e83e8c;">Calcular mi IMC</button>
        </form>

        <div class="caja-resultado" style="border-left-color: <?php echo $colorBorde; ?>;">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>