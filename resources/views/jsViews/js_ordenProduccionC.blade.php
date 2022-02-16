<script type="text/javascript">
    /********** Guardar datos de orden de produccion ***********/
    $(document).on('click', '#btnguardar', function(e) {
    e.preventDefault();
    /*let codigo = $('#numOrden').val();
    console.log(codigo);
    let fecha1 = $("#fecha01").val();
    let fecha2 = $("#fecha02").val();
    let horaInicio = $("#hora01").val();
    let horaFin = $("#hora02").val();
    let horasT = $("#hrsTrabajadas").val();
    let data = [];*/
    if (validarForm(e) !== true) {
        return false
    } else {
        $("#formdataord").submit();
    }
    });
    /********** Guardar datos de orden de produccion ***********/

    $(document).on('click', '#btnrequisa', function requi() {
        var numOrden = $("#numOrden").val();
        const URLlast = "/produccion/requisas/create/" + numOrden;
        $('#btnrequisa').attr('href', "/produccion/requisas/create/" + numOrden);
        console.log(URLlast);
    });

    /********** funciones extras para validacion ***********/
    function soloNumeros(caracter, e, numeroVal) {
        var numero = numeroVal;
        if (String.fromCharCode(caracter) === "." && numero.length === 0) {
            e.preventDefault();
            mensaje('No puedes iniciar con un punto', 'warning');
        } else if (numero.includes(".") && String.fromCharCode(caracter) === ".") {
            e.preventDefault();
            mensaje('No puede haber mas de dos puntos', 'warning');
        } else {
            const soloNumeros = new RegExp("^[0-9]+$");
            if (!soloNumeros.test(String.fromCharCode(caracter)) && !(String.fromCharCode(caracter) === ".")) {
                e.preventDefault();
                mensaje('No se pueden escribir letras, solo se permiten datos númericos', 'warning');
            }
        }
    }

    $('#hrsTrabajadas').on('keypress', function(e) {
        soloNumeros(e.keyCode, e, $('#hrsTrabajadas').val());
    });

    function validarForm(e) {
        e.preventDefault();
        let codigo = $('#numOrden').val();
        let fecha1 = $("#fecha01").val();
        let fecha2 = $("#fecha02").val();
        let horaInicio = $("#hora01").val();
        let horaFin = $("#hora02").val();
        let horasT = $("#hrsTrabajadas").val();

        if (fecha1 === '') {
            mensaje("Debe ingresar una fecha inicial para la orden", "error");
            return false;
        }

        if (fecha2 === '') {
            mensaje("Debe ingresar una fecha final para la orden", "error");
            return false;
        }

        if (horaInicio === '') {
            mensaje("Debe ingresar una hora inicial para la orden", "error");
            return false;
        }

        if (horaFin === '') {
            mensaje("Debe ingresar una hora final para la orden", "error");
            return false;
        }

        if (horasT === '') {
            mensaje("Debe ingresar las horas trabajadas de la orden", "error");
            return false;
        }

        if (codigo === '') {
            mensaje("Debe ingresar un numero de orden", "error");
            return false;
        }

        return true;
    }
</script>
