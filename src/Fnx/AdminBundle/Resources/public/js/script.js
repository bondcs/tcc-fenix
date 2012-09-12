$(document).ready(function() {
        
        onTable();
        onTabs();
        onFnAction();
        actionDialog();
        simpleDialog();
        initDatepicker()
        populaCidade();
        ajaxDialog();
        confirmDialog();
        cpfCnpj(); 
        onChangecpfCnpj();
        efeitoErro();
        populaComplete();
        ajaxSubmit();
        
} );

function onReadyAjax(){
    
        simpleDialog();
        confirmDialog();
        cpfCnpj(); 
        onChangecpfCnpj();
        populaCidade();
        initDatepicker();
        ajaxSubmitTable();
        ajaxSubmit();
        onTable();
        addFuncionario();
        removeFuncionario();
        onMultiSelect();

        
}

function onTable(){
    
        oTable = $('#table').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bRetrieve": true
            
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

function onTabs(){
        
        $( ".tabs" ).tabs();
}

function onMultiSelect(){
   $(".multiselect").multiselect();
    
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
                               $(".simpleDialog").dialog( "option", "title", $(".ajax-link").attr('title') );
                               $(".simpleDialog").dialog('open');
                               $("#menuContent a[route], .menuDialog a[route]").attr('href', "#");
                               
                               /* hack para recarregar funcões previamente carregadas no onReady()*/
                               onReadyAjax();
                               
                       }
                   })
            }
            
        })
             

}

function ajaxSubmit(){
    
                $(".ajaxForm").submit(function(){
                    var url = $('.ajaxForm').attr("action");
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $('.ajaxForm').serialize(),
                        success: function(result){

                            if (result['dialogName']){
                               notifity(result['message']);
                               $(result['dialogName']).dialog('close');
                               return false;
                            } 

                            $(".simpleDialog").html(result);
                            $('.simpleDialog').dialog('close');
                            $('.simpleDialog').dialog('open');

                            /* hack para recarregar funcões previamentes carregadas no onReady()*/
                            onReadyAjax();
                        }
                    })
                    
                    return false;
              })
}           


function onFnAction(){
        
        $("#menuContent a[route], .menuDialog a[route]").click(function(e){
                if (key = $(".row_selected").find(".id").html()){
                    var url = Routing.generate($(this).attr('route') , {"id": key});
                    $(this).attr('href', url);
                    
                    if ($(this).hasClass("confirm-link")){
                        $("#dialog-confirm").dialog('open');
                        return false;
                    }

                }else{
                    $('#dialogAction').dialog('open');
                    e.preventdefault()
                    return false;
                }
                
        })
    
}

function confirmDialog(){
    
        var url;
        
	$( "#dialog-confirm" ).dialog({
                autoOpen: false,
		resizable: false,
		height:"auto",
                modal: true,
                close: function(){
                     $("#menuContent a[route], .menuDialog a[route]").attr('href', "#");
                },
		buttons: {
			"Confirmar": function() { 
                                if (url == null){
                                    window.location.href = $(".confirm-link").attr("href"); 
                                }else{
                                    window.location.href = url;
                                }
				$( this ).dialog( "close" );
                                
			},
			"Cancelar": function() {
				$( this ).dialog( "close" ); 
                                return false;
			}
		}
	});
        
        $( ".dialog-confirm-link" ).on("click",function(){
            url = $(this).attr('href');
            $("#dialog-confirm").dialog('open');
            return false;

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

function dialogClose(){
        $( ".simpleDialog" ).dialog('close');
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

function populaComplete(){
    
    $(".complete input").focus(function(){
        
        $.ajax({
            type: 'POST',
            url: Routing.generate("ajaxCliente"),
            success: function(valores){
                var nomes = new Array();
                $.each(valores,function(key,valor){
                       nomes[key] = valor['nome'];
                })
                $(".complete input").autocomplete({
                    source: nomes
                })
            }
        
        })
    })
    
    return false;
}

 function onChangecpfCnpj(){
     
     
     $("#pessoa input").on('change',function(){
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

function initDatepicker() {
    
    $.datepicker.regional['pt-BR'] = {
		closeText: 'Fechar',
		prevText: '&#x3c;Anterior',
		nextText: 'Pr&oacute;ximo&#x3e;',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
                defaultDate: '00/00/00',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
                
    
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    
//    $('#datepicker')
//        .attr('readonly', 'readonly')
//        .datepicker({
//            dateFormat: 'dd/mm/yy h:i:',
//            changeMonth: true,
//            yearRange: "1920:2000",
//	    changeYear: true
//        });
//        
//    $('.datepicker input')
//        .datepicker('disable')
//        .attr('readonly', 'readonly')
//        .datepicker({
//            dateFormat: 'dd/mm/yy'
//        });
//        
//        
    $.timepicker.regional['pt-BR'] = {
        timeFormat: 'hh:mm:ss',
	timeOnlyTitle: 'Escolha um tempo',
	timeText: 'Tempo',
	hourText: 'Hora',
	minuteText: 'Minuto',
	secondText: 'Segundo',
	millisecText: 'Milésimo',
	currentText: 'Agora',
	closeText: 'Add',
	ampm: false
    };
    
    $.timepicker.setDefaults($.timepicker.regional['pt-BR']);
      
    $('.datepicker input').datetimepicker();
    
    $('.datepicker input').blur();
    return false;

}



function ajaxSubmitTable(){
    
    $(".ajaxFormTable").submit(function(){
        
                $.ajax({
                    type: 'POST',
                    url: $('.ajaxFormTable').attr("action"),
                    data: $('.ajaxFormTable').serialize(),
                    success: function(result){
                        
                        if (result['dialogName']){
                           $('.redraw').dataTable().fnReloadAjax();
                           notifity(result['message']);
                           $(result['dialogName']).dialog('close');
                           $(".hidden").addClass("DTTT_disabled");
                           return false;
                        } 
                        $(".simpleDialog").html(result);
                        $('.simpleDialog').dialog('close');
                        $('.simpleDialog').dialog('open');
                        
                        /* hack para recarregar funcões previamentes carregadas no onReady()*/
                        onReadyAjax();
                    }
                })
                
        return false;
    })
    
}


function notifity(tipo){
    $.pnotify.defaults.styling = "jqueryui";
    
    if (tipo == 'add'){
        $.pnotify({
            title: 'Sucesso!',
            text: 'O registro foi efetuado.',
            type: 'success'
        });
    }
    
    if (tipo == 'edit'){
        $.pnotify({
            title: 'Sucesso!',
            text: 'O registro  foi alterado.',
            type: 'info'
        }); 
    }
    
    if (tipo == 'delete'){
        $.pnotify({
            title: 'Sucesso!',
            text: 'O registro  foi excluído.',
            type: 'error'
        }); 
    }
    
}

function addFuncionario(){
    
    $("#funcionarioAdd").on("click", function(){
        var widget = $("#funcionario-container").attr("data-prototype");
        widget = widget.replace(/\$\$name\$\$/g, funcionarioCount);
        funcionarioCount++;
        var newLi = $("<li></li>").html(widget);
        newLi.append('<a class="funcionarioClose" href="#">Close</a>');
        newLi.appendTo($("#funcionario-container"));
        removeFuncionario();
        return false;
    });
   
    return false;
}

function removeFuncionario(){
   
    $(".funcionarioClose").on("click",function(){
        $(this).parent().remove();
        return false;
    })
    
    return false;
}
