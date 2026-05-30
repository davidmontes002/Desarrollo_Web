<?php
// Incluimos la conexión a la BD
include 'conexion.php';

$id_editar = '';
$nombre_editar = '';
$id_unidad_editar = '';
$modo_edicion = false;

// 1. PROCESAR FORMULARIO (Crear o Actualizar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guardar'])) {
        $nombre = trim($_POST['nombre']);
        $id_unidad = $_POST['id_unidad'];
        
        $stmt = $conn->prepare("INSERT INTO carreras (nombre, id_unidad) VALUES (?, ?)");
        $stmt->bind_param("si", $nombre, $id_unidad);
        $stmt->execute();
        header("Location: crud_carreras.php");
        exit();
    } elseif (isset($_POST['actualizar'])) {
        $id_carrera = $_POST['id_carrera'];
        $nombre = trim($_POST['nombre']);
        $id_unidad = $_POST['id_unidad'];
        
        $stmt = $conn->prepare("UPDATE carreras SET nombre = ?, id_unidad = ? WHERE id_carrera = ?");
        $stmt->bind_param("sii", $nombre, $id_unidad, $id_carrera);
        $stmt->execute();
        header("Location: crud_carreras.php");
        exit();
    }
}

// 2. PROCESAR ELIMINACIÓN
if (isset($_GET['eliminar'])) {
    $id_carrera = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM carreras WHERE id_carrera = ?");
    $stmt->bind_param("i", $id_carrera);
    $stmt->execute();
    header("Location: crud_carreras.php");
    exit();
}

// 3. PREPARAR MODO EDICIÓN
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $modo_edicion = true;
    
    $stmt = $conn->prepare("SELECT nombre, id_unidad FROM carreras WHERE id_carrera = ?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nombre_editar = $row['nombre'];
        $id_unidad_editar = $row['id_unidad'];
    }
}

// 4. LEER TODOS LOS REGISTROS CON JOIN (Para ver el nombre de la unidad, no solo el ID)
$sql_leer = "SELECT c.id_carrera, c.nombre AS nombre_carrera, u.nombre AS nombre_unidad 
             FROM carreras c 
             LEFT JOIN unidades_academicas u ON c.id_unidad = u.id_unidad";
$resultado = $conn->query($sql_leer);

// 5. OBTENER UNIDADES ACADÉMICAS PARA EL MENÚ DESPLEGABLE
$unidades_disp = $conn->query("SELECT * FROM unidades_academicas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Carreras</title>
    <link rel="stylesheet" href="estilos_final.css">
    <style>
        /* Estilo adicional para el select para que haga juego con el input */
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

    <h1>Gestión de Carreras</h1>

    <div class="crud-contenedor">
        <h2><?php echo $modo_edicion ? 'Editar Carrera' : 'Registrar Nueva Carrera'; ?></h2>
        
        <form method="POST" action="crud_carreras.php" class="formulario-crud">
            <?php if($modo_edicion): ?>
                <input type="hidden" name="id_carrera" value="<?php echo $id_editar; ?>">
            <?php endif; ?>
            
            <input type="text" name="nombre" value="<?php echo $nombre_editar; ?>" placeholder="Ej. Ingeniería de Software" required>
            
            <select name="id_unidad" required>
                <option value="">Selecciona una Unidad Académica...</option>
                <?php while($uni = $unidades_disp->fetch_assoc()): ?>
                    <option value="<?php echo $uni['id_unidad']; ?>" 
                        <?php if($id_unidad_editar == $uni['id_unidad']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($uni['nombre']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <?php if($modo_edicion): ?>
                <button type="submit" name="actualizar" style="background-color: #D9B504; color: #0D0D0D;">Actualizar</button>
                <a href="crud_carreras.php" class="btn-eliminar" style="margin-left: 10px;">Cancelar</a>
            <?php else: ?>
                <button type="submit" name="guardar">Guardar</button>
            <?php endif; ?>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Carrera</th>
                    <th>Unidad Académica</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id_carrera']; ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre_carrera']); ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre_unidad']); ?></td>
                    <td>
                        <a href="crud_carreras.php?editar=<?php echo $fila['id_carrera']; ?>" class="btn-editar">Editar</a>
                        <a href="crud_carreras.php?eliminar=<?php echo $fila['id_carrera']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar esta carrera?');">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>