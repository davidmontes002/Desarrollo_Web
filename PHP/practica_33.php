<?php
$resultadoHTML = "<em>Ingresa dos palabras...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // strtolower convierte a minúsculas y str_replace quita espacios en blanco
    $palabra1 = strtolower(str_replace(' ', '', trim($_POST['palabra1'])));
    $palabra2 = strtolower(str_replace(' ', '', trim($_POST['palabra2'])));
    
    // Convertimos la primera palabra en un arreglo de letras, lo ordenamos y lo volvemos a texto
    $arreglo1 = str_split($palabra1);
    sort($arreglo1);
    $str1_ordenada = implode('', $arreglo1);
    
    // Hacemos lo mismo con la segunda palabra
    $arreglo2 = str_split($palabra2);
    sort($arreglo2);
    $str2_ordenada = implode('', $arreglo2);
    
    // Comparamos
    if ($str1_ordenada === $str2_ordenada) {
        $resultadoHTML = "<span style='color: #28a745; font-size: 2em; font-weight: bold;'>Sí</span>";
    } else {
        $resultadoHTML = "<span style='color: #dc3545; font-size: 2em; font-weight: bold;'>No</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 33 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Verificador de Anagramas</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Palabra 1:</label>
                <input type="text" name="palabra1" placeholder="Ej. listen" required>
            </div>
            <div class="grupo-input">
                <label>Palabra 2:</label>
                <input type="text" name="palabra2" placeholder="Ej. silent" required>
            </div>
            <button type="submit" class="btn-submit">Verificar Anagrama</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>