

$(document).ready(function() {
        
	oTable = $('#table').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
           
        });
        
        $("#table tbody tr").click( function() {
            
            // alterar a cor do fundo da linha
            if ( $(this).hasClass('row_selected') ) {
                $(this).removeClass('row_selected');
            }
            else {
                oTable.$('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
            }
            
            // id mostrado na tabela.
            var key = $(this).find(".id").html();
            fnOnDelete(key);    
            fnOnId(key);   
            
        });

} );

$('#saveLink').click(function(){
    $('#form').submit();
});


function fnOnId(key){
    
         var url = Routing.generate($(".edit-link").attr('route') , {"id": key});
         $(".edit-link").attr('href', url);
         
         url = Routing.generate($(".publi-link").attr('route') , {"id": key});
         $(".publi-link").attr('href', url);
         
         url = Routing.generate($(".publi-link").attr('route') , {"id": key});
         $(".publi-link").attr('href', url);
         
         url = Routing.generate($(".unpubli-link").attr('route') , {"id": key});
         $(".unpubli-link").attr('href', url);
         
         url = Routing.generate($(".archive-link").attr('route') , {"id": key});
         $(".archive-link").attr('href', url);
}

function fnOnDelete(key){
        
        var url = Routing.generate($(".delete-link").attr("route"), {'id' : key});
        $(".delete-link").attr('href', url);
        
        if (key){
            $(".confirm-link").click(function(){
                    $("#dialog-confirm").dialog('open');
                    return false;
            })
        }    
}


function fnGetSelected( oTableLocal )
{
    return oTableLocal.$('tr.row_selected');
}

$(function(){
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
			}
		}
	});
});

    
   


