<script type="text/javascript">
    var dtRequisas ;
    dtRequisas = $("#tblRequisas").DataTable({
        responsive: true,
        "destroy": true,
        "ajax": {
            "url": "getRequisas",
            'dataSrc': '',
        },
        "info": true,
        "order": [[ 0, "desc" ]],
        "pagingType": "full",
        "info": false,
        "language": {
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "zeroRecords": "No hay coincidencias",
            "loadingRecords": "Cargando datos...",
           oPaginate: {
                sNext: ' Siguiente ',
                sPrevious: ' Anterior ',
                sFirst: 'Primero ',
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
                "data": "tipo"
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
        },{
                "targets": [0],
                "visible": false,
                "searchable": false
            } ],
    });

    $("#tblRequisas_filter").hide();
    $("#tblRequisas_length").hide();
    $('#InputBuscar').on('keyup', function() {
        var table = $('#tblRequisas').DataTable();
        table.search(this.value).draw();
    });
</script>
