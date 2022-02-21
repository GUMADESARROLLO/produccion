<script type="text/javascript">
    let dtHome;
    dtHome = $('#tblHome').DataTable({ // Costos por ORDEN
        "ajax": {
            "url": "detalleHome",
            'dataSrc': '',
        },
        "order": [
            [0, "desc"]
        ],
        "destroy": true,
        "bPaginate": true,
        "pagingType": "full",
        "language": {
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "emptyTable": `<p class="text-center">N/A</p>`,
            "search": "BUSCAR",
            "oPaginate": {
                sNext: " Siguiente ",
                sPrevious: " Anterior ",
                sFirst: "Primero ",
                sLast: " Ultimo",
            },
        },
        "columns": [{
                "title": "NO. ORDEN",
                "data": "numOrden"
            },
            {
                "title": "Nombre",
                "data": "nombre"
            },
            {
                "title": "PROD.REAL KG",
                "data": "prod_real",
            },
            {
                "title": "PROD.REAL TON.",
                "data": "prod_real_ton"
            },
            {
                "title": "COSTO TOTAL C$",
                "data": "costo_total"
            },
            {
                "title": "T.C",
                "data": "tipo_cambio"
            },
            {
                "title": "COSTO TOTAL $",
                "data": "CTotal_dollar"
            },
            {
                "title": "COSTO TON. $",
                "data": "CTon_dollar"
            },
            {
                "title": "VER",
                "data": "numOrden",
                "render": function(data, type, row) {
                    return  '<a href="home/detalle/' + data + '" target="_blank"><i class="feather icon-eye text-c  f-30 m-r-10"></i></a>' +
                            '<a href="detalleOrdenPDF/' + data + '" target="_blank"><i class="far fa-file-pdf text-c-red f-30 m-r-10"></i></a>'
                }
            },
        ],
        "columnDefs": [{
            "targets": [0],
            "className": "dt-center",
        }]
    });

    $("#tblHome_filter").hide();
    $("#tblHome_length").hide();
    $('#cont_search').show();
    $('#InputBuscar').on('keyup', function() {
        var table = $('#tblHome').DataTable();
        table.search(this.value).draw();
    });
</script>