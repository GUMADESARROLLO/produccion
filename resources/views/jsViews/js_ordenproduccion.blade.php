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
        $('#tbody-mp tr td').children().each(function(i) {
            $(this).on('keypress', function(e) {
                soloNumeros(e.keyCode, e, $(this).val());
            });
        });
    });

    $(document).on('click', '#quitRowdtBATH', function() {
        var numOrden = $("#numOrden").val();
        var select_row = dtMPD.row(".selected").data();
        $('#tbody-mp tr').each(function(i) {
           //    console.log($(this))
            if ($(this).hasClass('selected')) {
               // console.log($(this))

                id = $(this).children().first();
                var id_selected = id.val();
                console.log(id_selected);
                $.ajax({
                    url: "../eliminar-mp",
                    data: {
                        id: id_selected,
                    },
                    type: 'post',
                    async: true,
                    success: function(resultado) {
                    }
                }).done(function(data) {
                    alert('La materia prima ha sido eliminada');
                });
            } else {
                console.log('Esta clase no esta seleccionada');
            }
        });

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
                `<select class="mb-3 form-control " id="maquina-` + indicador_1 + `">` + option2 + `</select>`,
                `<select class="mb-3 form-control" id="fibras-` + indicador_1 + `">` + option1 + `</select>`,
                `<input class="input-dt" type="text"  placeholder="Cantidad" id="cantidad-` + indicador_1 + `" onpaste="return false">`,
            ]).draw(false);
        })
    });


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

    $('#hrsTrabajadas').on('keypress', function(e) {
        soloNumeros(e.keyCode, e, $('#hrsTrabajadas').val());
    });

    $(document).on('click', '#btnguardar', function() {
        codigo = $('#numOrden').val();
        var last_row = dtMPD.row(":last").data();
        var array = new Array();
        var array2 = new Array();

        var i = 0;
        var horaInicio = $("#hora01").val();
        var cant_prev = $('#cantidad-prev-' + i).val();

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

                $('#tbody-mp tr td').children().each(function(i) {
                    var item = $(this).val();
                    var maquina = "";
                    var fibra = "";
                    var cantidad = "";
                    console.log(i);
                    if (item != "" && item != null) {
                        codigo = $('#numOrden').val();
                        maquina = $('#maquina-prev-' + i).val();
                        fibra = $('#fibras-prev-' + i).val();
                        cantidad = $('#cantidad-prev-' + i).val();
                        if (maquina != "" && fibra != "" && cantidad != "") {
                            array2[i] = {
                                orden: codigo,
                                maquina: maquina,
                                fibra: fibra,
                                cantidad: cantidad
                            };
                        }
                    }
                });

                array3 = array2.filter(function(dato) {
                    return dato.maquina != undefined
                });

                array3.forEach(element => {
                    array.push(element);
                });
                console.log(array);
                //array4 =  array.push(array3);
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