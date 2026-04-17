function calcularIMC() {
    // 1. Obtener los valores ingresados
    let peso = parseFloat(document.getElementById("peso").value);
    let estatura = parseFloat(document.getElementById("estatura").value);
    let cajaResultado = document.getElementById("resultado");

    // 2. Validación básica de datos
    if (peso <= 0 || estatura <= 0 || isNaN(peso) || isNaN(estatura)) {
        cajaResultado.innerHTML = "<span style='color: red;'>Por favor, ingresa valores válidos mayores a cero.</span>";
        return;
    }

    // 3. Fórmula del IMC: Peso (kg) / Estatura al cuadrado (m)
    let imc = peso / (estatura * estatura);

    // Redondear a dos decimales para que sea fácil de leer
    imc = imc.toFixed(2);

    // 4. Variables para almacenar el grado y el color visual del mensaje
    let grado = "";
    let color = "";

    // 5. Condicionales para determinar el grado según los valores estándar
    if (imc < 18.5) {
        grado = "Bajo peso";
        color = "#17a2b8"; // Azul claro
    } else if (imc >= 18.5 && imc <= 24.9) {
        grado = "Peso normal";
        color = "#28a745"; // Verde
    } else if (imc >= 25.0 && imc <= 29.9) {
        grado = "Sobrepeso";
        color = "#ffc107"; // Amarillo/Naranja
    } else if (imc >= 30.0 && imc <= 34.9) {
        grado = "Obesidad Grado I";
        color = "#fd7e14"; // Naranja fuerte
    } else if (imc >= 35.0 && imc <= 39.9) {
        grado = "Obesidad Grado II";
        color = "#dc3545"; // Rojo
    } else {
        grado = "Obesidad Grado III (Mórbida)";
        color = "#8b0000"; // Rojo oscuro
    }

    // 6. Imprimir el resultado en la página
    cajaResultado.style.borderColor = color; // Cambiamos el color del borde dinámicamente
    cajaResultado.innerHTML = `
        <p>Tu Índice de Masa Corporal es:</p>
        <span style='font-size: 2em; font-weight: bold; color: ${color};'>${imc}</span>
        <p>Grado: <strong><span style='color: ${color};'>${grado}</span></strong></p>
    `;
}