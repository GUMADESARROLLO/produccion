<script type="text/javascript">
    var dtMPD;
    var dtQM;
    var indicador_1 = 0;

    $(document).ready(function() {
        $(function() {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
        });

        /****** Fibras ******/
        dtMPD = $('#dtMPD').DataTable({
            "destroy": true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega una fibra</p>`
            },
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
                "visible": false
            }]
        });

        /****** Quimicos ******/
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

    /****** Fibras ******/
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

    /****** Quimicos ******/
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

    /********** Fibras ***********/
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

    /********** Quimicos ***********/
    $(document).on('click', '#quitRowdtBATHQ', function() {
        var numOrden = $("#numOrden").val();
        var select_row = dtQM.row(".selected").data();
        $('#tbody-qm tr').each(function (i){
            if ($(this).hasClass('selected')) {
                // console.log($(this))

                id = $(this).children().first();
                var id_selected = id.val();
                console.log(id_selected);
                $.ajax({
                    url: "../eliminar-qm",
                    data: {
                        id: id_selected,
                    },
                    type: 'post',
                    async: true,
                    success: function(resultado) {
                    }
                }).done(function(data) {
                    alert('El quimico ha sido eliminado');
                });
            } else {
                console.log('Esta clase no esta seleccionada');
            }
        });

        indexData = select_row[0];
        dtQM.row('.selected').remove().draw(false);
    });

    /********** Fibras ***********/
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

    /********** Quimicos ***********/
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
                `<input class="input-dt qm-cant" type="text"  placeholder="Cantidad" id="cantidadq-prev-` + indicador_1 + `" onpaste="return false">`,
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

    $(document).on('click', '#btnguardar', function(e) {
        e.preventDefault();
        codigo = $('#numOrden').val();
        /********** Fibras ***********/
        var last_row = dtMPD.row(":last").data();
        var array = new Array();
        var array2 = new Array();
        /********** Fibras ***********/

        /********** Quimicos ***********/
        var last_rowq = dtQM.row(":last").data();
        var arrayq = new Array();
        /********** Quimicos ***********/

        var i = 0;
        var fecha1 = $("#fecha01").val();
        var fecha2 = $("#fecha02").val();
        var horaInicio = $("#hora01").val();
        var horaFin = $("#hora02").val();
        var horasT = $("#hrsTrabajadas").val();
        var cantidadf = $('#cantidad' + i).val();
        var cantidadq = $('#cantidad-prev-' + i).val();

        if (typeof(last_row) === "undefined")
        {
            e.preventDefault();
            return mensaje("Ingrese al menos un registro en la tabla de Materia Prima Directa", "error");
        }
        else if (typeof(last_rowq) === "undefined") {
            e.preventDefault();
            mensaje("Ingrese al menos un registro en la tabla de Quimicos directos", "error")
        }
        else if (cantidadf === '') {
            e.preventDefault();
            mensaje("La cantidad no puede estar vacia en la tabla de Quimicos directos", "error")

        }
        else if (cantidadq === '') {
            e.preventDefault();
            mensaje("La cantidad no puede estar vacia en la tabla de Quimicos directos", "error")

        }
        else if (fecha1 === '')
        {

            e.preventDefault();
            return  mensaje("Debe ingresar una fecha inicial para la orden", "error");
        }
        else if (fecha2 === '')
        {

            e.preventDefault();
            return mensaje("Debe ingresar una fecha final para la orden", "error");
        }
        else if (horaInicio === '')
        {

            e.preventDefault();
            return mensaje("Debe ingresar una hora inicial para la orden", "error");
        }
        else if (horaFin === '')
        {

            e.preventDefault();
            return mensaje("Debe ingresar una hora final para la orden", "error");
        }
        else if (horasT === '')
        {

            e.preventDefault();
            return mensaje("Debe ingresar una horas trabajadas de la orden", "error");
        }
        else
        {
            /********** Fibras ***********/
            dtMPD.rows().eq(0).each(function(index)
            {
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
            /********** Fibras ***********/
            //}
            /********** Quimicos ***********/
            dtQM.rows().eq(0).each(function(index) {
                var rowq = dtQM.row(index);
                var dataq = rowq.data();
                var posq = dataq[0];

                var maquinaq = ($('#maquinaq-' + posq + ' option:selected').val() == "") ? 0 : $('#maquinaq-' + posq + ' option:selected').val();
                var quimico = ($('#quimicos-' + posq + ' option:selected').val() == "") ? 0 : $('#quimicos-' + posq + ' option:selected').val();
                var cantidadq = ($('#cantidadq-prev-' + posq).val() == "") ? 0 : $('#cantidadq-prev-' + posq).val();

                if (parseFloat(cantidadq) > 0) {
                    parseFloat(cantidadq)
                } else {
                    mensaje("la cantidad de quimico debe ser mayor a 0");
                    return;
                }
                arrayq[i] = {
                    orden: codigo,
                    maquina: maquinaq,
                    quimico: quimico,
                    cantidad: cantidadq
                };

                i++;
            });
            $.ajax({
                url: "../guardarqm-directa",
                data: {
                    data: arrayq,
                    codigo: codigo
                },
                type: 'post',
                async: true,
                success: function(resultado) {

                }
            }).done(function(data) {
                $("#formdataord").submit();
            });
            /********** Quimicos ***********/

        }

    });


</script>
