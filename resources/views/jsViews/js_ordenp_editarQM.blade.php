<script type="text/javascript">
    var dtQM;
    var indicador_1 = 0;
    $(document).ready(function() {
        $(function () {
            $('.datetimepicker_').datetimepicker({
                format: 'LT'
            });
        });
    
        dtQM = $('#dtQM').DataTable({
                "destroy":true,
                "ordering": false,
                "info": false,
                "bPaginate": false,
                "bfilter": false,
                "searching": false,
                "language": {
                    "emptyTable": `<p class="text-center">Agrega un quimico</p>`
                },
                
        });
        
        inicializaControlFecha();
    });
    
    $('#dtQM tbody').on('click', "tr", function(event) {
        var cantidadStr, cantidad, nombre;
        var numOrden = $("#numOrden").val();
        var idMaquina, idQuimico, id;
        //var data = dtMPD.rows(this).data();
        var fila = $(this);
                
        idMaquina = fila.find('td:eq(0)').text();
        idQuimico = fila.find('td:eq(2)').text();
        nombre = fila.find('td:eq(3)').text();
        cantidadStr = fila.find('td:eq(4)').text();
        cantidad = parseFloat(cantidadStr).toFixed(2);
        //console.log(idFibra);
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