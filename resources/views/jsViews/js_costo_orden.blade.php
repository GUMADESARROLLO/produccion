<script type="text/javascript">
    var dtHP;
    var indicador_1 = 0;

    dtHP = $('#dtHrsProd').DataTable({
        "destroy": true,
        "ordering": false,
        "info": false,
        "bPaginate": false,
        "bfilter": false,
        "searching": false,
        "language": {
            "emptyTable": `<p class="text-center">Agrega horas productivas</p>`
        },
        "columnDefs": [{
            "targets": [0],
            "className": "dt-center",
            "visible": false
        }]
    });

    $("#numOrden").hide();

    $(document).on('click', '#btnNuevoCostoO', function() {
        var numOrden = $("#numOrden").val();
        const URLlast = "/produccion/costo-orden/nuevo/" + numOrden;
        $('#btnNuevoCostoO').attr('href', "/produccion/costo-orden/nuevo/" + numOrden);
        console.log(URLlast);
    });

    $(document).on('click', '#btnEditar', function() {
        var numOrden = $("#numOrden").val();
        const URLlast = "/produccion/costo-orden/nuevo/" + numOrden;
        $('#btnNuevoCostoO').attr('href', "/produccion/costo-orden/nuevo/" + numOrden);
        console.log(URLlast);
    });

    $(document).on('click', '#btnguardar', function() {
        var numOrden = $("#numOrden").val();
        var array = new Array();

        console.log(numOrden);
        var horaJY1 = $('#horaJY1').val();
        var horaLY1 = $('#horaLY1').val();
        var horaJY2 = $('#horaJY2').val();
        var horaLY2 = $('#horaLY2').val();

        if (horaJY1 != '' && horaLY1 != '' && horaJY2 != '' && horaLY2 != '') {
            $.ajax({
                url: "../guardarhrs-producidas",
                data: {
                    codigo: numOrden,
                    horaJY1: horaJY1,
                    horaLY1: horaLY1,
                    horaJY2: horaJY2,
                    horaLY2: horaLY2
                },
                type: 'post',
                async: true,
                success: function(resultado) {
                    alert("Las horas han sido agregadas correctamente");
                }
            }).done(function(data) {
                $("#formdataord").submit();
            });
        } else {
            alert('Digite los horas trabajadas para cada yankee')
        }
    });

    $(document).on('click', '#btnTipoCambio', function(e) {
        //e.preventDefault();
        $("#modaltc").modal();
    })

    $('#fechatc').on('apply.daterangepicker', function(ev, picker) {
        var fecha_tc = $(this).val();
        // alert (fecha_tc);
        //console.log(fecha_tc);
        $.ajax({
            url: "../detalle/get-Tipo-Cambio/" + fecha_tc,
            type: 'get',
            async: true,
            datatype: 'json',
            data: {},
            success: function(data) {
                $('#tasaCambio').text('C$ ' + data[0]['TipoCambio']);
            },
            error: function() {

            }
        });

    });
    //botón guardar tasa de cambio
    $(document).on('click', '#btnguardarTC', function(e) {
        // variables

        var tasaCambio = parseFloat($('#tasaCambio').text());
        var costoTotalCord = parseFloat($('#ctCordobas').text());
        var numOrden = $('#numOrden').val();
        console.log($('#tasaCambio').text());
        console.log(costoTotalCord);

        $.ajax({
            url: "../detalle/actualizarTC",
            type: 'post',
            async: true,
            datatype: 'json',
            data: {
                numOrden: numOrden,
                tasaCambio: tasaCambio,
            },
            success: function(response) {
                mensaje(response.responseText, 'success');
                $('#txtTasaCambio').text(tasaCambio);
            },
            error: function() {}
        })
    })

    $('#btn-guardar-tc').on('click')

    /******** Cargar funcion al inicio del DOM ************/
    $(document).ready(function() {
        $(function() {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });

        });

        inicializaControlFecha();
        /* $('input[name="fechatc"]').on('apply.daterangepicker', function(ev, picker) {
             console.log($(this).val());
         })*/
    });


</script>
