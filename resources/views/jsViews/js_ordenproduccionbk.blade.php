<script type="text/javascript">
    var dtQM;
    var indicador_1 = 0;

    $(document).ready(function() {
        $(function() {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
        });

        dtQM = $('#dtQM').DataTable({
            "destroy": true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega un Quimico</p>`
            },
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
                "visible": false
            }]
        });

        inicializaControlFecha();
    });

    $('#dtQM tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dtQM.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
        $('#tbody-qm tr td').children().each(function(i) {
            $(this).on('keypress', function(e) {
                soloNumeros(e.keyCode, e, $(this).val());
            });
        });
    });

    $(document).on('click', '#quitRowdtBATHQ', function() {
        var select_row = dtQM.row(".selected").data();
        indexData = select_row[0];
        dtQM.row('.selected').remove().draw(false);
    });

    $(document).on('click', '.add-row-dt-qm', function() {
        var numOrden = $("#numOrden").val();
        var option1 = '';
        var option2 = '';

        var last_row = dtQM.row(":last").data();

        if (typeof(last_row) === "undefined") {
            indicador_1 = 1;
        } else {
            indicador_1 = parseInt(last_row[0]) + 1
        }

        $.getJSON("../data-qm", function(json) {
            $.each(json['dataQuimicos'], function(i, item) {
                option1 += `<option value='` + item['idQuimico'] + `'>` + item['descripcion'] + `</option>`
            })

            $.each(json['dataMaquinas'], function(i, item) {
                option2 += `<option value='` + item['idMaquina'] + `'>` + item['nombre'] + `</option>`
            })
            dtQM.row.add([
                indicador_1,
                `<select class="mb-3 form-control " id="maquinaq-` + indicador_1 + `">` + option2 + `</select>`,
                `<select class="mb-3 form-control" id="quimicos-` + indicador_1 + `">` + option1 + `</select>`,
                `<input class="input-dt qm-cant" type="text"  placeholder="Cantidad" id="cantidadq-` + indicador_1 + `" onpaste="return false">`,
            ]).draw(false);
        })
    });

    function verfifyExistRegister() {
        codigo = $('#numOrden').val();
        $.ajax({
            url: "../cargarqm-directa",
            data: {
                data: array,
                codigo: codigo
            },
            type: 'post',
            async: true,
            success: function(resultado) {}
        })
    }

    //$(document).ready(resaltar);


    function soloNumeros(caracter, e, numeroVal) {
        var numero = numeroVal;
        if (String.fromCharCode(caracter) === "." && numero.length === 0) {
            e.preventDefault();
            // alert('No puedes iniciar con un punto');
        } else if (numero.includes(".") && String.fromCharCode(caracter) === ".") {
            e.preventDefault();
            //  alert('No puede haber mas de dos puntos');
        } else {
            const soloNumeros = new RegExp("^[0-9]+$");
            if (!soloNumeros.test(String.fromCharCode(caracter)) && !(String.fromCharCode(caracter) === ".")) {
                e.preventDefault();
                //   alert('solo se permiten datos númericos');
            }
        }
    }

    /*$('#hrsTrabajadas').on('keypress', function(e) {
        soloNumeros(e.keyCode, e, $('#hrsTrabajadas').val());
    });*/

    $('#dtQM tbody').on('click', 'tr', function() {
        var array = new Array();
        var codigo = "";
        $('#tbody-qm tr td').children().each(function(i) {
            var item = $(this).val();
            var maquina = "";
            var quimico = "";
            var cantidad = "";
            if (item != "" && item != null) {
                codigo = $('#numOrden').val();
                maquina = $('#maquinaq-prev-' + i).val();
                quimico = $('#quimicos-prev-' + i).val();
                cantidad = $('#cantidadq-prev-' + i).val();
                if (maquina != "" && quimico != "" && cantidad != "") {
                    array[i] = {
                        orden: codigo,
                        maquina: maquina,
                        quimico: quimico,
                        cantidad: cantidad
                    };
                }
            }
        });
        /*array2 = array.filter(function(dato) {
            return dato != undefined
        });*/

        console.log(array);
        $.ajax({
            url: "../guardarqm-directa",
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

        // console.log(i + " " + array);
    });

    $(document).on('click', '#btnguardar', function() {
        codigo = $('#numOrden').val();

        /* var maquina_previous = $('#maquinaq-prev').val();
         var fibras_previous = $('#quimicos-prev').val();
         var fibras_previous = $('#quimicos-prev').val();*/


        var last_row = dtQM.row(":last").data();
        var array = new Array();
        var i = 0;
        var horaInicio = $("#hora01").val();

        if (typeof(last_row) === "undefined") {
            mensaje("Ingrese al menos un registro en la tabla de Quimicos directos", "error")
        } else {
            if (horaInicio == '') {
                mensaje("Ingrese una hora de inicio", "error");
            } else {



                dtQM.rows().eq(0).each(function(index) {
                    var row = dtQM.row(index);
                    var data = row.data();
                    var pos = data[0];

                    var maquina = ($('#maquinaq-' + pos + ' option:selected').val() == "") ? 0 : $('#maquinaq-' + pos + ' option:selected').val();
                    var quimico = ($('#quimicos-' + pos + ' option:selected').val() == "") ? 0 : $('#quimicos-' + pos + ' option:selected').val();
                    var cantidad = ($('#cantidadq-' + pos).val() == "") ? 0 : $('#cantidadq-' + pos).val();

                    if (parseFloat(cantidad) > 0) {
                        parseFloat(cantidad)
                    } else {
                        mensaje("la cantidad de quimico debe ser mayor a 0");
                        return;
                    }
                    array[i] = {
                        orden: codigo,
                        maquina: maquina,
                        quimico: quimico,
                        cantidad: cantidad
                    };

                    i++;
                });
                $.ajax({
                    url: "../guardarqm-directa",
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