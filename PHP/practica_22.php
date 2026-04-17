<?php
$resultadoHTML = "<em>Esperando valores...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = floatval($_POST['a']);
    $b = floatval($_POST['b']);
    $c = floatval($_POST['c']);

    if ($a == 0) {
        $resultadoHTML = "<span style='color: red;'>Error: El valor de 'a' no puede ser cero.</span>";
    } else {
        $discriminante = pow($b, 2) - (4 * $a * $c);

        if ($discriminante < 0) {
            $resultadoHTML = "<span style='color: red;'>El resultado contiene números imaginarios.</span>";
        } else {
            $x1 = (-$b - sqrt($discriminante)) / (2 * $a);
            $x2 = (-$b + sqrt($discriminante)) / (2 * $a);

            $resultadoHTML = "<strong>Resultados:</strong><br><br>";
            $resultadoHTML .= "x1 = <span style='color: #004a99; font-size: 1.3em;'>$x1</span><br>";
            $resultadoHTML .= "x2 = <span style='color: #004a99; font-size: 1.3em;'>$x2</span>";

            // En PHP podemos imprimir un script de JS para que siga lanzando la alerta que pedía la tarea
            $resultadoHTML .= "<script>window.alert('Cálculo terminado:\\nx1 = $x1\\nx2 = $x2');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 22 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Fórmula General PHP</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Valor de a:</label>
                <input type="number" step="any" name="a" required>
            </div>
            <div class="grupo-input">
                <label>Valor de b:</label>
                <input type="number" step="any" name="b" required>
            </div>
            <div class="grupo-input">
                <label>Valor de c:</label>
                <input type="number" step="any" name="c" required>
            </div>
            <button type="submit" class="btn-submit">Calcular x1 y x2</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>