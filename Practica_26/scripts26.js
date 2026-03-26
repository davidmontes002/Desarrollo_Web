function generarTablas() {
    // 1. Obtener el valor ingresado por el usuario y convertirlo a número entero
    let limite = parseInt(document.getElementById("numeroLimite").value);
    let contenedor = document.getElementById("contenedor-tablas");
    let contenidoHTML = "";

    // 2. Validación: Asegurarnos de que sea un número positivo y mayor a 0
    if (isNaN(limite) || limite <= 0) {
        contenedor.innerHTML = "<p style='color: red; font-weight: bold; text-align: center; width: 100%;'>Por favor, ingresa un número entero positivo mayor a cero.</p>";
        return; // Detenemos la ejecución si el dato es incorrecto
    }

    // 3. Ciclo externo: Desde el 1 hasta el número ingresado por el usuario (limite)
    for (let i = 1; i <= limite; i++) {

        // Empezamos a armar la tarjeta de la tabla
        contenidoHTML += `
            <div class="tarjeta-tabla">
                <h3>Tabla del ${i}</h3>
                <ul>
        `;

        // 4. Ciclo interno: Repite las multiplicaciones del 1 al 10 para cada tabla
        for (let j = 1; j <= 10; j++) {
            let multiplicacion = i * j;
            contenidoHTML += `<li>${i} x ${j} = <strong>${multiplicacion}</strong></li>`;
        }

        // Cerramos la lista y el div de la tarjeta
        contenidoHTML += `
                </ul>
            </div>
        `;
    }

    // 5. Inyectamos todo el HTML generado en la página
    contenedor.innerHTML = contenidoHTML;
}