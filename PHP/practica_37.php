<?php
// 1. INICIAR SESIÓN (Debe ser la línea 1)
session_start();

// 2. CONFIGURACIÓN DE LA BASE DE DATOS (Tus credenciales de InfinityFree)
$servidor = "sql100.infinityfree.com";
$usuario = "if0_41683681";
$password = "ObVaQKSAsQlMOET";
$base_datos = "if0_41683681_crud";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);
$mensaje = "";

// 3. LÓGICA DE CIERRE DE SESIÓN
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: practica_37.php");
    exit();
}

// 4. PROCESAR FORMULARIOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- LÓGICA DE LOGIN ---
    if (isset($_POST['btn_login'])) {
        $email = $conexion->real_escape_string($_POST['correo']);
        $pass = $conexion->real_escape_string($_POST['contrasena']);
        
        $sql = "SELECT * FROM usuarios WHERE correo = '$email' AND contrasena = '$pass'";
        $resultado = $conexion->query($sql);
        
        if ($resultado->num_rows > 0) {
            $datos_usuario = $resultado->fetch_assoc();
            // Guardamos el nombre en la sesión
            $_SESSION['usuario_nombre'] = $datos_usuario['nombres'];
            $_SESSION['usuario_email'] = $datos_usuario['correo'];
            $mensaje = "<div style='color:green;'>¡Bienvenido! Sesión iniciada.</div>";
        } else {
            $mensaje = "<div style='color:red;'>Correo o contraseña incorrectos.</div>";
        }
    }
    
    // --- LÓGICA DE REGISTRO (Reutilizada del Ejercicio 36) ---
    if (isset($_POST['btn_registrar'])) {
        $nom = $conexion->real_escape_string($_POST['nombres']);
        $ape = $conexion->real_escape_string($_POST['apellidos']);
        $cor = $conexion->real_escape_string($_POST['correo']);
        $con = $conexion->real_escape_string($_POST['contrasena']);
        
        $sql = "INSERT INTO usuarios (nombres, apellidos, correo, contrasena) VALUES ('$nom', '$ape', '$cor', '$con')";
        if ($conexion->query($sql) === TRUE) {
            $mensaje = "<div style='color:green;'>Registro exitoso. Ya puedes iniciar sesión.</div>";
        } else {
            $mensaje = "<div style='color:red;'>Error al registrar.</div>";
        }
    }
}

$vista = isset($_GET['vista']) ? $_GET['vista'] : 'login';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 37 - Sesiones PHP</title>
    <link rel="stylesheet" href="estilos_php.css">
    <style>
        .area-exclusiva { background: #e3f2fd; border: 2px dashed #004a99; padding: 30px; border-radius: 10px; text-align: center; }
        .perfil-icon { font-size: 50px; margin-bottom: 10px; }
        .nav-sesion { margin-bottom: 20px; display: flex; justify-content: center; gap: 15px; }
    </style>
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Sistema de Sesiones</h1>

    <div class="contenedor">
        <?php echo $mensaje; ?>

        <?php if (isset($_SESSION['usuario_nombre'])): ?>
            <div class="area-exclusiva">
                <div class="perfil-icon">👤</div>
                <h2>Bienvenido a la Sección Exclusiva</h2>
                <p>Hola, <strong><?php echo $_SESSION['usuario_nombre']; ?></strong>.</p>
                <p>Tu correo registrado es: <em><?php echo $_SESSION['usuario_email']; ?></em></p>
                <p style="color: #666; font-size: 0.9em;">Esta sección solo es visible porque tienes una sesión activa en el servidor.</p>
                <br>
                <a href="practica_37.php?logout=1" class="btn-submit" style="background:#dc3545; text-decoration:none;">Cerrar Sesión</a>
            </div>

        <?php elseif ($vista == 'registrar'): ?>
            <h2>Crear Cuenta Nueva</h2>
            <form method="POST" action="practica_37.php?vista=login">
                <div class="grupo-input"><label>Nombre(s):</label><input type="text" name="nombres" required></div>
                <div class="grupo-input"><label>Apellidos:</label><input type="text" name="apellidos" required></div>
                <div class="grupo-input"><label>Correo:</label><input type="email" name="correo" required></div>
                <div class="grupo-input"><label>Contraseña:</label><input type="password" name="contrasena" required></div>
                <button type="submit" name="btn_registrar" class="btn-submit" style="background:#28a745;">Registrarme</button>
            </form>
            <p><a href="practica_37.php?vista=login">Ya tengo cuenta, iniciar sesión</a></p>

        <?php else: ?>
            <h2>Iniciar Sesión</h2>
            <form method="POST" action="">
                <div class="grupo-input">
                    <label>Correo Electrónico:</label>
                    <input type="email" name="correo" placeholder="usuario@ejemplo.com" required>
                </div>
                <div class="grupo-input">
                    <label>Contraseña:</label>
                    <input type="password" name="contrasena" required>
                </div>
                <button type="submit" name="btn_login" class="btn-submit">Entrar</button>
            </form>
            <hr>
            <p>¿No tienes cuenta? <a href="practica_37.php?vista=registrar">Regístrate aquí</a></p>
        <?php endif; ?>
    </div>
</body>
</html>