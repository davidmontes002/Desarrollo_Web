<?php
// ==========================================
// 1. CONFIGURACIÓN DE LA BASE DE DATOS
// ==========================================
$servidor = "sql100.infinityfree.com";     // CAMBIAR por tu Host name
$usuario = "if0_41683681";         // CAMBIAR por tu User name
$password = "ObVaQKSAsQlMOET";   // CAMBIAR por tu Password
$base_datos = "if0_41683681_crud";  // CAMBIAR por tu Database Name

// Intentamos la conexión
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);
$mensaje = "";

if ($conexion->connect_error) {
    $mensaje = "<div style='color:red; padding:10px; background:#f8d7da;'>Error de conexión: Revisa tus credenciales de InfinityFree en la línea 5 del código.</div>";
} else {
    // 2. Auto-crear la tabla si no existe
    $sql_tabla = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombres VARCHAR(50) NOT NULL,
        apellidos VARCHAR(50) NOT NULL,
        correo VARCHAR(50) NOT NULL,
        contrasena VARCHAR(50) NOT NULL
    )";
    $conexion->query($sql_tabla);

    // ==========================================
    // 3. PROCESAR FORMULARIOS (POST) Y ELIMINAR (GET)
    // ==========================================
    
    // Si se envió un formulario (Registrar o Modificar)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $conexion->real_escape_string($_POST['nombres']);
        $ape = $conexion->real_escape_string($_POST['apellidos']);
        $cor = $conexion->real_escape_string($_POST['correo']);
        $con = $conexion->real_escape_string($_POST['contrasena']);

        if (isset($_POST['btn_registrar'])) {
            $sql = "INSERT INTO usuarios (nombres, apellidos, correo, contrasena) VALUES ('$nom', '$ape', '$cor', '$con')";
            if ($conexion->query($sql) === TRUE) {
                $mensaje = "<div style='color:green; padding:10px; background:#d4edda;'>Usuario registrado exitosamente.</div>";
            }
        } elseif (isset($_POST['btn_modificar'])) {
            $id = intval($_POST['id']);
            $sql = "UPDATE usuarios SET nombres='$nom', apellidos='$ape', correo='$cor', contrasena='$con' WHERE id=$id";
            if ($conexion->query($sql) === TRUE) {
                $mensaje = "<div style='color:blue; padding:10px; background:#cce5ff;'>Usuario modificado correctamente.</div>";
            }
        }
    }

    // Si se hizo clic en el botón Eliminar
    if (isset($_GET['eliminar'])) {
        $id = intval($_GET['eliminar']);
        $sql = "DELETE FROM usuarios WHERE id=$id";
        if ($conexion->query($sql) === TRUE) {
            $mensaje = "<div style='color:red; padding:10px; background:#f8d7da;'>Usuario eliminado.</div>";
        }
    }
}

// Control de navegación: ¿Qué pantalla estamos viendo?
$vista = isset($_GET['vista']) ? $_GET['vista'] : 'consultar';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 36 - CRUD PHP MySQL</title>
    <link rel="stylesheet" href="estilos_php.css">
    <style>
        /* Estilos adicionales para la tabla de resultados */
        .tabla-crud { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.9em; }
        .tabla-crud th, .tabla-crud td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .tabla-crud th { background-color: #004a99; color: white; }
        .btn-editar { background-color: #ffc107; color: #000; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-eliminar { background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .menu-crud { margin-bottom: 20px; display: flex; gap: 10px; }
    </style>
</head>
<body>
    <a href="index.php" class="btn-regresar">Volver al Menú PHP</a>
    <h1>Gestión de Usuarios (CRUD)</h1>
    
    <div class="contenedor" style="max-width: 800px;">
        
        <div class="menu-crud">
            <a href="practica_36.php?vista=registrar" class="btn-submit" style="background:#28a745; text-decoration:none; text-align:center;">Registrar Nuevo</a>
            <a href="practica_36.php?vista=consultar" class="btn-submit" style="background:#004a99; text-decoration:none; text-align:center;">Consultar Lista</a>
        </div>

        <?php echo $mensaje; ?>

        <?php if ($vista == 'registrar'): ?>
            <h2 style="color: #28a745;">Registrar Usuario</h2>
            <form method="POST" action="practica_36.php?vista=consultar">
                <div class="grupo-input"><label>Nombre(s):</label><input type="text" name="nombres" required></div>
                <div class="grupo-input"><label>Apellidos(s):</label><input type="text" name="apellidos" required></div>
                <div class="grupo-input"><label>Correo electrónico:</label><input type="email" name="correo" required></div>
                <div class="grupo-input"><label>Contraseña:</label><input type="text" name="contrasena" required></div>
                <button type="submit" name="btn_registrar" class="btn-submit" style="background:#28a745;">Guardar Usuario</button>
            </form>

        <?php elseif ($vista == 'editar' && isset($_GET['id'])): 
            $id = intval($_GET['id']);
            $resultado = $conexion->query("SELECT * FROM usuarios WHERE id=$id");
            if ($fila = $resultado->fetch_assoc()):
        ?>
            <h2 style="color: #ffc107;">Modificar Usuario</h2>
            <form method="POST" action="practica_36.php?vista=consultar">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                <div class="grupo-input"><label>Nombre(s):</label><input type="text" name="nombres" value="<?php echo $fila['nombres']; ?>" required></div>
                <div class="grupo-input"><label>Apellidos(s):</label><input type="text" name="apellidos" value="<?php echo $fila['apellidos']; ?>" required></div>
                <div class="grupo-input"><label>Correo electrónico:</label><input type="email" name="correo" value="<?php echo $fila['correo']; ?>" required></div>
                <div class="grupo-input"><label>Contraseña:</label><input type="text" name="contrasena" value="<?php echo $fila['contrasena']; ?>" required></div>
                <button type="submit" name="btn_modificar" class="btn-submit" style="background:#ffc107; color:black;">Actualizar Datos</button>
            </form>
        <?php 
            endif;

        else: ?>
            <h2 style="color: #004a99;">Lista de Usuarios</h2>
            <div style="overflow-x: auto;">
                <table class="tabla-crud">
                    <tr>
                        <th>ID</th><th>Nombres</th><th>Apellidos</th><th>Correo</th><th>Contraseña</th><th>Acciones</th>
                    </tr>
                    <?php
                    if (!$conexion->connect_error) {
                        $resultado = $conexion->query("SELECT * FROM usuarios ORDER BY id DESC");
                        if ($resultado->num_rows > 0) {
                            while($fila = $resultado->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $fila['id'] . "</td>";
                                echo "<td>" . $fila['nombres'] . "</td>";
                                echo "<td>" . $fila['apellidos'] . "</td>";
                                echo "<td>" . $fila['correo'] . "</td>";
                                echo "<td>" . $fila['contrasena'] . "</td>";
                                echo "<td>
                                        <a href='practica_36.php?vista=editar&id=" . $fila['id'] . "' class='btn-editar'>Editar</a>
                                        <a href='practica_36.php?eliminar=" . $fila['id'] . "' class='btn-eliminar' onclick='return confirm(\"¿Estás seguro de eliminar a este usuario?\")'>Eliminar</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center;'>No hay usuarios registrados aún.</td></tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        <?php endif; ?>
        
    </div>
</body>
</html>