function generarTablas() {
    let contenedor = document.getElementById("contenedor-tablas");
    let contenidoHTML = ""; // Aquí iremos acumulando todo el texto HTML

    // Ciclo externo: Repite 10 veces (crea las 10 tarjetas de tablas)
    for (let i = 1; i <= 10; i++) {

        // Abrimos la tarjeta y ponemos el título de la tabla
        contenidoHTML += `
            <div class="tarjeta-tabla">
                <h3>Tabla del ${i}</h3>
                <ul>
        `;

        // Ciclo interno: Repite 10 veces por CADA tabla (crea las multiplicaciones)
        for (let j = 1; j <= 10; j++) {
            let multiplicacion = i * j;
            // Agregamos cada operación a la lista
            contenidoHTML += `<li>${i} x ${j} = <strong>${multiplicacion}</strong></li>`;
        }

        // Cerramos la lista y la tarjeta
        contenidoHTML += `
                </ul>
            </div>
        `;
    }

    // Finalmente, inyectamos todo ese HTML acumulado en nuestro contenedor vacío de la página
    contenedor.innerHTML = contenidoHTML;
}