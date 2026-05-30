<?php
// Incluimos la conexión a la BD
include 'conexion.php';

// 1. PROCESAR NUEVO PRÉSTAMO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prestar'])) {
    $id_usuario = $_POST['id_usuario'];
    $id_equipo = $_POST['id_equipo'];
    
    // Iniciamos una transacción para asegurar que ambas cosas se hagan o ninguna
    $conn->begin_transaction();

    try {
        // A. Insertar el préstamo (fecha_solicitud se pone sola por el DEFAULT CURRENT_TIMESTAMP)
        $stmt1 = $conn->prepare("INSERT INTO prestamos (id_usuario, id_equipo, estado_prestamo) VALUES (?, ?, 'Activo')");
        $stmt1->bind_param("ii", $id_usuario, $id_equipo);
        $stmt1->execute();

        // B. Actualizar el estado del equipo a 'Prestado'
        $stmt2 = $conn->prepare("UPDATE equipos SET estado = 'Prestado' WHERE id_equipo = ?");
        $stmt2->bind_param("i", $id_equipo);
        $stmt2->execute();

        // Si todo sale bien, confirmamos los cambios
        $conn->commit();
        header("Location: solicitar_prestamo.php");
        exit();
    } catch (Exception $e) {
        // Si hay error, deshacemos los cambios
        $conn->rollback();
        echo "Error al procesar el préstamo: " . $e->getMessage();
    }
}

// 2. PROCESAR DEVOLUCIÓN DE EQUIPO
if (isset($_GET['devolver']) && isset($_GET['id_equipo'])) {
    $id_prestamo = $_GET['devolver'];
    $id_equipo = $_GET['id_equipo'];

    $conn->begin_transaction();

    try {
        // A. Marcar el préstamo como devuelto y registrar la fecha actual
        $stmt1 = $conn->prepare("UPDATE prestamos SET estado_prestamo = 'Devuelto', fecha_devolucion = NOW() WHERE id_prestamo = ?");
        $stmt1->bind_param("i", $id_prestamo);
        $stmt1->execute();

        // B. Liberar el equipo cambiándolo a 'Disponible'
        $stmt2 = $conn->prepare("UPDATE equipos SET estado = 'Disponible' WHERE id_equipo = ?");
        $stmt2->bind_param("i", $id_equipo);
        $stmt2->execute();

        $conn->commit();
        header("Location: solicitar_prestamo.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al procesar la devolución: " . $e->getMessage();
    }
}

// 3. CONSULTAS PARA LOS MENÚS DESPLEGABLES
$usuarios = $conn->query("SELECT id_usuario, nombre_completo, matricula_empleado, tipo FROM usuarios");
// ¡Importante! Solo mostramos equipos que estén "Disponible"
$equipos_disponibles = $conn->query("SELECT id_equipo, nombre FROM equipos WHERE estado = 'Disponible'");

// 4. CONSULTAR PRÉSTAMOS ACTIVOS PARA LA TABLA
$sql_activos = "SELECT p.id_prestamo, p.fecha_solicitud, u.nombre_completo, u.tipo, e.id_equipo, e.nombre AS nombre_equipo 
                FROM prestamos p 
                JOIN usuarios u ON p.id_usuario = u.id_usuario 
                JOIN equipos e ON p.id_equipo = e.id_equipo 
                WHERE p.estado_prestamo = 'Activo' 
                ORDER BY p.fecha_solicitud DESC";
$prestamos_activos = $conn->query($sql_activos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Operaciones - Préstamos</title>
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
        .btn-prestar {
            background-color: #F23005;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-prestar:hover { background-color: #F25C05; }
        
        .btn-devolver {
            background-color: #4CAF50; /* Verde para indicar devolución exitosa */
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <a href="practica_final.php" class="btn-regresar">⬅ Regresar al Menú</a>

    <h1>Módulo de Préstamos</h1>

    <div class="crud-contenedor">
        <h2>Registrar Nuevo Préstamo</h2>
        
        <form method="POST" action="solicitar_prestamo.php" class="formulario-crud">
            
            <select name="id_usuario" required>
                <option value="">1. Selecciona al Usuario (Solicitante)...</option>
                <?php while($user = $usuarios->fetch_assoc()): ?>
                    <option value="<?php echo $user['id_usuario']; ?>">
                        <?php echo htmlspecialchars($user['nombre_completo']) . " - " . htmlspecialchars($user['matricula_empleado']) . " (" . $user['tipo'] . ")"; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <select name="id_equipo" required>
                <option value="">2. Selecciona un Equipo Disponible...</option>
                <?php if($equipos_disponibles->num_rows > 0): ?>
                    <?php while($equipo = $equipos_disponibles->fetch_assoc()): ?>
                        <option value="<?php echo $equipo['id_equipo']; ?>">
                            <?php echo htmlspecialchars($equipo['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="" disabled>❌ No hay equipos disponibles en este momento</option>
                <?php endif; ?>
            </select>
            
            <button type="submit" name="prestar" class="btn-prestar">Asignar Préstamo</button>
        </form>

        <hr style="border-color: #F25C05; margin: 30px 0;">

        <h2>Préstamos Activos (Sin Devolver)</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha Solicitud</th>
                    <th>Solicitante</th>
                    <th>Tipo</th>
                    <th>Equipo Prestado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if($prestamos_activos->num_rows > 0): ?>
                    <?php while($prestamo = $prestamos_activos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($prestamo['fecha_solicitud'])); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['nombre_completo']); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['tipo']); ?></td>
                        <td><strong style="color: #D9B504;"><?php echo htmlspecialchars($prestamo['nombre_equipo']); ?></strong></td>
                        <td>
                            <a href="solicitar_prestamo.php?devolver=<?php echo $prestamo['id_prestamo']; ?>&id_equipo=<?php echo $prestamo['id_equipo']; ?>" class="btn-devolver" onclick="return confirm('¿Confirmas que el equipo fue devuelto en buen estado?');">✔ Marcar Devuelto</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No hay equipos prestados en este momento.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>