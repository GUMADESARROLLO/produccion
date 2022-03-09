<script type="text/javascript">
    /********** Guardar datos de orden de produccion ***********/
    /*$(document).on('click', '#btnguardar', function(e) {
        e.preventDefault();
        let codigo = $('#numOrden').val();
        console.log(codigo);
        let fecha1 = $("#fecha01").val();
        let fecha2 = $("#fecha02").val();
        let horaInicio = $("#hora01").val();
        let horaFin = $("#hora02").val();
        let horasT = $("#hrsTrabajadas").val();
        let data = [];
        if (validarForm(e) !== true) {
            return false
        } else {
            $("#formdataord").submit();
        }
    });*/
    // boton de registrar
    $('#btnguardar').click(function(e) {

        if (validarForm(e) !== true) {
            return false
        }
        var dataString = $('#formdataord').serialize(); // carga todos los campos para enviarlos
        // AJAX
        $.ajax({
            type: "POST",
            url: "{{url('orden-produccion/guardar') }}",
            data: dataString,
            success: function(response) {
                 if (response==true) {
                     mensaje('No se guardo con exito :(, es una orden duplicada, por favor escriba otra', 'warning');
                 }else{
                     mensaje('Datos guardados', 'success');
                }
            },
            error: function(response) {
                mensaje('Algo salio mal :(' + response, 'error');
            }
        });
            e.preventDefault();



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

        let codigo = $('#numOrden').val();
        let fecha1 = $("#fecha01").val();
        let fecha2 = $("#fecha02").val();
        let horaInicio = $("#hora01").val();
        let horaFin = $("#hora02").val();
        let horasT = $("#hrsTrabajadas").val();

        if (fecha1 === '') {
            e.preventDefault();
            mensaje("Debe ingresar una fecha inicial para la orden", "error");
            return false;
        }

        if (fecha2 === '') {
            e.preventDefault();
            mensaje("Debe ingresar una fecha final para la orden", "error");
            return false;
        }

        if (horaInicio === '') {
            e.preventDefault();
            mensaje("Debe ingresar una hora inicial para la orden", "error");
            return false;
        }

        if (horaFin === '') {
            e.preventDefault();
            mensaje("Debe ingresar una hora final para la orden", "error");
            return false;
        }

        if (horasT === '') {
            e.preventDefault();
            mensaje("Debe ingresar las horas trabajadas de la orden", "error");
            return false;
        }

        if (codigo === '') {
            e.preventDefault();
            mensaje("Debe ingresar un numero de orden", "error");
            return false;
        }

        return true;
    }
</script>
