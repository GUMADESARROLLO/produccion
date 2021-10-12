<script type="text/javascript">
var dtBath, dtTetra;
var indicador_1 = 0;
var indicador_2 = 0;
var indicador_3 = 0;
var indicador_4 = 0;
var base_url = window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/';

$(document).ready(function() {
    /********INICIALIZANDO LOS DATATABLES - START ********/
    dtBath = $('#dtBachadasxdias').DataTable({
            "destroy":true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega una fecha</p>`
            },
            "columnDefs":[
                {
                    "targets": [ 0 ],
                    "className": "dt-center",
                    "visible": false
                }
            ]
    });

    dtTetra = $('#dtBachadasTetra').DataTable({
            "destroy":true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega una fecha</p>`
            },
            "columnDefs":[
                {
                    "targets": [ 0 ],
                    "className": "dt-center",
                    "visible": false
                }
            ]
    });

    dtTMuertos = $('#dtTiemposMuertos').DataTable({
            "destroy":true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega una fecha</p>`
            },
            "columnDefs":[
               {
                    "targets": [ 0 ],
                    "visible": false
                }
            ]
    });

    dtJRoll = $('#dtJumboRoll').DataTable({
        "destroy":true,
        "ordering": false,
        "info": false,
        "bPaginate": false,
        "bfilter": false,
        "searching": false,
        "language": {
            "emptyTable": `<p class="text-center">Agrega una fila nueva</p>`
        },
        "columnDefs":[
           {
                "targets": [ 0 ],
                "visible": false
            }
        ]
    });
    /********INICIALIZANDO LOS DATATABLES - END********/

    /********INICIALIZANDO FUNCIONES - START********/
    addRowsJumboroll()
    inicializaControlFecha2();
    inicializaControlFecha();
    addRowsInventario();
    /********INICIALIZANDO FUNCIONES - END********/
});

function addRowsInventario() {
    var cols = 1; 
    var numOrden = $("#numOrden").text();
    var table_header = '<thead>';
    var table_body = '<tbody>';
    var table_complete = '';
    var columns = 0;
    band = false;

    $.getJSON(base_url+"getDtaInventario/"+numOrden, function(json) {

        if(json.length>0) {
            $.each(json, function (i, item) {

                if (band==false) {
                    table_header += `<tr><th style="display:none"></th><th></th>`;
                }
                
                table_body += `<tr><td style="display:none">`+cols+`</td>`;
                table_body += `<td>`+item['fibra']+`</td>`;
                
                $.each(item['data'], function(ii, iitem) {

                    if (band==false) {
                        table_header += `<th></th>`;
                    }                    
                    
                    table_body+=`<td><input type="number" class="cantidad form-control" id="celda-`+cols+`" value="`+iitem['cantidad']+`"></td>`;

                    columns = ii + 1;
                })

                if ( columns<item['columns'] ) {
                    dif = (item['columns']) - (columns+1);

                    for (var i = 0; i <= dif; i++) {
                        if (band==false) {
                            table_header += `<th></th>`;
                        }  

                        
                        table_body+=`<td><input type="number" class="form-control" id="celda-`+cols+`"></td>`;
                        cols++;
                    }
                }

                table_body += `</tr>`;                

                if( band==false ){
                    table_header += `</tr>`;
                    band=true;
                }

                cols++;

            });
            table_complete = `<table class="table" id="dtInventario">`+table_header+ `</thead>`+ table_body + `</tbody></table>`;
            $("#container-table-inventario").empty().append(table_complete);
        }
    })
}

function addRowsJumboroll() {
    var turno = $("#turno option:selected").val();
    var numOrden = $("#numOrden").text();

    dtJRoll.clear().draw();

    $.getJSON(base_url+"dataJROLL/"+turno+"/"+numOrden, function(json) {
        if(json.length>0) {
            $.each(json, function (i, item) {
                indicador_4 = item['id'];

                $("#jefe option:selected").removeAttr("selected");
                $("#jefe option[value='"+item['idUsuario']+"']").attr("selected", true);
                $('#fecha01').val(item['fechaInicio'])
                $('#fecha02').val(item['fechaFinal'])
                $('#res-pulper').val(item['residuo_pulper'])
                $('#lav-tetrapack').val(item['lavadora_tetrapack'])
                $('#merma-dry-y1').val(item['merma_yankee_dry_1'])
                $('#merma-dry-y2').val(item['merma_yankee_dry_2'])

                dtJRoll.row.add( [
                    indicador_4,
                    `<input class="input-dt" value="`+item['vinieta']+`" type="text" placeholder="Cantidad" id="vineta-`+indicador_4+`">`,
                    `<input class="input-dt" value="`+item['kg']+`" type="text" placeholder="Cantidad" id="cant-kg-`+indicador_4+`">`,
                    `<input class="input-dt" value="`+item['gsm']+`" type="text" placeholder="Cantidad" id="cant-gsm-`+indicador_4+`">`,
                    `<input class="input-dt" value="`+item['yankee']+`" type="text" placeholder="Cantidad" id="yankee-`+indicador_4+`">`,
                ]).draw(false);
            })
        }
    })
}

/********EVENTO AGREGAR ROW A LOS DATATABLE - START********/
$(document).on('click','.add-row-dt-bach',function() {
    var last_row = dtBath.row(":last").data();

    if (typeof (last_row) === "undefined") {
        indicador_1 = 1;
    }else {
        indicador_1 = parseInt( last_row[0] ) + 1
    }

    dtBath.row.add( [
        indicador_1,
        `<input type="text" class="input-fecha-dos form-control" id="fch-pulp-`+indicador_1+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-pulp-dia-`+indicador_1+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-pulp-noc-`+indicador_1+`">`,
    ]).draw(false);
    
    $(function () {
        $('.datetimepicker_').datetimepicker({
            format: 'LT'
        });
    });
    inicializaControlFecha2();
});

$(document).on('click','.add-row-dt-tetra',function() {
    var last_row_ = dtTetra.row(":last").data();

    if (typeof (last_row_) === "undefined") {
        indicador_2 = 1;
    }else {
        indicador_2 = parseInt( last_row_[0] ) + 1
    }

    dtTetra.row.add( [
        indicador_2,
        `<input type="text" class="input-fecha-dos form-control" id="fch-lava-`+indicador_2+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-lava-dia-`+indicador_2+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-lava-noc-`+indicador_2+`">`,
    ]).draw(false);
    
    $(function () {
        $('.datetimepicker_').datetimepicker({
            format: 'LT'
        });
    });
    inicializaControlFecha2();
});

$(document).on('click','.add-row-dt-jroll',function() {
    var last_row_ = dtJRoll.row(":last").data();

    if (typeof (last_row_) === "undefined") {
        indicador_4 = 1;
        num_vinieta = '';
        gsm___ = ""
        yank = ""
    }else {
        indicador_4 = parseInt( last_row_[0] ) + 1
        num_vinieta = parseInt( $('#vineta-'+last_row_[0]).val() ) + 1;
        gsm___ = parseInt( $('#cant-gsm-'+last_row_[0]).val() )
        yank = ( $('#yankee-'+last_row_[0]).val()==1 )?2:1;
    }

    dtJRoll.row.add( [
        indicador_4,
        `<input class="input-dt" type="text" value="`+num_vinieta+`" placeholder="Cantidad" id="vineta-`+indicador_4+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-kg-`+indicador_4+`">`,
        `<input class="input-dt" type="text" value="`+gsm___+`" placeholder="Cantidad" id="cant-gsm-`+indicador_4+`">`,
        `<input class="input-dt" type="text" value="`+yank+`" placeholder="Cantidad" id="yankee-`+indicador_4+`">`,
    ]).draw(false);
});

$(document).on('click','.add-row-dt-tmuertos',function() {
    var last_row_ = dtTMuertos.row(":last").data();

    if (typeof (last_row_) === "undefined") {
        indicador_3 = 1;
    }else {
        indicador_3 = parseInt( last_row_[0] ) + 1
    }

    dtTMuertos.row.add( [
        indicador_3,
        `<input type="text" class="input-fecha-dos form-control" id="fch-tm-`+indicador_3+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-y1-dia-`+indicador_3+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-y2-dia-`+indicador_3+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-y1-noc-`+indicador_3+`">`,
        `<input class="input-dt" type="text" placeholder="Cantidad" id="cant-y2-noc-`+indicador_3+`">`
    ]).draw(false);
    
    $(function () {
        $('.datetimepicker_').datetimepicker({
            format: 'LT'
        });
    });
    inicializaControlFecha2();
});
/********EVENTO AGREGAR ROW A LOS DATATABLE - END********/

/********EVENTO SELECCIONAR ROW DE LOS DATATABLE - START********/
$('#dtBachadasxdias tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
    }
    else {
        dtBath.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
} );

$('#dtBachadasTetra tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
    }
    else {
        dtTetra.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
} );

$('#dtTiemposMuertos tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
    }
    else {
        dtTMuertos.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
} );

$('#dtJumboRoll tbody').on( 'click', 'tr', function () {
    if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
    }
    else {
        dtJRoll.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
} );
/********EVENTO SELECCIONAR ROW DE LOS DATATABLE - END********/

/********EVENTO ELIMINAR ROW DE LOS DATATABLE - START********/
$(document).on('click','#quitRowdtBATH',function() {
    var select_row = dtBath.row(".selected").data();
    indexData = select_row[0];

    $.ajax({
        url: base_url+"eliminar-tiempo-pulpeo",
        data: {            
            id : indexData
        },
        type: 'post',
        async: true,
        success: function (resultado) {
            mensaje('Se elimino con exito con exito :)', 'success')
        }
    })

    dtBath.row('.selected').remove().draw( false );
} );

$(document).on('click','#quitRowdtTM',function() {
    var select_row = dtTMuertos.row(".selected").data();
    indexData = select_row[0];

    $.ajax({
        url: base_url+"eliminar-tiempos-muertos",
        data: {            
            id : indexData
        },
        type: 'post',
        async: true,
        success: function (resultado) {
            mensaje('Se elimino con exito con exito :)', 'success')
        }
    })

    dtTMuertos.row('.selected').remove().draw( false );
} );

$(document).on('click','#quitRowdtLAV',function() {
    var select_row = dtTetra.row(".selected").data();
    indexData = select_row[0];

    $.ajax({
        url: base_url+"eliminar-tiempo-lavado",
        data: {
            id : indexData
        },
        type: 'post',
        async: true,
        success: function (resultado) {
            mensaje('Se elimino con exito con exito :)', 'success')
        }
    })

    dtTetra.row('.selected').remove().draw( false );
} );

$(document).on('click','#quitRowdtJROLL',function() {
    var select_row = dtJRoll.row(".selected").data();
    indexData = select_row[0];

    $.ajax({
        url: base_url+"eliminar-vinieta",
        data: {
            id : indexData
        },
        type: 'post',
        async: true,
        success: function (resultado) {
            mensaje('Se elimino con exito con exito :)', 'success');
            dtJRoll.row('.selected').remove().draw( false );
        }
    })

    
} );
/********EVENTO ELIMINAR ROW DE LOS DATATABLE - END********/

/********EVENTO GUARDAR - START********/
$(document).on('click','#btnGBACH',function() {
    codigo = $('#numOrden').text();
    t_pulpeo = $("#tiempo-pulpeo").val();
    var last_row = dtBath.row(":last").data();
    var array = new Array();
    var i = 0;

    if (typeof (last_row) === "undefined") {
        mensaje("No hay datos que guardar :(", "error")
    }else {
        dtBath.rows().eq(0).each(function( index ) {
            var row = dtBath.row(index);
            var data = row.data();
            var fecha = $('#fch-pulp-'+data[0]).val()
            var dia = ( $('#cant-pulp-dia-'+data[0]).val()=="" )?0:$('#cant-pulp-dia-'+data[0]).val();
            var noche = ( $('#cant-pulp-noc-'+data[0]).val()=="" )?0:$('#cant-pulp-noc-'+data[0]).val();
            
            array[i] = {
                orden         : codigo,
                tiempo_pulpeo : (t_pulpeo=='')?0:t_pulpeo,
                fecha         : fecha,
                dia           : dia,
                noche         : noche
            };

            i++;
        });

        $.ajax({
            url: base_url+"guardar-tiempo-pulpeo",
            data: {
                codigo : codigo,
                data : array
            },
            type: 'post',
            async: true,
            success: function (resultado) {
                mensaje('Se guardo con exito :)', 'success')
            }
        })
    }
});

$(document).on('click','#btnTMuertos',function() {
    codigo = $('#numOrden').text();
    var last_row = dtTMuertos.row(":last").data();
    var array = new Array();
    var i = 0;

    if (typeof (last_row) === "undefined") {
        mensaje("No hay datos que guardar :(", "error")
    }else {
        dtTMuertos.rows().eq(0).each(function( index ) {
            var row = dtTMuertos.row(index);
            var data = row.data();
            var fecha = $('#fch-tm-'+data[0]).val()
            var y1D = ( $('#cant-y1-dia-'+data[0]).val()=="" )?0:$('#cant-y1-dia-'+data[0]).val();
            var y2D = ( $('#cant-y2-dia-'+data[0]).val()=="" )?0:$('#cant-y2-dia-'+data[0]).val();
            var y1N = ( $('#cant-y1-noc-'+data[0]).val()=="" )?0:$('#cant-y1-noc-'+data[0]).val();
            var y2N = ( $('#cant-y2-noc-'+data[0]).val()=="" )?0:$('#cant-y2-noc-'+data[0]).val();
            
            array[i] = {
                orden : codigo,
                dia : fecha,
                y1M : y1D,
                y2M : y2D,
                y1N : y1N,
                y2N : y2N
            };

            i++;
        });

        $.ajax({
            url: base_url+"guardar-tiempos-muertos",
            data: {
                codigo : codigo,
                data : array
            },
            type: 'post',
            async: true,
            success: function (resultado) {
                mensaje('Se guardo con exito :)', 'success')
            }
        }).done(function(data) {
            
        });
    }
});

$(document).on('click','#btnGTLAV',function() {
    codigo = $('#numOrden').text();
    t_lavado = $("#tiempo-lavado").val();
    var last_row = dtTetra.row(":last").data();
    var array2 = new Array();
    var i = 0;

    if (typeof (last_row) === "undefined") {
        mensaje("No hay datos que guardar :(", "error")
    }else {
        dtTetra.rows().eq(0).each(function( index ) {
            var row = dtTetra.row(index);
            var data = row.data();
            var fecha = $('#fch-lava-'+data[0]).val()
            var dia = ( $('#cant-lava-dia-'+data[0]).val()=="" )?0:$('#cant-lava-dia-'+data[0]).val();
            var noche = ( $('#cant-lava-noc-'+data[0]).val()=="" )?0:$('#cant-lava-noc-'+data[0]).val();
            
            array2[i] = {
                orden         : codigo,
                tiempo_lavado : (t_lavado=='')?0:t_lavado,
                fecha         : fecha,
                dia           : dia,
                noche         : noche
            };

            i++;
        });

        $.ajax({
            url: base_url+"guardar-tiempo-lavado",
            data: {
                codigo : codigo,
                data : array2
            },
            type: 'post',
            async: true,
            success: function (resultado) {
                mensaje('Se guardo con exito :)', 'success')
            }
        }).done(function(data) {
            
        });
    }
});

$(document).on('click','#btncCIFAB',function() {
    codigo = $('#numOrden').text();
    consumoInicialElec = $('#consumoInicialElec').val();    
    consumoFinalElec = $('#consumoFinalElec').val();
    consumoInicialAgua = $('#consumoInicialAgua').val();
    consumoFinalAgua = $('#consumoFinalAgua').val();

    if ( codigo=='' ) {
        mensaje("No hay datos que guardar :(", "error")
    }else {
        $.ajax({
            url: base_url+"guardar-costos-indirectos-fab",
            data: {
                consumoInicialElec : consumoInicialElec,
                consumoFinalElec : consumoFinalElec,
                consumoInicialAgua : consumoInicialAgua,
                consumoFinalAgua : consumoFinalAgua,
                codigo: codigo
            },
            type: 'post',
            async: true,
            success: function (resultado) {
                mensaje('Se guardo con exito :)', 'success')
            }
        }).done(function(data) {
            
        });
    }
});
/********EVENTO GUARDAR - END********/

$(document).on('click', '#btnInventarioFull', function() {
    var codigo = $('#numOrden').text();
    var data = 0;
    var pos = 0;
    var array = {};
    var fibra = '';
    var cantidades = [];

    var table = $("#dtInventario").DataTable({
            "destroy":true,
            "ordering": false,
            "info": false,
            "bPaginate": false,
            "bfilter": false,
            "searching": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega una fecha</p>`
            }
    });

    table.rows().eq(0).each(function( index ) {
        var row = table.row(index);
        data = row.data();
    });

    $('#dtInventario tbody tr').each(function() {
        cantidades = [];
        for (var i = 2; i < data.length; i++) {
            var tempo = $(this).find("td").eq(i).find('input').val()
            var fibra = $(this).find("td").eq(1).html();

            cantidades.push(tempo)
            
            array[pos] = {
                'codigo': codigo,
                'fibra' : fibra,
                'cantidades' : cantidades
            }
        }

        pos++;
        
    });

    $.ajax({
        url: base_url+"guardar-inventario-ajax",
        data: {
            codigo:codigo,
            data : array
        },
        type: 'post',
        async: true,
        success: function (resultado) {
            mensaje('Se guardo con exito :)', 'success')
        }
    }).done(function(data) {
        
    });

    /*table.rows().eq(0).each(function( index ) {

        var row = table.row(index);
        var data = row.data();

        var index = data[2].html()

        console.log(index)

        
    });*/
})

