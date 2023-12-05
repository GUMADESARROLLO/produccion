<script type="text/javascript">
    var dtQM;
    var indicador_1 = 0;
    //new DataTable('#dtQM');
    $(document).ready(function() {
        $(function () {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
        });
    
        var numOrden = $("#numOrden").val();
        $.ajax({
            url: `../../getProduccionQuimicos`,
            data:{
                idOP : numOrden
            },
            type: 'get',
            async: true,
            success: function(data) {
               
                $('#dtQM').DataTable({
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
                        { "title": "idQ", "data": "idQuimico" },
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
                $("#dtQM_length").hide();
                $("#dtQM_filter").hide();
            }
        });

       
       
       
        inicializaControlFecha();
    });
    
    $('#dtQM tbody').on('click', "tr", function(event) {
        var cantidadStr, cantidad, nombre;
        var numOrden = $("#numOrden").val();
        var idMaquina, idQuimico, id;
        
        var fila = $(this);

        var rowData = $('#dtQM').DataTable().row(fila).data();
                
        idMaquina = rowData.idMaquina;
        idQuimico = rowData.idQuimico;
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
                        url: "../../guardarqm",
                        data: {
                            codigo: numOrden,
                            idMaquina: idMaquina,
                            idQuimico: idQuimico,
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

    $('#dtMO tbody').on('click', "tr", function(event) {
        var cantidadStr1, cantidadStr2, dia, noche, nombre;
        var numOrden = $("#numOrden").val();
        var idMaquina, idQuimico, id;
        
        var fila = $(this);

        //idMaquina = rowData.idMaquina;
        idActividad = fila.find('td:eq(0)').text();
        nombre = fila.find('td:eq(1)').text();
        cantidadStr = fila.find('td:eq(2)').text();
        dia = parseInt(cantidadStr);
        cantidadStr2 = fila.find('td:eq(3)').text();
        noche = parseInt(cantidadStr2);

        Swal.fire({
            title: nombre,
            html:
                '<div class="row"><div class="col-xl-6"><h5>DIA</h5><input id="dia" class="swal2-input" placeholder="Digite la cantidad - DIA" value="'+dia+'" onkeypress="soloNumeros(event.keyCode, event, $(this).val())"></div>' +
                '<div class="col-xl-6"><h5>NOCHE</h5><input id="noche" class="swal2-input" placeholder="Digite la cantidad - NOCHE" value="'+noche+'" onkeypress="soloNumeros(event.keyCode, event, $(this).val())"></div></div>',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                var dia = $('#dia').val();
                var noche = $('#noche').val();
                
                dia = dia.replace(/[',]+/g, '');
                if (isNaN(dia)) {
                    return 'Formato incorrecto';
                } else {
                    $.ajax({
                        url: "../../actualizarMO",
                        data: {
                            codigo: numOrden,
                            idActividad: idActividad,
                            dia: dia,
                            noche: noche
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
                return { dia: dia, noche: noche };
            }, 
            inputValidator: (value) => {
                // Acceder a las variables cantidad y otroCampo
                var { dia, noche } = Swal.getPopup().querySelector('input')._preConfirmResult;

                // Realizar validaciones adicionales si es necesario
                if (dia.length === 0) {
                    return 'Debe ingresar un valor en el campo "otroCampo"';
                }

                // Realizar validaciones adicionales si es necesario
                if (noche.length === 0) {
                    return 'Debe ingresar un valor en el campo "otroCampo"';
                }
            }
        })
        
    });

    $('#dtCI tbody').on('click', "tr", function(event) {
        var cantidadStr1, cantidadStr2, dia, noche, nombre;
        var numOrden = $("#numOrden").val();
        var idMaquina, idQuimico, id;
        
        var fila = $(this);

        //idMaquina = rowData.idMaquina;
        idActividad = fila.find('td:eq(0)').text();
        nombre = fila.find('td:eq(1)').text();
        cantidadStr = fila.find('td:eq(2)').text();
        dia = parseFloat(cantidadStr).toFixed(2);
        cantidadStr2 = fila.find('td:eq(3)').text();
        noche = parseFloat(cantidadStr2).toFixed(2);

        Swal.fire({
            title: nombre,
            html:
                '<div class="row"><div class="col-xl-6"><h5>DIA</h5><input id="dia" class="swal2-input" placeholder="Digite la cantidad - DIA" value="'+dia+'" onkeypress="soloNumeros(event.keyCode, event, $(this).val())"></div>' +
                '<div class="col-xl-6"><h5>NOCHE</h5><input id="noche" class="swal2-input" placeholder="Digite la cantidad - NOCHE" value="'+noche+'" onkeypress="soloNumeros(event.keyCode, event, $(this).val())"></div></div>',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                var dia = $('#dia').val();
                var noche = $('#noche').val();
                
                dia = dia.replace(/[',]+/g, '');
                if (isNaN(dia)) {
                    return 'Formato incorrecto';
                } else {
                    $.ajax({
                        url: "../../actualizarCI",
                        data: {
                            codigo: numOrden,
                            idActividad: idActividad,
                            dia: dia,
                            noche: noche
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
                return { dia: dia, noche: noche };
            }, 
            inputValidator: (value) => {
                // Acceder a las variables cantidad y otroCampo
                var { dia, noche } = Swal.getPopup().querySelector('input')._preConfirmResult;

                // Realizar validaciones adicionales si es necesario
                if (dia.length === 0) {
                    return 'Debe ingresar un valor en el campo "otroCampo"';
                }

                // Realizar validaciones adicionales si es necesario
                if (noche.length === 0) {
                    return 'Debe ingresar un valor en el campo "otroCampo"';
                }
            }
        })
        
    });

    /*$(document).on('click','#quitRowdtQM',function() {
        var select_row = dtQM.row(".selected").data();
        indexData = select_row[0];
    
        $.ajax({
            url: "../../eliminar-qm",
            data: {            
                id : indexData
            },
            type: 'post',
            async: true,
            success: function (resultado) {
                mensaje('Se elimino el quimico con exito :)', 'success')
            }
        }).done(function(data) {
            dtQM.row('.selected').remove().draw( false );
        });    
    } );
    
    $('#dtQM tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            dtQM.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );*/
    
    function deleteORDP(idORD) {
        swal({
          title: 'Eliminar este Quimico',
          text: "¿Desea eliminar este Quimico?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Si, eliminar',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          mensaje('Actualizado con exito', 'success');
          if (result.value) {
            $.getJSON("quimicos/eliminar/"+idQuimico, function(json) { 
                if (json==true) {
                    location.reload();                
                }
            })
          }
        })
    }
    
    /*$(document).on('click','.add-row-dt-qm',function() {
        var numOrden = $("#numOrden").val();
        var option1 = '';
        var option2 = '';
    
        var last_row = dtQM.row(":last").data();
    
        if (typeof (last_row) === "undefined") {
            indicador_1 = 1;
        }else {
            indicador_1 = parseInt( last_row[0] ) + 1
        }
    
        $.getJSON("../../data-qm", function(json) {
            $.each(json['dataQuimicos'], function(i, item) {
                option1 += `<option value='`+item['idQuimico']+`'>`+item['descripcion']+`</option>`
            })
    
            $.each(json['dataMaquinas'], function(i, item) {
                option2 += `<option value='`+item['idMaquina']+`'>`+item['nombre']+`</option>`
            })
    
            dtQM.row.add( [
                indicador_1,
                `<select class="mb-3 form-control" id="maquinaq-`+indicador_1+`">`+option2+`</select>`,
                `<select class="mb-3 form-control" id="quimicos-`+indicador_1+`">`+option1+`</select>`,
                `<input class="input-dt qm-cant" type="text" placeholder="Cantidad" id="cantidadq-`+indicador_1+`">`,
            ]).draw(false);
        })
    });*/
    
    
    /*$(document).on('click','#btnactualizar',function() {
        codigo = $('#numOrden').val();
        var last_row = dtQM.row(":last").data();
        var array = new Array();
        var i = 0;
    
        if (typeof (last_row) === "undefined") {
            mensaje("Ingrese al menos un registro en la tabla de Quimico", "error")
        }else {
            dtQM.rows().eq(0).each(function( index ) {
                var row = dtQM.row(index);
                var data = row.data();
                var pos = data[0];
                var idq =  pos;

                var maquina = ($('#maquinaq-'+pos+' option:selected').val()=="")?0:$('#maquinaq-'+pos+' option:selected').val();
                var quimico = ($('#quimicos-'+pos+' option:selected').val()=="")?0:$('#quimicos-'+pos+' option:selected').val();
                var cantidad = ( $('#cantidadq-'+pos).val()=="" )?0:$('#cantidadq-'+pos).val();
                
                array[i] = {
                    id : idq,
                    orden       : codigo,
                    maquina     : maquina,
                    quimico       : quimico,
                    cantidad    : cantidad
                };
    
                i++;
            });
    
            $.ajax({
                url: "../../guardarqm-directa",
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
    
    
    </script>