<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
            url: "getProductos",
            type: 'get',
            async: false,
            success: function(response) {
                $('#tblProductos').DataTable({
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
                        "emptyTable": "REALICE UNA BUSQUEDA",
                        "search":     "BUSCAR"
                    },
                    "columns": [{
                        "data": "codigo", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.codigo+`</h6>
                                    </div>`
                          }
                      },
                      {
                        "data": "nombre", "render": function(data, type, row, meta) {
                          return  `<div class="d-flex align-items-center position-relative">
                                      <div class="flex-1 ms-3" style="text-align: center;">
                                          <h6 class="mb-0 fw-semi-bold"><div class="stretched-link text-dark">`+row.nombre+`</div></h6>
                                      </div>
                                  </div>`
                          }
                      },
                      {
                        "data": "descripcion", "render": function(data, type, row, meta) {
                        return  `<div class="d-flex align-items-center position-relative">
                                  <div class="flex-1 ms-3" style="text-align: center;">
                                      <h6 class="mb-0 fw-semi-bold"><div class="stretched-link text-dark">`+row.descripcion+`</div></h6>
                                  </div>
                              </div>`
                        }
                      }, 
                      {
                        "data": "idProducto",
                        "render": function(data, type, row) {
                          return '<div class="text-center"><a href="#!" onclick="deleteProducto('+ data +')"><i class="far fa-trash-alt text-c-red f-20 m-r-10"></i></a>'+
                                '<a href="producto/editar/'+ data +'"><i class="far fa-edit text-c-blue f-20 m-r-10"></i></a></div>';
                        }
                      },
                    ]
                  });
                }
              });

     $("#tblProductos_filter").hide();
     $("#tblProductos_length").hide();
     $('#InputBuscar').on('keyup', function() {
       var table = $('#tblProductos').DataTable();
       table.search(this.value).draw();
     });
  //   $('#tblProductos_paginate');
  });

  function deleteProducto(idProducto) {
    swal({
      title: 'Eliminar este producto',
      text: "¿Desea eliminar este producto?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Si, eliminar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      mensaje('Actualizado con exito', 'success');
      if (result.value) {
        $.getJSON("producto/eliminar/" + idProducto, function(json) {
          if (json == true) {
            location.reload();
          }
        })
      }
    })
  }
</script>