/********EVENTO GUARDAR JUMBO ROLL - START********/
$(document).on('click','#btnGJROLL',function() {
    codigo = $('#numOrden').text();
    turno = $("#turno option:selected").val();
    jefe = $("#jefe option:selected").val();
    fechaInicio = $("#fecha01").val();
    fechaFinal = $("#fecha02").val();
    
    resPulper = ( $('#res-pulper').val()=="" )?0:$('#res-pulper').val();
    lavTetrapack = ( $('#lav-tetrapack').val()=="" )?0:$('#lav-tetrapack').val();
    mermaYDRY1 = ( $('#merma-dry-y1').val()=="" )?0:$('#merma-dry-y1').val();
    mermaYDRY2 = ( $('#merma-dry-y2').val()=="" )?0:$('#merma-dry-y2').val();

    var last_row = dtJRoll.row(":last").data();
    var array3 = new Array();
    var i = 0;

    if (typeof (last_row) === "undefined") {
        mensaje("No hay datos que guardar :(", "error")
    }else {
        dtJRoll.rows().eq(0).each(function( index ) {
            var row = dtJRoll.row(index);
            var data = row.data();
            var vinieta_ = ( $('#vineta-'+data[0]).val()=="" )?0:$('#vineta-'+data[0]).val();
            var kg_ = ( $('#cant-kg-'+data[0]).val()=="" )?0:$('#cant-kg-'+data[0]).val();
            var gsm_ = ( $('#cant-gsm-'+data[0]).val()=="" )?0:$('#cant-gsm-'+data[0]).val();
            var yankee_ = ( $('#yankee-'+data[0]).val()=="" )?0:$('#yankee-'+data[0]).val();
            
            array3[i] = {
                vinieta : vinieta_,
                kg      : kg_,
                gsm     : gsm_,
                yankee  : yankee_
            };

            i++;
        });
    }

    $.ajax({
        url: base_url+"guardar-jumboroll",
        data: {
            codigo          : codigo,
            turno           : turno,
            jefe            : jefe,
            fechaInicio     : fechaInicio,
            fechaFinal      : fechaFinal,
            resPulper       : resPulper,
            lavTetrapack    : lavTetrapack,
            mermaYDRY1      : mermaYDRY1,
            mermaYDRY2      : mermaYDRY2,
            data            : array3
        },
        type: 'post',
        async: true,
        success: function (resultado) {
            mensaje('Se guardo con exito :)', 'success')
        }
    }).done(function(data) {
        
    });   

});
/********EVENTO GUARDAR JUMBO ROLL - END********/


