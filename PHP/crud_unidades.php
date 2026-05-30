<?php
// Incluimos la conexión a la BD
include 'conexion.php';

$id_editar = '';
$nombre_editar = '';
$modo_edicion = false;

// 1. PROCESAR FORMULARIO (Crear o Actualizar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guardar'])) {
        // Lógica para CREAR
        $nombre = trim($_POST['nombre']);
        $stmt = $conn->prepare("INSERT INTO unidades_academicas (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        header("Location: crud_unidades.php"); // Recarga limpia
        exit();
    } elseif (isset($_POST['actualizar'])) {
        // Lógica para ACTUALIZAR
        $id_unidad = $_POST['id_unidad'];
        $nombre = trim($_POST['nombre']);
        $stmt = $conn->prepare("UPDATE unidades_academicas SET nombre = ? WHERE id_unidad = ?");
        $stmt->bind_param("si", $nombre, $id_unidad);
        $stmt->execute();
        header("Location: crud_unidades.php");
        exit();
    }
}

// 2. PROCESAR ELIMINACIÓN (Delete)
if (isset($_GET['eliminar'])) {
    $id_unidad = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM unidades_academicas WHERE id_unidad = ?");
    $stmt->bind_param("i", $id_unidad);
    $stmt->execute();
    header("Location: crud_unidades.php");
    exit();
}

// 3. PREPARAR MODO EDICIÓN
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $modo_edicion = true;
    $stmt = $conn->prepare("SELECT nombre FROM unidades_academicas WHERE id_unidad = ?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nombre_editar = $row['nombre'];
    }
}

// 4. LEER TODOS LOS REGISTROS
$resultado = $conn->query("SELECT * FROM unidades_academicas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Unidades Académicas</title>
    <link rel="stylesheet" href="estilos_final.css">
</head>
<body>

    <a href="practica_final.php" class="btn-regresar">⬅ Regresar al Menú</a>

    <h1>Gestión de Unidades Académicas</h1>

    <div class="crud-contenedor">
        <h2><?php echo $modo_edicion ? 'Editar Unidad' : 'Registrar Nueva Unidad'; ?></h2>
        
        <form method="POST" action="crud_unidades.php" class="formulario-crud">
            <?php if($modo_edicion): ?>
                <input type="hidden" name="id_unidad" value="<?php echo $id_editar; ?>">
            <?php endif; ?>
            
            <input type="text" name="nombre" value="<?php echo $nombre_editar; ?>" placeholder="Ej. Facultad de Ingeniería Mochis" required>
            
            <?php if($modo_edicion): ?>
                <button type="submit" name="actualizar" style="background-color: #D9B504; color: #0D0D0D;">Actualizar</button>
                <a href="crud_unidades.php" class="btn-eliminar" style="margin-left: 10px;">Cancelar</a>
            <?php else: ?>
                <button type="submit" name="guardar">Guardar</button>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Unidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id_unidad']; ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td>
                        <a href="crud_unidades.php?editar=<?php echo $fila['id_unidad']; ?>" class="btn-editar">Editar</a>
                        <a href="crud_unidades.php?eliminar=<?php echo $fila['id_unidad']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar esta unidad?');">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>