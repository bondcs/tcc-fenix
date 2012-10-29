$(document).ready(function() {
    onTableAjaxServicoAdmin();
    filtrarServicos();
  
})

function onTableAjaxServicoAdmin(){
        
        oTableServicoAdmin = $('.tableServicoAdmin').dataTable({
            "bJQueryUI": true,
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
            "sPaginationType": "full_numbers",
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "bRetrieve": true,
            "bProcessing": true,
            "sAjaxSource": Routing.generate("ajaxServicoAdmin", {"id" : $(".tableServicoAdmin").attr("atividade")}),
            "aoColumns": [
                { "mDataProp": null},
                { "mDataProp": "nome" },
                { "mDataProp": "valor"},
                { "mDataProp": "fornecedor.nome"},
                { "mDataProp": "id" },
                    
             ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
//                 if (aData['salario']['pagamento']['pago']){
//                      $('td:eq(0)', nRow).html('<input disabled="disabled" type="checkbox" name="pagamentos[]" value="'+aData['salario']['pagamento']['id']+'">');
//                      $(nRow).addClass('riscado');
//                 }else{
//                      $('td:eq(0)', nRow).html('<input type="checkbox" name="pagamentos[]" value="'+aData['salario']['pagamento']['id']+'">');
//                 }
//                 $('td:eq(2)', nRow).html(formataDinheiro(aData['salario']['salario']+""));
//                 $('td:eq(3)', nRow).html(formataDinheiro(aData['salario']['pagamento']['bonus']+""));
//                 $('td:eq(4)', nRow).html(aData['dependentes']+" x "+formataDinheiro(aData['valorDependente']+""));
//                 $('td:eq(6)', nRow).html(formataDinheiro(aData['dependentes']*aData['valorDependente']+aData['salario']['salario']+aData['salario']['pagamento']['bonus']+""));
//                 
            },
            "aoColumnDefs": [{"bVisible": false, "aTargets": [3]}],
            "bAutoWidth": false,
            "sDom": '<"H"Tfr>t<"F"ip>',
            "oTableTools": {
                    "sRowSelect": "single",
                    "sSelectedClass": "row_selected",
                    "aButtons": [
                        {
                            "sExtends": "text",
                            "sButtonText": "Adicionar",
                            "fnClick" : function(){
                                if (clickTableTerminate()){
                                   //ajaxLoadDialog(urlAdd);
                                }
                            }
                        },
                        
                        {
                            "sExtends": "select_single",
                            "sButtonText": "Editar",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                               if (clickTableTerminate()){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0]["id"];
                                // ajaxLoadDialog(Routing.generate(routeEdit, {"id" : id}));
                               }
                                 
                            }
                        },
                        
                        {
                            "sExtends": "select_single",
                            "sButtonText": "Deletar",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                                if (clickTableTerminate()){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0]["id"];
                                 $( "#dialog-confirm" ).dialog("open");
                                 $( "#dialog-confirm" ).dialog("option", "buttons", {
                                     "Deletar": function() {
                                           // ajaxDelete(Routing.generate(routeDelete, {"id" : id})); 
                                            $(this).dialog("close");
                                     },
                                     "Cancelar": function(){
                                            $(this).dialog("close");
                                     }
                                 } );
                                 return false;
                                }
                                 
                            }
                        }
                        
                    ]
                }
        });
    
}

function filtrarServicos(){
    
    $('.mes, .ano').change(function(){
        
       // oTableServicoAdmin.fnNewAjax(Routing.generate("escalaSalario", {'mes' : $(".mes").val(),'ano' : $(".ano").val()}));                   
        oTableServicoAdmin.dataTable().fnReloadAjax();
        return false;
    })
    
    
}
//
//$(".tableSalario tbody td.check").live("click", function(){
//    
//            var data = oTableSalario.fnGetData(this.parentNode);
//            var url = Routing.generate("escalaFunCheck", {"id" : data['id']})
//            $.ajax({
//                type: 'POST',
//                url: url,
//                success: function(){
//                    $('.redraw').dataTable().fnReloadAjax();
//                    onReadyAjax();  
//                    return false;
//                }
//            })
//})


