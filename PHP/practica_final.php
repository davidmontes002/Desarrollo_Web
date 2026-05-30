<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú - Práctica Final</title>
    <link rel="stylesheet" href="estilos_final.css">
</head>
<body>

    <a href="index.php" class="btn-regresar">⬅ Regresar al Menú Principal</a>

    <h1>Sistema de Préstamos de Equipos</h1>
    <p>Selecciona el módulo que deseas administrar:</p>

    <div class="contenedor-modulos">
        <div class="modulo-seccion">
            <h2>Gestión (CRUDs)</h2>
            <ul class="menu-final">
                <li><a href="crud_unidades.php">Unidades Académicas</a></li>
                <li><a href="crud_carreras.php">Carreras</a></li>
                <li><a href="crud_usuarios.php">Usuarios (Alumnos/Maestros)</a></li>
                <li><a href="crud_equipos.php">Equipos y Proyectores</a></li>
            </ul>
        </div>

        <div class="modulo-seccion">
            <h2>Operaciones</h2>
            <ul class="menu-final">
                <li><a href="solicitar_prestamo.php" class="btn-destacado">Solicitar Préstamo de Equipo</a></li>
                <li><a href="reporte_prestamos.php" class="btn-reporte">Generar Reporte de Préstamos</a></li>
            </ul>
        </div>
    </div>

</body>
</html>