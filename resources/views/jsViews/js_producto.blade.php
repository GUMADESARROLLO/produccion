<script type="text/javascript">
  var dtProductos;

  $(document).ready(function() {
    dtProductos = $("#tblProductos").DataTable({
      responsive: true,
      // "autoWidth": false,
      "ajax": {
        "url": "getProductos",
        'dataSrc': '',
      },
      "info": false,
      "destroy": true,
      "bPaginate": true,
      "pagingType": "full",
      "language": {
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "zeroRecords": "No hay coincidencias",
        "loadingRecords": "Cargando datos...",
        oPaginate: {
          sNext: ' Siguiente ',
          sPrevious: ' Anterior ',
          sFirst: ' Primero ',
          sLast: ' Ultimo ',
        },
      },
      "columns": [{
          "title": "CODIDO",
          "data": "codigo"
        },
        {
          "title": "NOMBRE",
          "data": "nombre"
        },
        {
          "title": "DESCRIPCIÓN DEL PRODUCTO",
          "data": "descripcion"
        }, {
          "title": "ESTADO",
          "data": "estado",
          "render": function(data, type, row) {
            if (data == 1) {
              return '<span class="badge badge-success">Activo</span>';
            } else {
              return '<span class="badge badge-danger">Inactivo</span>';
            }
          }
        },
        {
          "title": "OPCIONES",
          "data": "idProducto",
          "render": function(data, type, row) {
            return '<a href="#!" onclick="deleteProducto('+ data +')"><i class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a>'+
                   '<a href="producto/editar/'+ data +'"><i class="feather icon-edit text-c-blue f-30 m-r-10"></i></a>';
          }
        },
      ]
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