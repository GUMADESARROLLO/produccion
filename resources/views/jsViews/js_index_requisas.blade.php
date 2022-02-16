<script type="text/javascript">
    var dtRequisas ;
    dtRequisas = $("#tblRequisas").DataTable({
        responsive: true,
        "destroy": true,

        // "autoWidth": false,
        "ajax": {
            "url": "getRequisas",
            'dataSrc': '',
        },
        "info": false,

        "pagingType": "full",
        "language": {
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "zeroRecords": "No hay coincidencias",
            "loadingRecords": "Cargando datos...",
           oPaginate: {
                sNext: ' Siguiente ',
                sPrevious: ' Anterior ',
                sFirst: ' Primero ',
                sLast: ' Ultimo ',
            },
            "lengthMenu": "MOSTRAR _MENU_",
            "emptyTable": "NO HAY DATOS DISPONIBLES",
            "search": "BUSCAR"
        },

        "columns": [{
                "data": "id"
            },
            {
                "data": "numOrden"
            },
            {
                "data": "codigo_req"
            },
            {
                "data": "turno"
            },
            {
                "data": "created_at"
            },
            {
                "data": "acciones"
            },
        ],
        "columnDefs": [{
            "className": "dt-center",
            "targets": [0,1,2, 3,4,5]
        }, ],
    });

    $("#tblRequisas_filter").hide();
    $("#tblRequisas_length").hide();
    $('#InputBuscar').on('keyup', function() {
        var table = $('#tblRequisas').DataTable();
        table.search(this.value).draw();
    });
</script>
