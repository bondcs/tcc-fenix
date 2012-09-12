$(document).ready(function() {
    
        onTableAjax();
        ajaxSubmitTable();
})

function onTableAjax(){
        
        oTable = $('.table').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bRetrieve": true,
            "bProcessing": true,
            "sAjaxSource": urlSource,
            "sDom": '<"H"Tfr>t<"F"ip>',
                "oTableTools": {
                    "sRowSelect": "single",
                    "sSelectedClass": "row_selected",
                    "aButtons": [
                        {
                            "sExtends": "text",
                            "sButtonText": "Adicionar",
                            "fnClick" : function(){
                                 ajaxLoadDialog(urlAdd);
                            }
                        },
                        
                        {
                            "sExtends": "select_single",
                            "sButtonText": "Editar",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0][aaData[0].length-1];
                                 ajaxLoadDialog(Routing.generate(routeEdit, {"id" : id}));
                                 
                            }
                        },
                        
                        {
                            "sExtends": "select_single",
                            "sButtonText": "Deletar",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0][aaData[0].length-1];
                                 $( "#dialog-confirm" ).dialog("open");
                                 $( "#dialog-confirm" ).dialog("option", "buttons", {
                                     "Deletar": function() {
                                            ajaxDelete(Routing.generate(routeDelete, {"id" : id})); 
                                            $(this).dialog("close");
                                     },
                                     "Cancelar": function(){
                                            $(this).dialog("close");
                                     }
                                 } );
                                 return false;
                                 
                            }
                        }
                        
                    ]
                }
        });    
}

function ajaxLoadDialog(url){
    
    $.ajax({
            type: 'GET',
            url: url,
            success: function(result){
                $(".simpleDialog").html(result);
                $(".simpleDialog").dialog('open');
                onReadyAjax();
                return false;
            }
   })
    
}

function ajaxDelete(url){
    
    $.ajax({
            type: 'POST',
            url: url,
            success: function(){
                $('.redraw').dataTable().fnReloadAjax();
                $(".hidden").addClass("DTTT_disabled");
                notifity("delete");
                return false;
            }
   })
    
}
