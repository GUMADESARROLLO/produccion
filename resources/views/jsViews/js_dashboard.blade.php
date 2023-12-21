<script type="text/javascript">
    
    $(document).ready(function() {
        moment.locale('es');
        //const startOfMonth = moment().startOf('month').format('YYYY-MM-DD');
        getRange('R1')
        inicializaControlFecha();
        $('#tbl_search_conversion').on('keyup', function() {
            var table = $('#tblConversion').DataTable();
            table.search(this.value).draw();
        });
        $('#tbl_search_humedo').on('keyup', function() {
            console.log(this.value)
            var table = $('#tblProcesoHumedo').DataTable();
            table.search(this.value).draw();
        });
    });

    function setRange(r){
        const startOfMonth = moment().subtract(r, "month").startOf('month').format('YYYY-MM-DD');
        const endOfMonth   = moment().endOf('month').format('YYYY-MM-DD');
        var currMonthName  = moment().format('MMMM');

        $("#fecha_hora_inicial").val(startOfMonth);
        $("#fecha_hora_final").val(endOfMonth);
        $("#id_name_month").text(currMonthName);

        getInformacion();
    }
    function getRange(id){
        var rango = id.replace(/[\ U,R]/g, '')
        $('.DateRange').removeClass('DateRange');
        $("#"+id).addClass('DateRange');
        setRange(rango)

    }
    
    $('#id_search').on('click', function() {
        getInformacion()
    });
    
    function getInformacion(){
        
        
        f1 = $("#fecha_hora_inicial").val();
        f2 = $("#fecha_hora_final").val();

        var Fechas = {
            f1: f1,
            f2: f2
        };

        $.getJSON("./dashboard_detalles", Fechas, function (result) {

            var val01        = numeral(result[0]['data']['Humedo']).format('0,0.00');

            //HORAS TRABAJADAS
            var hrsHumedo       = numeral(result[0]['data']['Humedo']).format('0,0.00');
            var hrsConversion   = numeral(result[0]['data']['Conversion']).format('0,0.00');

            $("#id_card_hrs_trab_humedo").text(hrsHumedo)
            $("#id_card_hrs_trab_conversion").text(hrsConversion)

            //COSTOS TOTALES
            var costo_tt             = numeral(result[1]['data']['costo_tt']).format('0,0.00');            
            var costo_tt_dlr_ton     = numeral(result[1]['data']['costo_tt_dlr_ton']).format('0,0.00');            
            var costo_tt_dolar       = numeral(result[1]['data']['costo_tt_dolar']).format('0,0.00');            

            $("#id_card_total_cordoba").text(costo_tt)
            $("#id_card_total_dolares").text(costo_tt_dolar)
            $("#id_card_total_tonelada_dolares").text(costo_tt_dlr_ton)

            //PROCESO HUMEDO
            var pro_real        = numeral(result[2]['data']['pro_real']).format('0,0.00');            
            var pro_total        = numeral(result[2]['data']['pro_total']).format('0,0.00');            
            

            $("#id_card_pro_real").text(pro_real)
            $("#id_card_pro_total").text(pro_total)

            //CONVERSION

            var dt_tt_jr        = numeral(result[3]['data']['dt_tt_jr']).format('0,0.00');            
            var dt_tt_bul        = numeral(result[3]['data']['dt_tt_bul']).format('0,0.00');            

            $("#id_card_jr_total_kg").text(dt_tt_jr)
            $("#id_card_total_bultos_unds").text(dt_tt_bul)



            //ORDENES DE PRODUCCION
            getOrdenesProcesoHumedo(result[4]['data']);
            getOrdenesConversion(result[5]['data']);
            
            


        });
    }
    function getOrdenesProcesoHumedo(datos) {

        console.log(datos)

        $('#tblProcesoHumedo').DataTable({
            "data": datos,
            "destroy": true,
            "info": false,
            "order": [
                [1, "desc"]
            ],
            "language": {
                "zeroRecords": "NO HAY COINCIDENCIAS",
                "paginate": {
                    "first": "Primera",
                    "last": "Última ",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "REALICE UNA BUSQUEDA UTILIZANDO LOS FILTROS DE FECHA",
                "search": "BUSCAR"
            },
            'columns': [
                
                {
                    "title": "N° ORDEN",
                    "data": "numOrden",
                    "render": function(data, type, row, meta) {
                        return '<span class="text-primary" onclick="eHumedo(' + row.id + ')">' + data + '</span>'

                    }
                },
                {
                    "title": "PRODUCTO",
                    "data": "nombre"
                },    
                {
                    "title": "DESCRIPCION",
                    "data": "nombre"
                }, 
                {
                    "title": "FECHA INICIO",
                    "data": "fechaInicio"
                },
                {
                    "title": "FECHA FINAL",
                    "data": "fechaFinal"
                },
                {
                    "title": "PRO. REAL (KG)",
                    "data": "prod_real",
                    "render": $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    "title": "PRO. TOTAL (KG)",
                    "data": "prod_total",
                    "render": $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    "title": "PROD.REAL TON",
                    "data": "prod_real_ton",
                    "render": $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    "title": "COSTO TOTAL C$",
                    "data": "costo_total",
                    "render": $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    "title": "T.C",
                    "data": "tipo_cambio",
                    "render": $.fn.dataTable.render.number(',', '.', 2)

                },
                {
                    "title": "COSTO.TON $",
                    "data": "costo_total_dolar",
                    "render": $.fn.dataTable.render.number(',', '.', 2)

                },
            ],
            "columnDefs": [{
                    "className": "dt-center",
                    "targets": [3,4]
                },
                {
                    "className": "dt-right",
                    "targets": [5,6,7,8,9,10]
                },
                {
                    "visible": false,
                    "searchable": false,
                    "targets": []
                },
                {
                    "width": "11%",
                    "targets": []
                },
            ],
        });

        $("#tblProcesoHumedo_length").hide();
        $("#tblProcesoHumedo_filter").hide();
    }

    function getOrdenesConversion(datos) {

        f1 = $("#fecha_hora_inicial").text();
        f2 = $("#fecha_hora_final").text();

        $('#tblConversion').DataTable({
            "data": datos,
            "destroy": true,
            "info": false,
            "order": [
                [1, "desc"]
            ],
            "language": {
                "zeroRecords": "NO HAY COINCIDENCIAS",
                "paginate": {
                    "first": "Primera",
                    "last": "Última ",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "REALICE UNA BUSQUEDA UTILIZANDO LOS FILTROS DE FECHA",
                "search": "BUSCAR"
            },
            'columns': [{
                    "title": "id",
                    "data": "id"
                },
                {
                    "title": "N° ORDEN",
                    "data": "num_orden",
                    "render": function(data, type, row, meta) {
                        return '<span class="text-primary" onclick="eConversion(' + row.id + ')">' + data + '</span>'

                    }
                },
                {
                    "title": "PRODUCTO",
                    "data": "nombre"
                },                
                {
                    "title": "HORAS TRABAJADAS",
                    "data": "Hrs_trabajadas",
                    "render": $.fn.dataTable.render.number(',', '.', 2)
                },
                {
                    "title": "PESO %",
                    "data": "PESO_PORCENT",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return $.fn.dataTable.render.number(',', '.', 2).display(0);
                        } else {
                            return $.fn.dataTable.render.number(',', '.', 2).display(data);

                        }
                    }

                },
                {
                    "title": "TOTAL DE BULTOS (UNDS)",
                    "data": "TOTAL_BULTOS_UNDS",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return $.fn.dataTable.render.number(',', '.', 2).display(0);
                        } else {
                            return $.fn.dataTable.render.number(',', '.', 2).display(data);
                        }
                    }
                },
            ],
            "columnDefs": [{
                    "className": "dt-center",
                    "targets": [1, 2]
                },
                {
                    "className": "dt-right",
                    "targets": [3,4,5]
                },
                {
                    "visible": false,
                    "searchable": false,
                    "targets": [0]
                },
                {
                    "width": "11%",
                    "targets": [1,2]
                },
            ],
        });

        $("#tblConversion_length").hide();
        $("#tblConversion_filter").hide();
    }
    function eConversion(gPosition) {
        var table = $('#tblConversion').DataTable();
        var row = table.rows().data();

        const ArrayRows = Object.values(row);
        var index = ArrayRows.findIndex(s => s.id == gPosition)
        row = row[index]


        window.location = "doc/" + row.num_orden;
    }
    function eHumedo(gPosition) {
        var table = $('#tblProcesoHumedo').DataTable();
        var row = table.rows().data();

        const ArrayRows = Object.values(row);
        var index = ArrayRows.findIndex(s => s.id == gPosition)
        row = row[index]


        window.location = "orden-produccion/detalle/" + row.numOrden;
    }

    

    
</script>