function calcularRaices() {
    // 1. Obtener los valores capturados en el formulario
    let a = parseFloat(document.getElementById("valorA").value);
    let b = parseFloat(document.getElementById("valorB").value);
    let c = parseFloat(document.getElementById("valorC").value);

    let cajaResultado = document.getElementById("resultado");

    // 2. Validación: 'a' no puede ser 0 porque la fórmula divide entre 2a
    if (a === 0) {
        cajaResultado.innerHTML = "<span style='color: red;'>Error: El valor de 'a' no puede ser cero.</span>";
        return;
    }

    // 3. Calculamos el discriminante (lo que va dentro de la raíz: b^2 - 4ac)
    let discriminante = (b ** 2) - (4 * a * c);

    // 4. Validamos que la raíz no sea negativa (para evitar números imaginarios)
    if (discriminante < 0) {
        cajaResultado.innerHTML = "<span style='color: red;'>El resultado contiene números imaginarios (la raíz cuadrada es negativa).</span>";
    } else {
        // 5. Aplicamos la fórmula exacta de tu imagen

        // x1 con el signo MENOS (-) antes de la raíz
        let x1 = (-b - Math.sqrt(discriminante)) / (2 * a);

        // x2 con el signo MÁS (+) antes de la raíz
        let x2 = (-b + Math.sqrt(discriminante)) / (2 * a);

        // 6. Imprimimos el resultado en pantalla y en la alerta
        let mensaje = `<strong>Resultados:</strong><br><br>
                       x1 = <span style='color: #004a99; font-size: 1.3em;'>${x1}</span> <br>
                       x2 = <span style='color: #004a99; font-size: 1.3em;'>${x2}</span>`;

        cajaResultado.innerHTML = mensaje;
        window.alert(`Cálculo terminado:\nx1 = ${x1}\nx2 = ${x2}`);
    }
}