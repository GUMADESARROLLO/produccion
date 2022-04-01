<script type="text/javascript">
    let dtFibra;
    $(document).ready(function () {

        dtFibra = $('#dtFibras').DataTable({ // Costos por ORDEN
            "ajax": {
                "url": "fibra-data",
                'dataSrc': '',
            },
            "order": [
                [0, "desc"]
            ],
            "destroy": true,
            "bPaginate": true,
            "pagingType": "full",
            "info": false,
            "language": {
                "emptyTable": `<p class="text-center">Agrega horas productivas</p>`,
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "search": "BUSCAR",
                "oPaginate": {
                    sNext: " Siguiente ",
                    sPrevious: " Anterior ",
                    sFirst: "Primero ",
                    sLast: " Ultimo",
                },
            },
            "columns": [{
                "title": "CODIGO",
                "data": "codigo"
            },
                {
                    "title": "DESCRIPCION",
                    "data": "descripcion"
                },
                {
                    "title": "U/M",
                    "data": "unidad"
                },
                {
                    "title": "ESTADO",
                    "data": "estado",
                    "render": function (data, type, row) {
                        if (data) {
                            return '<span class = "badge badge-success"> Activo </span>'
                        } else {
                            return '<span class = "badge badge-danger" > Inactivo </span>'
                        }
                    }
                },
                {
                    "title": "OPCIONES",
                    "data": "idFibra",
                    "render": function (data, type, row) {
                        return ' <a href="#!" onclick="deleteFibra(' + data + ')"><i class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a>' +
                            ' <a href="fibras/editar/' + data + '"><i class="feather icon-edit text-c-blue f-30 m-r-10"></i></a>';
                    }
                },
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "dt-center",
            },
                {
                    "targets": [1],
                    "width": '35%',
                    "className": "dt-center",
                }]
        });

        $("#dtFibras_filter").hide();
        $("#dtFibras_length").hide();
        $('#cont_search').show();
        $('#InputBuscar').on('keyup', function () {
            var table = $('#dtFibras').DataTable();
            table.search(this.value).draw();
        });


    });


    function deleteFibra(idFibra) {
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
</script>
