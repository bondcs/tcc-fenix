

$(document).ready(function() {
    
        onTable();
        onFnAction();
        simpleDialog();
        populaCidade();
        
//        $("#user").click(function(){
//        
//        $.ajax({
//            type: 'POST',
//            url: Routing.generate('funcionarioAddUser', { "id": 3 }),
//            success: function(result){
//                    $(".main-col").append(result);
//            }
//        
//        })
//        })
        
} );

function onTable(){
    
        oTable = $('#table').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
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
        });
    
}


function onFnAction(){
        
        $("#menuContent a[route]").click(function(){ 
            
                if (key = $(".row_selected").find(".id").html()){
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


function simpleDialog(){
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

    
   


