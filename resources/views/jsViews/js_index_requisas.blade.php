<script type="text/javascript">
    
$(document).ready(function() {
    $.ajax({
            url: "getRequisas",
            type: 'get',
            async: false,
            success: function(response) {
                $('#tblRequisas').DataTable({
                    "data":response,
                    "destroy" : true,
                    "info":    false,
                    "lengthMenu": [[10,-1], [10,"Todo"]],
                    "language": {
                        "zeroRecords": "NO HAY COINCIDENCIAS",
                        "paginate": {
                            "first":      "Primera",
                            "last":       "Última ",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        "lengthMenu": "MOSTRAR _MENU_",
                        "emptyTable": "NO HAY DATOS QUE MOSTRAR",
                        "search":     "BUSCAR"
                    },
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "numOrden", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.numOrden+`</h6>
                                    </div>`
                          }
                        },
                        {
                            "data": "codigo_req", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.codigo_req+`</h6>
                                    </div>`
                          }
                        },
                        {
                            "data": "tipo", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.tipo+`</h6>
                                    </div>`
                          }
                        },
                        {
                            "data": "turno", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.turno+`</h6>
                                    </div>`
                          }
                        },
                        {
                            "data": "created_at", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.created_at+`</h6>
                                    </div>`
                          }
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
            }
        })

    $("#tblRequisas_filter").hide();
    $("#tblRequisas_length").hide();
    $('#InputBuscar').on('keyup', function() {
        var table = $('#tblRequisas').DataTable();
        table.search(this.value).draw();
    });
})
</script>
