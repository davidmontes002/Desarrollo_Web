<?php
$resultadoHTML = "<em>Tus datos de usuario aparecerán aquí...</em>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // str_replace elimina espacios en blanco por si el usuario los pone por error
    $nombre = str_replace(' ', '', trim($_POST['nombre']));
    $apellido = str_replace(' ', '', trim($_POST['apellido']));
    
    // 1. Unir y convertir a minúsculas
    $username = strtolower($nombre . $apellido);
    
    // 2. Extraer primera letra y convertir a mayúsculas
    $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
    
    $resultadoHTML = "Nombre de usuario: <strong>$username</strong><br>";
    $resultadoHTML .= "Iniciales (en mayúsculas): <strong>$iniciales</strong>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 30 PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Generador de Usuarios</h1>
    
    <div class="contenedor">
        <form method="POST" action="">
            <div class="grupo-input">
                <label>Nombre:</label>
                <input type="text" name="nombre" placeholder="Ej. Juan" required>
            </div>
            <div class="grupo-input">
                <label>Apellido:</label>
                <input type="text" name="apellido" placeholder="Ej. Lopez" required>
            </div>
            <button type="submit" class="btn-submit">Generar Usuario</button>
        </form>

        <div class="caja-resultado">
            <?php echo $resultadoHTML; ?>
        </div>
    </div>
</body>
</html>