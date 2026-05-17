<?php
$resultadoHTML = "<em>Ingresa un número entero...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = intval($_POST['numero']);
    
    // Si el residuo de dividir entre 2 es 0, es par
    if ($numero % 2 == 0) {
        $resultadoHTML = "El número $numero es: <strong style='color: #28a745; font-size: 1.5em;'>Par</strong>";
    } else {
        $resultadoHTML = "El número $numero es: <strong style='color: #dc3545; font-size: 1.5em;'>Impar</strong>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 29 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Evaluador Par o Impar</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Número a evaluar:</label>
                <input type="number" name="numero" placeholder="Ej. 7" required>
            </div>
            <button type="submit" class="btn-submit">Verificar</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>