<script type="text/javascript">
$(document).ready(function() {

    $('#nestable').nestable().on('change', function () {
        const data = {
            menu: window.JSON.stringify($('#nestable').nestable('serialize')),
            _token: $('input[name=_token]').val()
        };
        $.ajax({
            url: 'menu/guardar-orden',
            type: 'POST',
            dataType: 'JSON',
            data: data,
            success: function (respuesta) {
            }
        });
    });

    $('#nestable').nestable('expandAll');

});

$('.menu_rol').on('change', function() {
	var data = {
		menu_id: $(this).data('menuid'),
		rol_id: $(this).val(),
		_token: $('input[name=_token]').val()
	}
	//console.log( $(this).data('menuid'));

	if ($(this).is(':checked')) {
		data.estado = 1
	} else {
		data.estado = 0
	}
	ajaxRequest('./menu-rol', data)
})

function ajaxRequest(url, data) {
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		success: function(response) {
                    //console.log('Exito en guardar fibras');
                    mensaje(response.responseText, 'success');
                },
                error: function(response) {
                    mensaje(response.responseText, 'error');
                }
	});
}




</script>