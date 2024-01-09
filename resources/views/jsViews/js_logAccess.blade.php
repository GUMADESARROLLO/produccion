<script type="text/javascript">
  $(document).ready(function() {
    inicializaControlFecha();
    //   $('#tblProductos_paginate');
    getRange('R1');

    $('#id_search').on('click', function() {
        getInformacion()
    });
  });
  function getRange(id){
      var rango = id.replace(/[\ U,R]/g, '')
      $('.DateRange').removeClass('DateRange');
      $("#"+id).addClass('DateRange');
      setRange(rango)

  }
  $( "#frm_lab_row").change(function() {
      var table = $('#tblProductos').DataTable();
      table.page.len(this.value).draw();
  });
    
  function setRange(r){
        const startOfMonth = moment().subtract(r, "month").startOf('month').format('YYYY-MM-DD');
        const endOfMonth   = moment().endOf('month').format('YYYY-MM-DD');
      
        $("#fecha_hora_inicial").val(startOfMonth);
        $("#fecha_hora_final").val(endOfMonth);
        getInformacion();
    }
    function getInformacion(){
      f1 = $("#fecha_hora_inicial").val();
      f2 = $("#fecha_hora_final").val();

      var Fechas = {
          f1: f1,
          f2: f2
      };

      $.ajax({
            url: "getDataLogs",
            type: 'post',
            async: false,
            data: Fechas,
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
                                      <h6 class="mb-0 fw-semi-bold">`+row.idUser+`</h6>
                                    </div>`
                          }
                      },
                      {
                        "data": "nombre", "render": function(data, type, row, meta) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.name+`</h6>
                                    </div>`
                          }
                      },
                      {
                        "data": "descripcion", "render": function(data, type, row, meta) {
                        return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.description+`</h6>
                                    </div>`
                        }
                      }, 
                      {
                        "data": "idProducto",
                        "render": function(data, type, row) {
                          return  `<div class="text-center">
                                      <h6 class="mb-0 fw-semi-bold">`+row.hits+`</h6>
                                    </div>`
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
  
    }
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