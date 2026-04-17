// 1. Obtenemos la fecha actual completa
let fechaActual = new Date();

// 2. Extraemos los componentes numéricos
let diaSemanaNum = fechaActual.getDay();   // Devuelve de 0 (Domingo) a 6 (Sábado)
let diaMes = fechaActual.getDate();        // Devuelve el día del mes (1 al 31)
let mesNum = fechaActual.getMonth();       // Devuelve de 0 (Enero) a 11 (Diciembre)
let anio = fechaActual.getFullYear();      // Devuelve el año (ej. 2026)

let nombreDia = "";
let nombreMes = "";

// 3. Switch para el día de la semana
switch (diaSemanaNum) {
    case 0: nombreDia = "domingo"; break;
    case 1: nombreDia = "lunes"; break;
    case 2: nombreDia = "martes"; break;
    case 3: nombreDia = "miércoles"; break;
    case 4: nombreDia = "jueves"; break;
    case 5: nombreDia = "viernes"; break;
    case 6: nombreDia = "sábado"; break;
}

// 4. Switch para el mes
switch (mesNum) {
    case 0: nombreMes = "Enero"; break;
    case 1: nombreMes = "Febrero"; break;
    case 2: nombreMes = "Marzo"; break;
    case 3: nombreMes = "Abril"; break;
    case 4: nombreMes = "Mayo"; break;
    case 5: nombreMes = "Junio"; break;
    case 6: nombreMes = "Julio"; break;
    case 7: nombreMes = "Agosto"; break;
    case 8: nombreMes = "Septiembre"; break;
    case 9: nombreMes = "Octubre"; break;
    case 10: nombreMes = "Noviembre"; break;
    case 11: nombreMes = "Diciembre"; break;
}

// 5. Armar la frase final usando Template Literals (comillas invertidas)
let mensaje = `Hoy es ${nombreDia} ${diaMes} de ${nombreMes} del año ${anio}`;

// 6. Inyectar el texto en el HTML
document.getElementById("resultado-fecha").innerHTML = `<strong>${mensaje}</strong>`;