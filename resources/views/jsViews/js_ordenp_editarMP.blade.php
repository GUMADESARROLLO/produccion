<script type="text/javascript">
    var dtMPD;
    var indicador_1 = 0;
    $(document).ready(function () {
        $(function () {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
        });

        var numOrden = $("#numOrden").val();
        $.ajax({
            url: `../../getProduccionFibras`,
            data:{
                idOP : numOrden
            },
            type: 'get',
            async: true,
            success: function(data) {
                $('#dtMPD').DataTable({
                    "data":data,
                    "destroy":true,
                    "info": false,
                    "order": 1,
                    "lengthMenu": [[10], [10]],
                    "language": {
                        "zeroRecords": "NO HAY COINCIDENCIAS",
                        "paginate": {
                            "first":      "Primera",
                            "last":       "Última ",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        "lengthMenu": "MOSTRAR _MENU_",
                        "emptyTable": "REALICE UNA BUSQUEDA UTILIZANDO LOS FILTROS DE FECHA",
                        "search":     "BUSCAR"
                    },
                    "columns":[
                        
                        { "title": "idM", "data": "idMaquina" },
                        { "title": "MAQUINA", "data": "maquina" },
                        { "title": "idF", "data": "idFibra" },
                        { "title": "DESCRIPCION", "data": "descripcion" },
                        { "title": "CANTIDAD", "data": "cantidad" },
                        
                        

                    ],
                    "columnDefs": [
                        {
                            "visible": false,
                            "searchable": false,
                            "targets": [0,2]
                        },
                        {"className": "dt-right", "targets": [4]},
                    ],
                    
                });
                $("#dtMPD_length").hide();
                $("#dtMPD_filter").hide();
            }
        });

        inicializaControlFecha();
    });

    $('#dtMPD tbody').on('click', "tr", function(event) {
        var cantidadStr, cantidad, nombre;
        var numOrden = $("#numOrden").val();
        var idMaquina, idFibra, id;
        var fila = $(this);

        var rowData = $('#dtMPD').DataTable().row(fila).data();
                
        idMaquina = rowData.idMaquina;
        idFibra = rowData.idFibra;
        nombre = rowData.descripcion;
        cantidadStr = rowData.cantidad;
        cantidad = parseFloat(cantidadStr).toFixed(2);
        Swal.fire({
            title: nombre,
            text: "Ingrese la cantidad",
            input: 'text',
            inputPlaceholder: 'Digite la cantidad',
            inputAttributes: {
                id: 'cantidad',
                required: 'true',
                onkeypress: 'soloNumeros(event.keyCode, event, $(this).val())'
            },
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            showLoaderOnConfirm: true,
            inputValue: cantidad,
            inputValidator: (value) => {
                if (!value) {
                    return 'Digita la cantidad por favor';
                }
                value = value.replace(/[',]+/g, '');
                if (isNaN(value)) {
                    return 'Formato incorrecto';
                } else {
                    $.ajax({
                        url: "../../guardarmpd",
                        data: {
                            codigo: numOrden,
                            idMaquina: idMaquina,
                            idFibra: idFibra,
                            cantidad: value
                        },
                        type: 'post',
                        async: true,
                        success: function(response) {
                            
                            swal("Exito!", "Guardado exitosamente", "success");
                        },
                        error: function(response) {
                            swal("Oops", "No se ha podido guardar!", "error");
                        }
                    }).done(function(data) {
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    });
                }
            }
        })
        
    });

    /*$(document).on('click', '#quitRowdtMP', function () {
        var select_row = dtMPD.row(".selected").data();
        var indexData = select_row[0];

        $.ajax({
            url: "../../eliminar-mp",
            data: {
                id: indexData
            },
            type: 'post',
            async: true,
            success: function (resultado) {
                mensaje('Se elimino con exito con exito :)', 'success')
            }
        }).done(function (data) {
            dtMPD.row('.selected').remove().draw(false);
        });
    });

    $('#dtMPD tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            dtMPD.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });*/

    function deleteORDP(idORD) {
        swal({
            title: 'Eliminar esta Fibra',
            text: "¿Desea eliminar esta Fibra?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            mensaje('Actualizado con exito', 'success');
            if (result.value) {
                $.getJSON("fibras/eliminar/" + idFibra, function (json) {
                    if (json == true) {
                        location.reload();
                    }
                })
            }
        })
    }

    /*$(document).on('click', '.add-row-dt-mp', function () {
        var numOrden = $("#numOrden").val();
        var option1 = '';
        var option2 = '';

        var last_row = dtMPD.row(":last").data();

        if (typeof (last_row) === "undefined") {
            indicador_1 = 1;
        } else {
            indicador_1 = parseInt(last_row[0]) + 1
        }

        $.getJSON("../../data-mp", function (json) {
            $.each(json['dataFibras'], function (i, item) {
                option1 += `<option value='` + item['idFibra'] + `'>` + item['descripcion'] + `</option>`
            })

            $.each(json['dataMaquinas'], function (i, item) {
                option2 += `<option value='` + item['idMaquina'] + `'>` + item['nombre'] + `</option>`
            })

            dtMPD.row.add([
                indicador_1,
                `<select class="mb-3 form-control" id="maquina-` + indicador_1 + `">` + option2 + `</select>`,
                `<select class="mb-3 form-control" id="fibras-` + indicador_1 + `">` + option1 + `</select>`,
                `<input class="input-dt" type="text" placeholder="Cantidad" id="cantidad-` + indicador_1 + `">`,
            ]).draw(false);
        })
    });*/


    /*$(document).on('click','#btnactualizar',function() {
        codigo = $('#numOrden').val();
        var last_row = dtMPD.row(":last").data();
        var array = new Array();
        var i = 0;

        if (typeof (last_row) === "undefined") {
            mensaje("Ingrese al menos un registro en la tabla de Materia Prima Directa", "error")
        }else {
            dtMPD.rows().eq(0).each(function( index ) {
                var row = dtMPD.row(index);
                var data = row.data();
                var pos = data[0];
                var idf =  pos;
                var maquina = ($('#maquina-'+pos+' option:selected').val()=="")?0:$('#maquina-'+pos+' option:selected').val();
                var fibra = ($('#fibras-'+pos+' option:selected').val()=="")?0:$('#fibras-'+pos+' option:selected').val();
                var cantidad = ( $('#cantidad-'+pos).val()=="" )?0:$('#cantidad-'+pos).val();

                array[i] = {
                    id : idf,
                    orden       : codigo,
                    maquina     : maquina,
                    fibra       : fibra,
                    cantidad    : cantidad
                };

                i++;
            });

            $.ajax({
                url: "../../guardarmp-directa",
                data: {
                    data : array,
                    codigo : codigo
                },
                type: 'post',
                async: true,
                success: function (resultado) {

                }
            }).done(function(data) {
                $("#formdataord").submit();
            });

        }
    });*/

    $(document).on('click', '#btnactualizar', function (data) {
        $("#formdataord").submit();
    });

    $(document).on('click', '#btnrequisa', function requi() {
        var numOrden = $("#numOrden").val();
        const URLlast = "/produccion/requisas/create/" + numOrden;
        $('#btnrequisa').attr('href', "/produccion/requisas/create/" + numOrden);
        console.log(URLlast);
    });


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

    $('#hrsTrabajadas').on('keypress', function (e) {
        soloNumeros(e.keyCode, e, $('#hrsTrabajadas').val());
    });


</script>