$(document).on('click','.add-row-dt-inventarios',function() {
    var fibras = $("#fibra");
    
    $.getJSON(base_url+"fibra-data", function(json) {
        if(json.length>0) {
            fibras.find('option').remove();
            $.each(json, function (i, item) {                
                fibras.append('<option value="' + item['idFibra'] + '">' + item['descripcion'] + '</option>');
            })
        }
    })    
    $('#mdInventarioSolicitado').modal('show');
});

$(document).on('click','#btnGuardarInv',function() {
    var fibra = $("#fibra option:selected").val();
    var codigo = $('#numOrden').text();
    var cantidad = $("#cantidad-fibra").val();

    $.ajax({
        url: base_url+"guardar-inventario",
        type: 'post',
        async: true,
        data: {
            fibra     : fibra,
            cantidad  : cantidad,
            codigo    : codigo
        },
        success: function(json) {
            addRowsInventario();
            $('#mdInventarioSolicitado').modal('hide');
        }
    });    
});

/********INICIALIZANDO CONTROL FECHA - START********/
function inicializaControlFecha2() {
    $('input[class="input-fecha-dos form-control"]').daterangepicker({
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "D",
                "L",
                "M",
                "M",
                "J",
                "V",
                "S"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 0
        },
        singleDatePicker: true,
        showDropdowns: true
    });
}
/********INICIALIZANDO CONTROL FECHA - END********/

$("#turno").change(function() {
    addRowsJumboroll();
})

</script>