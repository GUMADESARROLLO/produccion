<script type="text/javascript">
    var dtMPD;
    var indicador_1 = 0;

    $(document).ready(function() {
        $(function() {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
        });

        dtMPD = $('#dtMPD').DataTable({
            "destroy": true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega una fecha</p>`
            },
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
                "visible": false
            }]
        });

        inicializaControlFecha();
    });

    $('#dtMPD tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dtMPD.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $(document).on('click', '#quitRowdtBATH', function() {
        var select_row = dtMPD.row(".selected").data();
        indexData = select_row[0];

        dtMPD.row('.selected').remove().draw(false);
    });


 

    $(document).on('click', '.add-row-dt-mp', function() {
        var numOrden = $("#numOrden").val();
        var option1 = '';
        var option2 = '';

        var last_row = dtMPD.row(":last").data();

        if (typeof(last_row) === "undefined") {
            indicador_1 = 1;
        } else {
            indicador_1 = parseInt(last_row[0]) + 1
        }

        $.getJSON("../data-mp", function(json) {
            $.each(json['dataFibras'], function(i, item) {
                option1 += `<option value='` + item['idFibra'] + `'>` + item['descripcion'] + `</option>`
            })

            $.each(json['dataMaquinas'], function(i, item) {
                option2 += `<option value='` + item['idMaquina'] + `'>` + item['nombre'] + `</option>`
            })

            dtMPD.row.add([
                indicador_1,
                `<select class="mb-3 form-control" id="maquina-` + indicador_1 + `">` + option2 + `</select>`,
                `<select class="mb-3 form-control" id="fibras-` + indicador_1 + `">` + option1 + `</select>`,
                `<input class="input-dt" type="number" pattern="[0-9]+" min="1"  placeholder="Cantidad" id="cantidad-` + indicador_1 + `">`,
            ]).draw(false);
        })
    });

    function verfifyExistRegister() {
        codigo = $('#numOrden').val();
        $.ajax({
            url: "../cargarmp-directa",
            data: {
                data: array,
                codigo: codigo
            },
            type: 'post',
            async: true,
            success: function(resultado) {

            }
        })

    }

    $(document).on('click', '#btnguardar', function() {
        codigo = $('#numOrden').val();
        var last_row = dtMPD.row(":last").data();
        var array = new Array();
        var i = 0;
        var horaInicio = $("#hora01").val();

        if (typeof(last_row) === "undefined") {
            mensaje("Ingrese al menos un registro en la tabla de Materia Prima Directa", "error")
        } else {
            if (horaInicio == '') {
                mensaje("Ingrese una hora de inicio", "error");
            } else {
                dtMPD.rows().eq(0).each(function(index) {
                    var row = dtMPD.row(index);
                    var data = row.data();
                    var pos = data[0];

                    var maquina = ($('#maquina-' + pos + ' option:selected').val() == "") ? 0 : $('#maquina-' + pos + ' option:selected').val();
                    var fibra = ($('#fibras-' + pos + ' option:selected').val() == "") ? 0 : $('#fibras-' + pos + ' option:selected').val();
                    var cantidad = ($('#cantidad-' + pos).val() == "") ? 0 : $('#cantidad-' + pos).val();

                    if (parseFloat(cantidad) > 0) {
                        parseFloat(cantidad)
                    } else {
                        mensaje("la cantidad de materia prima debe ser mayor a 0");
                        return;
                    }
                    array[i] = {
                        orden: codigo,
                        maquina: maquina,
                        fibra: fibra,
                        cantidad: cantidad
                    };

                    i++;
                });

                $.ajax({
                    url: "../guardarmp-directa",
                    data: {
                        data: array,
                        codigo: codigo
                    },
                    type: 'post',
                    async: true,
                    success: function(resultado) {

                    }
                }).done(function(data) {
                    $("#formdataord").submit();
                });


            }
        }
    });
</script>