<?php
// Incluimos la conexión a la BD
include 'conexion.php';

$id_editar = '';
$nombre_editar = '';
$estado_editar = '';
$modo_edicion = false;

// 1. PROCESAR FORMULARIO (Crear o Actualizar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guardar'])) {
        $nombre = trim($_POST['nombre']);
        $estado = $_POST['estado'];
        
        $stmt = $conn->prepare("INSERT INTO equipos (nombre, estado) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $estado);
        $stmt->execute();
        header("Location: crud_equipos.php");
        exit();
    } elseif (isset($_POST['actualizar'])) {
        $id_equipo = $_POST['id_equipo'];
        $nombre = trim($_POST['nombre']);
        $estado = $_POST['estado'];
        
        $stmt = $conn->prepare("UPDATE equipos SET nombre = ?, estado = ? WHERE id_equipo = ?");
        $stmt->bind_param("ssi", $nombre, $estado, $id_equipo);
        $stmt->execute();
        header("Location: crud_equipos.php");
        exit();
    }
}

// 2. PROCESAR ELIMINACIÓN
if (isset($_GET['eliminar'])) {
    $id_equipo = $_GET['eliminar'];
    
    // Intentamos eliminar (si un equipo tiene un préstamo asociado, la llave foránea podría bloquearlo por seguridad, lo cual es correcto)
    $stmt = $conn->prepare("DELETE FROM equipos WHERE id_equipo = ?");
    $stmt->bind_param("i", $id_equipo);
    $stmt->execute();
    header("Location: crud_equipos.php");
    exit();
}

// 3. PREPARAR MODO EDICIÓN
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $modo_edicion = true;
    
    $stmt = $conn->prepare("SELECT * FROM equipos WHERE id_equipo = ?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nombre_editar = $row['nombre'];
        $estado_editar = $row['estado'];
    }
}

// 4. LEER TODOS LOS REGISTROS
$resultado = $conn->query("SELECT * FROM equipos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Equipos</title>
    <link rel="stylesheet" href="estilos_final.css">
    <style>
        .formulario-crud select {
            padding: 10px;
            border: 1px solid #F27405;
            border-radius: 4px;
            background-color: #0D0D0D;
            color: white;
            flex-grow: 1;
        }
    </style>
</head>
<body>

    <a href="practica_final.php" class="btn-regresar">⬅ Regresar al Menú</a>

    <h1>Gestión de Equipos</h1>

    <div class="crud-contenedor">
        <h2><?php echo $modo_edicion ? 'Editar Equipo' : 'Registrar Nuevo Equipo'; ?></h2>
        
        <form method="POST" action="crud_equipos.php" class="formulario-crud">
            <?php if($modo_edicion): ?>
                <input type="hidden" name="id_equipo" value="<?php echo $id_editar; ?>">
            <?php endif; ?>
            
            <input type="text" name="nombre" value="<?php echo $nombre_editar; ?>" placeholder="Ej. Proyector Epson X1" required>
            
            <select name="estado" required>
                <option value="">Selecciona el Estado...</option>
                <option value="Disponible" <?php if($estado_editar == 'Disponible') echo 'selected'; ?>>Disponible</option>
                <option value="Prestado" <?php if($estado_editar == 'Prestado') echo 'selected'; ?>>Prestado</option>
                <option value="En Mantenimiento" <?php if($estado_editar == 'En Mantenimiento') echo 'selected'; ?>>En Mantenimiento</option>
            </select>
            
            <?php if($modo_edicion): ?>
                <button type="submit" name="actualizar" style="background-color: #D9B504; color: #0D0D0D;">Actualizar</button>
                <a href="crud_equipos.php" class="btn-eliminar" style="margin-left: 10px;">Cancelar</a>
            <?php else: ?>
                <button type="submit" name="guardar">Guardar</button>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Equipo</th>
                    <th>Estado Actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id_equipo']; ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td>
                        <?php 
                            $color_estado = "white";
                            if($fila['estado'] == 'Disponible') $color_estado = "#4CAF50"; // Verde
                            if($fila['estado'] == 'Prestado') $color_estado = "#F23005"; // Rojo
                            if($fila['estado'] == 'En Mantenimiento') $color_estado = "#D9B504"; // Amarillo
                        ?>
                        <span style="color: <?php echo $color_estado; ?>; font-weight: bold;">
                            <?php echo htmlspecialchars($fila['estado']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="crud_equipos.php?editar=<?php echo $fila['id_equipo']; ?>" class="btn-editar">Editar</a>
                        <a href="crud_equipos.php?eliminar=<?php echo $fila['id_equipo']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este equipo?');">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>