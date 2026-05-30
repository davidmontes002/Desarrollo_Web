<?php
// Incluimos la conexión a la BD
include 'conexion.php';

$id_editar = '';
$nombre_editar = '';
$tipo_editar = '';
$matricula_editar = '';
$id_carrera_editar = '';
$modo_edicion = false;

// 1. PROCESAR FORMULARIO (Crear o Actualizar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guardar'])) {
        $nombre = trim($_POST['nombre_completo']);
        $tipo = $_POST['tipo'];
        $matricula = trim($_POST['matricula_empleado']);
        $id_carrera = $_POST['id_carrera'];
        
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, tipo, matricula_empleado, id_carrera) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $tipo, $matricula, $id_carrera);
        $stmt->execute();
        header("Location: crud_usuarios.php");
        exit();
    } elseif (isset($_POST['actualizar'])) {
        $id_usuario = $_POST['id_usuario'];
        $nombre = trim($_POST['nombre_completo']);
        $tipo = $_POST['tipo'];
        $matricula = trim($_POST['matricula_empleado']);
        $id_carrera = $_POST['id_carrera'];
        
        $stmt = $conn->prepare("UPDATE usuarios SET nombre_completo = ?, tipo = ?, matricula_empleado = ?, id_carrera = ? WHERE id_usuario = ?");
        $stmt->bind_param("sssii", $nombre, $tipo, $matricula, $id_carrera, $id_usuario);
        $stmt->execute();
        header("Location: crud_usuarios.php");
        exit();
    }
}

// 2. PROCESAR ELIMINACIÓN
if (isset($_GET['eliminar'])) {
    $id_usuario = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    header("Location: crud_usuarios.php");
    exit();
}

// 3. PREPARAR MODO EDICIÓN
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $modo_edicion = true;
    
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nombre_editar = $row['nombre_completo'];
        $tipo_editar = $row['tipo'];
        $matricula_editar = $row['matricula_empleado'];
        $id_carrera_editar = $row['id_carrera'];
    }
}

// 4. LEER TODOS LOS REGISTROS CON JOIN (Para ver la carrera, no el ID)
$sql_leer = "SELECT u.id_usuario, u.nombre_completo, u.tipo, u.matricula_empleado, c.nombre AS nombre_carrera 
             FROM usuarios u 
             LEFT JOIN carreras c ON u.id_carrera = c.id_carrera";
$resultado = $conn->query($sql_leer);

// 5. OBTENER CARRERAS PARA EL MENÚ DESPLEGABLE
$carreras_disp = $conn->query("SELECT * FROM carreras");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Usuarios</title>
    <link rel="stylesheet" href="estilos_final.css">
    <style>
        /* Ajustes para que el formulario soporte más campos sin romperse */
        .formulario-crud {
            flex-wrap: wrap;
        }
        .formulario-crud input, .formulario-crud select {
            flex: 1 1 45%; 
            padding: 10px;
            border: 1px solid #F27405;
            border-radius: 4px;
            background-color: #0D0D0D;
            color: white;
            margin-bottom: 10px;
        }
        .botones-form {
            width: 100%;
            text-align: right;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <a href="practica_final.php" class="btn-regresar">⬅ Regresar al Menú</a>

    <h1>Gestión de Usuarios</h1>

    <div class="crud-contenedor">
        <h2><?php echo $modo_edicion ? 'Editar Usuario' : 'Registrar Nuevo Usuario'; ?></h2>
        
        <form method="POST" action="crud_usuarios.php" class="formulario-crud">
            <?php if($modo_edicion): ?>
                <input type="hidden" name="id_usuario" value="<?php echo $id_editar; ?>">
            <?php endif; ?>
            
            <input type="text" name="nombre_completo" value="<?php echo $nombre_editar; ?>" placeholder="Ej. David Montes García" required>
            
            <input type="text" name="matricula_empleado" value="<?php echo $matricula_editar; ?>" placeholder="Matrícula / Num. Empleado" required>
            
            <select name="tipo" required>
                <option value="">Selecciona el Tipo...</option>
                <option value="Alumno" <?php if($tipo_editar == 'Alumno') echo 'selected'; ?>>Alumno</option>
                <option value="Maestro" <?php if($tipo_editar == 'Maestro') echo 'selected'; ?>>Maestro</option>
            </select>
            
            <select name="id_carrera" required>
                <option value="">Selecciona una Carrera...</option>
                <?php while($carrera = $carreras_disp->fetch_assoc()): ?>
                    <option value="<?php echo $carrera['id_carrera']; ?>" 
                        <?php if($id_carrera_editar == $carrera['id_carrera']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($carrera['nombre']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <div class="botones-form">
                <?php if($modo_edicion): ?>
                    <button type="submit" name="actualizar" style="background-color: #D9B504; color: #0D0D0D;">Actualizar</button>
                    <a href="crud_usuarios.php" class="btn-eliminar" style="margin-left: 10px;">Cancelar</a>
                <?php else: ?>
                    <button type="submit" name="guardar">Guardar</button>
                <?php endif; ?>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Matrícula</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id_usuario']; ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre_completo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['matricula_empleado']); ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre_carrera']); ?></td>
                    <td>
                        <a href="crud_usuarios.php?editar=<?php echo $fila['id_usuario']; ?>" class="btn-editar">Editar</a>
                        <a href="crud_usuarios.php?eliminar=<?php echo $fila['id_usuario']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>