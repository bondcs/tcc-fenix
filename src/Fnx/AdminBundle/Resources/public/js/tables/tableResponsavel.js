$(document).ready(function(){
    onTableResponsavel()
})


function onTableResponsavel(){
        
        oTable = $('.tableResponsavel').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bRetrieve": true,
            "bProcessing": true,
            "sAjaxSource": urlSource,
            "aoColumnDefs": [{"bVisible": false, "aTargets": [3]}],
            "bAutoWidth": false,
            "oLanguage": {
                "sProcessing":   "Processando...",
                "sLengthMenu":   "Mostrar _MENU_ registros",
                "sZeroRecords":  "Não foram encontrados resultados",
                "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                "sInfoPostFix":  "",
                "sSearch":       "Buscar:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext":     "Seguinte",
                    "sLast":     "Último"
                }
            },
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
                            "sButtonText": "Usuário",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0][aaData[0].length-1];
                                 ajaxLoadDialog(Routing.generate(routeUsuario, {"id" : id}));
                                 
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


