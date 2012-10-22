$(document).ready(function() {
    onTableAjaxSalario();
//    filtrarSalarios();
  
})

function onTableAjaxSalario(){
        
        oTableSalario = $('.tableSalario').dataTable({
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
            "sAjaxSource": Routing.generate("escalaSalario"),
            "aoColumns": [
                { "mDataProp": null},
                { "mDataProp": "nome" },
                { "mDataProp": "salario"},
                { "mDataProp": "salarioPago"},
                { "mDataProp": "dataPagamento",
                    "sClass" : "center"},
                { "mDataProp": "id" },
                    
             ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                 $('td:eq(0)', nRow).html('<input type="checkbox" name="fun[]" value="'+aData['id']+'">');
                 $('td:eq(2)', nRow).html(formataDinheiro(aData['salario']+""));
                 $('td:eq(3)', nRow).html(formataDinheiro(aData['salarioPago']+""));
                 
            },
            "aoColumnDefs": [{"bVisible": false, "aTargets": [5]},
                              {"bSortable": false, "aTargets": [0]}],
            "bAutoWidth": false,
            "sDom": '<"H"Tfr<"toolbar02">>t<"F"ip>',
            "oTableTools": {
                    "sRowSelect": "single",
                    "sSwfPath": "/"+url_dominio+"/web/bundles/fnxadmin/table/tools/swf/copy_csv_xls_pdf.swf",
                    "sSelectedClass": "row_selected",
                    "aButtons": [
                        "copy",
                        "print",
                        {
                            "sExtends": "pdf",
                            "mColumns": "visible",
                            "sPdfOrientation": "landscape",
                            "sPdfMessage": "Escalas"
                        }, 
                        {
                            "sExtends": "select_single",
                            "sButtonText": "Editar",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0]["id"];
                                 ajaxLoadDialog(Routing.generate("funcionarioSalarioEdit", {"id" : id}));
                                 
                            }
                        }
                    ]
                }
        });
        
         $("div.toolbar02").html('<b>Salários</b>');
        
}

//function filtrarSalarios(){
//    
//    $('#filtrarEscala').click(function(){
//        
//        oTableSalario.fnNewAjax(Routing.generate("escalaSalario", {
//                                                'inicio' : $(".inicio").val(),
//                                                'fim' : $(".fim").val()
//                        }));
//                            
//        oTableSalario.dataTable().fnReloadAjax();
//
//        return false;
//    })
//    
//    
//}

$(".tableSalario tbody td.check").live("click", function(){
    
            var data = oTableSalario.fnGetData(this.parentNode);
            var url = Routing.generate("escalaFunCheck", {"id" : data['id']})
            $.ajax({
                type: 'POST',
                url: url,
                success: function(){
                    $('.redraw').dataTable().fnReloadAjax();
                    onReadyAjax();  
                    return false;
                }
            })
})