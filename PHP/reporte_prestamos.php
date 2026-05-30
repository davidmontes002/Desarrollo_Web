<?php
// Incluimos la conexión a la BD
include 'conexion.php';

// Variables para los filtros
$where_clause = "1=1"; // Condición base que siempre es verdadera
$estado_filtro = isset($_GET['estado_prestamo']) ? $_GET['estado_prestamo'] : '';
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

// Construimos la consulta dinámicamente según los filtros aplicados
if ($estado_filtro != '') {
    $where_clause .= " AND p.estado_prestamo = '" . $conn->real_escape_string($estado_filtro) . "'";
}
if ($fecha_inicio != '') {
    $where_clause .= " AND p.fecha_solicitud >= '" . $conn->real_escape_string($fecha_inicio) . " 00:00:00'";
}
if ($fecha_fin != '') {
    $where_clause .= " AND p.fecha_solicitud <= '" . $conn->real_escape_string($fecha_fin) . " 23:59:59'";
}

// CONSULTA PRINCIPAL CON MÚLTIPLES JOINS
$sql_reporte = "
    SELECT 
        p.id_prestamo, 
        p.fecha_solicitud, 
        p.fecha_devolucion, 
        p.estado_prestamo,
        u.nombre_completo, 
        u.tipo, 
        u.matricula_empleado,
        e.nombre AS nombre_equipo,
        c.nombre AS nombre_carrera,
        ua.nombre AS nombre_facultad
    FROM prestamos p
    JOIN usuarios u ON p.id_usuario = u.id_usuario
    JOIN equipos e ON p.id_equipo = e.id_equipo
    LEFT JOIN carreras c ON u.id_carrera = c.id_carrera
    LEFT JOIN unidades_academicas ua ON c.id_unidad = ua.id_unidad
    WHERE $where_clause
    ORDER BY p.fecha_solicitud DESC
";

$resultado_reporte = $conn->query($sql_reporte);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Préstamos</title>
    <link rel="stylesheet" href="estilos_final.css">
    <style>
        .caja-filtros {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #D9B504;
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .grupo-filtro {
            display: flex;
            flex-direction: column;
            text-align: left;
        }
        .grupo-filtro label {
            color: #D9B504;
            font-size: 0.9em;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .caja-filtros input, .caja-filtros select {
            padding: 8px;
            border: 1px solid #F27405;
            border-radius: 4px;
            background-color: #0D0D0D;
            color: white;
        }
        .btn-filtrar {
            background-color: #F25C05;
            color: white;
            padding: 9px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-filtrar:hover { background-color: #F27405; }
        
        .estado-activo { color: #F23005; font-weight: bold; } /* Rojo */
        .estado-devuelto { color: #4CAF50; font-weight: bold; } /* Verde */
    </style>
</head>
<body>

    <a href="practica_final.php" class="btn-regresar">⬅ Regresar al Menú</a>

    <h1>Reporte Histórico de Préstamos</h1>

    <div class="crud-contenedor" style="max-width: 1000px;">
        
        <form method="GET" action="reporte_prestamos.php" class="caja-filtros">
            <div class="grupo-filtro">
                <label>Estado del Préstamo:</label>
                <select name="estado_prestamo">
                    <option value="">Todos los estados</option>
                    <option value="Activo" <?php if($estado_filtro == 'Activo') echo 'selected'; ?>>Activo (Sin devolver)</option>
                    <option value="Devuelto" <?php if($estado_filtro == 'Devuelto') echo 'selected'; ?>>Devuelto</option>
                </select>
            </div>
            <div class="grupo-filtro">
                <label>Desde (Fecha):</label>
                <input type="date" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
            </div>
            <div class="grupo-filtro">
                <label>Hasta (Fecha):</label>
                <input type="date" name="fecha_fin" value="<?php echo $fecha_fin; ?>">
            </div>
            <button type="submit" class="btn-filtrar">🔍 Filtrar Datos</button>
            <a href="reporte_prestamos.php" style="color: #D9B504; text-decoration: none; font-size: 0.9em; margin-left: 10px;">Limpiar</a>
        </form>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Solicitud</th>
                        <th>Solicitante</th>
                        <th>Carrera / Facultad</th>
                        <th>Equipo</th>
                        <th>Estado</th>
                        <th>Fecha Devolución</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($resultado_reporte->num_rows > 0): ?>
                        <?php while($fila = $resultado_reporte->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $fila['id_prestamo']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($fila['fecha_solicitud'])); ?></td>
                            <td>
                                <?php echo htmlspecialchars($fila['nombre_completo']); ?><br>
                                <span style="font-size: 0.8em; color: #aaa;">(<?php echo htmlspecialchars($fila['tipo']); ?> - <?php echo htmlspecialchars($fila['matricula_empleado']); ?>)</span>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($fila['nombre_carrera']); ?><br>
                                <span style="font-size: 0.8em; color: #D9B504;"><?php echo htmlspecialchars($fila['nombre_facultad']); ?></span>
                            </td>
                            <td><strong><?php echo htmlspecialchars($fila['nombre_equipo']); ?></strong></td>
                            <td>
                                <?php if($fila['estado_prestamo'] == 'Activo'): ?>
                                    <span class="estado-activo">Activo</span>
                                <?php else: ?>
                                    <span class="estado-devuelto">Devuelto</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $fila['fecha_devolucion'] ? date('d/m/Y H:i', strtotime($fila['fecha_devolucion'])) : '- - -'; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px;">No se encontraron registros de préstamos con estos filtros.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>