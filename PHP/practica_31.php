<?php
$resultadoHTML = "<em>Esperando datos...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $edad = intval($_POST['edad']);
    
    if ($edad >= 18) {
        $resultadoHTML = "<span style='color: #28a745; font-weight: bold;'>$nombre puede votar.</span>";
    } else {
        $resultadoHTML = "<span style='color: #dc3545; font-weight: bold;'>$nombre no puede votar.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 31 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Verificador de Edad Electoral</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Nombre:</label>
                <input type="text" name="nombre" placeholder="Ej. María" required>
            </div>
            <div class="grupo-input">
                <label>Edad:</label>
                <input type="number" name="edad" min="0" placeholder="Ej. 25" required>
            </div>
            <button type="submit" class="btn-submit">Verificar</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>