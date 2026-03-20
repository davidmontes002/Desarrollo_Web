// 1. Declaración de las 2 variables y asignación de valores
let numeroA = 8;
let numeroB = 2;

// 2. Realizamos las operaciones aritméticas
let suma = numeroA + numeroB;
let resta = numeroA - numeroB;
let division = numeroA / numeroB;
let exponenciacion = numeroA ** numeroB; // También se puede usar Math.pow(numeroA, numeroB)

// 3. Imprimimos en la página web utilizando innerHTML
// Usamos "Template Literals" (las comillas invertidas ``) para poder combinar texto y variables fácilmente.
document.getElementById("resultados").innerHTML = `
    <p><strong>Valores iniciales:</strong> Variable A = ${numeroA} | Variable B = ${numeroB}</p>
    <ul>
        <li><strong>Suma (+):</strong> ${numeroA} + ${numeroB} = <span style="color: #004a99; font-weight: bold;">${suma}</span></li>
        <li><strong>Resta (-):</strong> ${numeroA} - ${numeroB} = <span style="color: #004a99; font-weight: bold;">${resta}</span></li>
        <li><strong>División (/):</strong> ${numeroA} / ${numeroB} = <span style="color: #004a99; font-weight: bold;">${division}</span></li>
        <li><strong>Exponenciación (**):</strong> ${numeroA} elevado a ${numeroB} = <span style="color: #004a99; font-weight: bold;">${exponenciacion}</span></li>
    </ul>
`;