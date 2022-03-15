<script type="text/javascript">

    // $('#btnSave').on('click', function () {
    //
    //     let data = table_producto
    //
    //     let numOrden = $('#num_orden').val(),
    //         articulo = $('#hora_inicial').val(),
    //         cantidad = $('#id_select_producto').val(),
    //         tipo;
    //
    //     let array = [];
    //
    //     if (jumborroll == 0) {
    //         return mensaje('Por favor seleccione el producto', 'error');
    //     }
    //     if (jumborroll == '' || jumborroll == null) {
    //         return mensaje('Por favor seleccione el producto', 'error');
    //     }
    //     if (numOrden == '') {
    //         return mensaje('Por favor digite el numero de orden', 'error');
    //     }
    //     if (hora == '') {
    //         return mensaje('Por favor indique la hora inical', 'error');
    //     }
    //     if (fechaInicial == '') {
    //         return mensaje('Por favor seleccione la fecha inicial', 'error');
    //     }
    //     if (jumborroll == 35) {
    //         producto = 2;
    //     } else if (jumborroll == 13) {
    //         producto = 1;
    //     }
    //
    //     fecha_hora_inicio = fechaInicial + ' ' + hora + ':00';
    //     array[0] = {
    //         num_orden: numOrden,
    //         id_productor: producto,
    //         id_jr: jumborroll,
    //         fecha_hora_inicio: fecha_hora_inicio,
    //         fecha_hora_final: fecha_hora_inicio
    //     };
    //     $.ajax({
    //         url: "guardarMatP",
    //         data: {
    //             data: array,
    //             num_orden: numOrden
    //         },
    //         type: 'post',
    //         async: true,
    //         success: function (response) {
    //             if (response == 1) {
    //                 mensaje('Orden duplicada, por favor verifique el N°. Orden', 'warning');
    //             } else {
    //                 mensaje(response.responseText, 'success');
    //                 $('#mdlMatPrima').modal('hide');
    //             }
    //         },
    //         error: function (response) {
    //             mensaje(response.responseText, 'error');
    //         }
    //     }).done(function (data) {
    //         location.reload();
    //     });
    // });

    function clearFields() {

        $('#fecha_inicial').val('');
        $('#num_orden').val('');
        $('#hora_inicial').val('');
        $('#id_select_producto').val('');

    }
</script>
