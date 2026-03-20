// Función que recibe la operación seleccionada como parámetro
function calcular(operacion) {

    // 1. Obtener los valores de las cajas de texto
    // Usamos parseFloat() para convertir el texto a números, permitiendo decimales
    let num1 = parseFloat(document.getElementById("numero1").value);
    let num2 = parseFloat(document.getElementById("numero2").value);

    // Obtenemos el contenedor donde inyectaremos el resultado
    let cajaResultado = document.getElementById("resultado");

    // 2. Validación: Revisar que las cajas no estén vacías
    // isNaN significa "Is Not a Number" (Si no es un número)
    if (isNaN(num1) || isNaN(num2)) {
        cajaResultado.innerHTML = "<span style='color: red;'>Por favor, ingresa ambos números en las cajas.</span>";
        return; // Detiene la ejecución aquí si faltan datos
    }

    let resultadoCalculo = 0;
    let simbolo = "";

    // 3. Evaluar qué operación hacer dependiendo del botón presionado
    if (operacion === 'suma') {
        resultadoCalculo = num1 + num2;
        simbolo = "+";
    } else if (operacion === 'resta') {
        resultadoCalculo = num1 - num2;
        simbolo = "-";
    } else if (operacion === 'division') {
        // Validar división entre cero
        if (num2 === 0) {
            cajaResultado.innerHTML = "<span style='color: red;'>Error: No se puede dividir entre cero.</span>";
            return;
        }
        resultadoCalculo = num1 / num2;
        simbolo = "/";
    } else if (operacion === 'exponente') {
        resultadoCalculo = num1 ** num2;
        simbolo = "**";
    }

    // 4. Imprimir el resultado en la página usando innerHTML
    cajaResultado.innerHTML = `<strong>Resultado:</strong> <br> ${num1} ${simbolo} ${num2} = <span style='color: #004a99; font-size: 1.5em;'>${resultadoCalculo}</span>`;
}