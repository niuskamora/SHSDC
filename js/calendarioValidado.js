$(function() {

    diasFestivos = ["1/1", "1/5", "19/4", "24/6", "5/7", "24/7", "12/10", "25/12", "31/12"];

    $.datepicker.regional['es'] = {
        clearText: 'Limpiar', clearStatus: '',
        closeText: 'Cerrar', closeStatus: '',
        prevText: '&#x3c;Ant', prevStatus: '',
        prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
        nextText: 'Sig&#x3e;', nextStatus: '',
        nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
        currentText: 'Hoy', currentStatus: '',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        monthStatus: '', yearStatus: '',
        weekHeader: 'Sm', weekStatus: '',
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Juv', 'Vie', 'S&aacute;b'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
        dayStatus: 'DD', dateStatus: 'D, M d',
        dateFormat: 'dd/mm/yy', firstDay: 0,
        initStatus: '', isRTL: false};
    $("#datepickerf").datepicker({
        constrainInput: true,
        beforeShowDay: noFinesDeSemanaNiFestivos,
    });

    $("#datepicker").datepicker({
        constrainInput: true,
        beforeShowDay: noFinesDeSemanaNiFestivos,
        onClose: function(selectedDate) {
            var date = $(this).datepicker('getDate');
            if (date) {
                date.setDate(date.getDate());
            }

            $("#datepickerf").datepicker("option", "minDate", date);

        }
    });

    $.datepicker.setDefaults($.datepicker.regional['es']);
    $.datepickerf.setDefaults($.datepicker.regional['es']);
    

});
function noFinesDeSemanaNiFestivos(date) {


   var noWeekend = $.datepicker.noWeekends(date, diasFestivos);
    noWeekend[2] = 'No se permite el ingreso de días de fin de semana';
    
    return noWeekend[0] ? festivo(date) : noWeekend;
}


function festivo(date) {
    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
    for (i = 0; i < diasFestivos.length; i++) {
        if ($.inArray(d + '/' + (m + 1), diasFestivos) != -1) {
            return[false, "festivos", 'No se permite el ingreso de días festivos'];
        }
    }
    var pascua = CalculePascua(y, "GREGORIANO");
    var MartesCarnavales = FechaRelativa(pascua.Dia - 1, pascua.Mes, y, -46);
    var juevesSanto = FechaRelativa(pascua.Dia - 1, pascua.Mes, y, -2);

    //lunes carnavales
    if (d == (MartesCarnavales.Dia - 1) && (m + 1) == MartesCarnavales.Mes && y == MartesCarnavales.Ano) {
        return[false, "festivos", 'No se permite el ingreso de días festivos'];
    } else if (d == MartesCarnavales.Dia && (m + 1) == MartesCarnavales.Mes && y == MartesCarnavales.Ano) {//martes carnavales
        return[false, "festivos", 'No se permite el ingreso de días festivos'];
    } else if (d == juevesSanto.Dia && (m + 1) == juevesSanto.Mes && y == juevesSanto.Ano) {//jueves santo
        return[false, "festivos", 'No se permite el ingreso de días festivos'];
    } else if (d == (juevesSanto.Dia + 1) && (m + 1) == juevesSanto.Mes && y == juevesSanto.Ano) { //viernes santo
        return[false, "festivos", 'No se permite el ingreso de días festivos'];
    }

    return[true, ''];
}


function CalculePascua(Agno, Calendario) {

    if (Calendario == "GREGORIANO") {
        a = Agno % 19
        b = Math.floor(Agno / 100)
        c = Agno % 100
        d = Math.floor(b / 4)
        e = b % 4
        f = Math.floor((b + 8) / 25)
        g = Math.floor((b - f + 1) / 3)
        h = (19 * a + b - d - g + 15) % 30
        i = Math.floor(c / 4)
        k = c % 4
        l = (32 + 2 * e + 2 * i - h - k) % 7
        m = Math.floor((a + 11 * h + 22 * l) / 451)
        p = (h + l - 7 * m + 114)
        // Devuelve un registro Registro.Dia_Res / Registro.Mes_Res
        return {Dia: (p % 31) + 1, Mes: Math.floor(p / 31)}
    } else if (calendario == "JULIANO") {
        // Para años anteriores a 1583 (Calendário Juliano):
        a = Agno % 4
        b = Agno % 7
        b = Agno % 19
        d = (19 * c + 15) % 30
        e = (2 * a + 4 * b - d + 34) % 7
        f = Math.floor((d + e + 114) / 31)
        g = (d + e + 114) % 31
        // Devuelve un registro Registro.Dia_Res / Registro.Mes_Res
        return {Dia: g + 1, Mes: f}
    } else
        return {Dia: 0, Mes: 0}
} // CalculePascua



function EsBisiesto(Agno) {
// Los cálculos del año bisiesto cambiam a partir de la reforma Gregoriana del 1582
// 1. A partir Octubre 15 de 1582, i.e. a partir de 1583 (año > 1583): 
//    Un año es bisiesto si es divisible por 4, excepto aquellos divisibles por 100 pero no por 400.
// 2. Antes de Octubre 4 de 1582, i.e. antes de 1581 (año < 1583): 
//    Un año es bisiesto si es divisible por 4.
    if (Agno % 4 == 0) {
        if (Agno > 1583)
            if (Agno % 100 == 0 && Agno % 400 != 0) {
                return false
            }
        return true
    } else {
        return false
    }
} // Es bisiesto

function numDiasMes(mes, Agno) {
// Devuelve la cantidad de Dias del mes
// 0 si ha error
    if (mes < 1 || mes > 12 || Agno <= 0) {
        return 0
    }

    if (mes == 2) {
        // Si un año es bisiesto, Febrero tendrá 29 días y no 28
        if (EsBisiesto(Agno))
            return 29;
        else
            return 28;
    }
    else if (mes == 7) {
        return 31
    }
    else {
        return 30 + ((mes % 7) % 2)
    }
} // numDiasMes



function FechaRelativa(Dia, Mes, Agno, DiferenciaDias) {

// Devuelve un registro con dos enteros con una fecha relativa a la 
// Pascua (Resurrección), sumando (en forma positiva o negativa) 
// una cantidad de dias

    var ndiasmes = 0;

    if (DiferenciaDias == 0)
        return {Dia: Dia, Mes: Mes, Ano: Agno}

    if (DiferenciaDias > 0) {
        Dia++;
        // Avanza mes tras mes hasta llegar a la fecha relativa
        while (DiferenciaDias > 0) {
            ndiasmes = numDiasMes(Mes, Agno);
            if (DiferenciaDias > ndiasmes - Dia + 1) {
                if (Mes < 12) {
                    Mes++;
                }
                else {
                    Mes = 1;
                    Agno++;
                }
                DiferenciaDias -= ndiasmes - Dia + 1;
                Dia = 1;
            } else {
                Dia += DiferenciaDias - 1;
                DiferenciaDias = -1;
            }
        } // end while
    } // Endif
    else { // DiferenciaDias > 0
        DiferenciaDias *= -1;
        while (DiferenciaDias > 0) {
            if (DiferenciaDias >= Dia) {
                if (Mes > 1) {
                    Mes--
                }
                else {
                    Mes = 12;
                    Agno--
                }
                // dias del mes anterior
                DiferenciaDias -= Dia;
                ndiasmes = numDiasMes(Mes, Agno)
                Dia = ndiasmes;
            } else {
                Dia -= DiferenciaDias;
                DiferenciaDias = -1;
            }
        } // end while
    } // End else

    return {Dia: Dia, Mes: Mes, Ano: Agno}
} // FechaRelativa


