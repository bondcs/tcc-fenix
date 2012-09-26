

$(document).ready(function() {

        onTable();
        onFnAction();
        actionDialog();
        simpleDialog();
        populaCidade();
        ajaxDialog();
        confirmDialog();
        cpfCnpj();
        onChangecpfCnpj();
        efeitoErro();

	$('.moeda').focus(function(){
	    if($(this).val() != '')
		$(this).val(desformataDinheiro($(this).val()));
	});

	$('.moeda').blur(function(){
	    if($(this).val() != '')
		$(this).val(formataDinheiro($(this).val()));
	});
} );

function onTable(){

        oTable = $('table.tablePlugin').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bRetrieve": true,
             "oLanguage": {
                "sSearch": "Buscar: ",
                "sEmptyTable": "Não existe nenhum registro para ser mostrado",
                "oPaginate": {
                    "sFirst": "Inicio",
                    "sLast": "Ultima",
                    "sNext": "Próxima",
                    "sPrevious": "Anterior"
                  },
                "iDisplayLength": 25,
                "sInfo": "Mostrando as linhas de _START_ à _END_ em um total de _TOTAL_",
                "sLengthMenu": "Mostrar _MENU_ linhas"
                 //"Got a total of _TOTAL_ entries to show (_START_ to _END_)"
              }
        });

        $("table.tablePlugin tbody tr").click( function() {

            // alterar a cor do fundo da linha
            if ( $(this).hasClass('row_selected') ) {
                $(this).removeClass('row_selected');
            }
            else {
                oTable.$('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
            }
        });

}


function ajaxDialog(){

        $(".ajax-link").click(function(event){
             event.preventDefault();
             var url = $(this).attr("href");
             if (url != '#'){
                $.ajax({
                       type: 'GET',
                       url: url,
                       success: function(result){
                               $(".simpleDialog").html(result);
                               $('.simpleDialog').dialog('open');
                               $("#menuContent a[route], .menuDialog a[route]").attr('href', "#");
                       }
                   })
            }

        })


}

function ajaxSubmit(){

                var url = $('.ajaxForm').attr("action");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $('.ajaxForm').serialize(),
                    success: function(result){

                        if (result['success']){
                            window.location.href = result['success'];
                            return false;
                        }

                        $(".simpleDialog").html(result);
                        $('.simpleDialog').dialog('close');
                        $('.simpleDialog').dialog('open');
                    }
                })
}



function onFnAction(){

        $("#menuContent a[route], .menuDialog a[route]").click(function(){
                if (key = $(".row_selected").find(".id").eq(0).html()){
                    var url = Routing.generate($(this).attr('route') , {"id": key});
                    $(this).attr('href', url);

                    if ($(this).hasClass('confirm-link')){
                        $("#dialog-confirm").dialog('open');
                        return false;
                    }

                }else{
                    $('#dialogAction').dialog('open');
                }
        })

}

$(function(){
	$( ".delete-alone" ).click(function(){
            $("#dialog-confirm").dialog('open');
            return false;
        });
});


function confirmDialog(){
	$( "#dialog-confirm" ).dialog({
                autoOpen: false,
		resizable: false,
		height:"auto",
		modal: true,
		buttons: {
			"Deletar": function() {
				$( this ).dialog( "close" );
                                window.location.href = $(".delete-link").attr('href');
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
                                $("#menuContent a[route], .menuDialog a[route]").attr('href', "#");
                                return false;
			}
		}
	});

}

function actionDialog(){
        $( "#dialogAction" ).dialog({
                autoOpen: false,
		resizable: false,
                height:"auto",
		modal: true,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
                                return false;
			}
		}
	});


}

function simpleDialog(){
        $( ".simpleDialog" ).dialog({
                autoOpen: false,
		resizable: false,
                height:"auto",
                width:"auto",
		modal: true
	});


}

function populaCidade(){

    $("#estado").change(function(){

        $.ajax({
            type: 'POST',
            url: Routing.generate('ajaxCidade', { estadoId: $('#estado').val() }),
            success: function(valores){
                $('#cidade').empty();
                var options = "";

                $.each(valores,function(key,valor){
                       options += '<option value="'+ valor['id']+ '">'+ valor['nome']+'</option>';
                })
                $("#cidade").html(options);
            }

        })
})
}

 function onChangecpfCnpj(){


     $("#pessoa input").bind('change',function(){
        cpfCnpj();
     })

     return false;

 }

function cpfCnpj(){

        var valor = $("#form input[type='radio']:checked").val();

        if (valor == 'j'){

             $("#fisico").addClass("hide");

             if ($("#juridico").hasClass("hide")){
                  $("#juridico").removeClass("hide");
                  $("#responsavel").removeClass("hide");
             }

        }else{
             $("#juridico").addClass("hide");
             $("#responsavel").addClass("hide");
             if ($("#fisico").hasClass("hide")){
                  $("#fisico").removeClass("hide");
             }

        }

        return false;
}

function efeitoErro(){
    $(".flash-success, .flash-error").delay(4000).slideUp("slow");
    return false;

}

function number_format (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function formataDinheiro(value){
    return "R$ " + number_format(value, 2, ',','');
}

function desformataDinheiro(value){
    return value.replace(",", ".").slice(3) * 1;
}