<?php
$resultadoHTML = "<em>El resultado aparecerá aquí...</em>";

// Si el formulario fue enviado mediante POST...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = floatval($_POST['num1']);
    $num2 = floatval($_POST['num2']);
    $operacion = $_POST['operacion'];

    if ($operacion == 'suma') {
        $res = $num1 + $num2;
        $simbolo = "+";
    } elseif ($operacion == 'resta') {
        $res = $num1 - $num2;
        $simbolo = "-";
    } elseif ($operacion == 'division') {
        if ($num2 == 0) {
            $res = "Error: División por cero";
            $simbolo = "/";
        } else {
            $res = $num1 / $num2;
            $simbolo = "/";
        }
    } elseif ($operacion == 'exponente') {
        $res = pow($num1, $num2);
        $simbolo = "^";
    }
    
    $resultadoHTML = "<strong>Resultado:</strong> <br> $num1 $simbolo $num2 = <span style='color: #004a99;'>$res</span>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 21 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Calculadora PHP</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Número 1:</label>
                <input type="number" step="any" name="num1" required>
            </div>
            <div class="grupo-input">
                <label>Número 2:</label>
                <input type="number" step="any" name="num2" required>
            </div>
            <div class="grupo-input">
                <label>Operación:</label>
                <select name="operacion" style="width: 100%; padding: 10px;">
                    <option value="suma">Sumar (+)</option>
                    <option value="resta">Restar (-)</option>
                    <option value="division">Dividir (/)</option>
                    <option value="exponente">Exponenciar (^)</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Calcular en el Servidor</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>