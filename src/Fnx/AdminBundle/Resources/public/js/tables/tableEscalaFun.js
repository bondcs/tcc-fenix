$(document).ready(function() {
    onTableAjaxEscalaFun()
})

function onTableAjaxEscalaFun(){
        
        oTableEscalaFun = $('.tableEscalaFun').dataTable({
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
            "sAjaxSource": Routing.generate("escalaFunAjax"),
            "aoColumns": [
                { "mDataProp": "funcionario.nome" },
//                { "mDataProp": "escalaN",
//                    "sClass": "center"},
                { "mDataProp": "descricao"},
                { "mDataProp": "escalaEx",
                    "sClass": "pointer center"},
                { "mDataProp": "id" },
                    
             ],
            "aoColumnDefs": [{"bVisible": false, "aTargets": [3]}],
            "bAutoWidth": false,
    //           "fnDrawCallback": function ( oSettings ) {
    //            if ( oSettings.aiDisplay.length == 0 )
    //            {
    //                return;
    //            }
    //             
    //            var nTrs = $('.tableEscalaFun tbody tr');
    //            var iColspan = nTrs[0].getElementsByTagName('td').length;
    //            var sLastGroup = "";
    //            for ( var i=0 ; i<nTrs.length ; i++ )
    //            {
    //                var iDisplayIndex = oSettings._iDisplayStart + i;
    //                var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData['funcionario']['nome'];
    //                if ( sGroup != sLastGroup )
    //                {
    //                    var nGroup = document.createElement( 'tr' );
    //                    var nCell = document.createElement( 'td' );
    //                    nCell.colSpan = iColspan;
    //                    nCell.className = "group";
    //                    nCell.innerHTML = sGroup;
    //                    nGroup.appendChild( nCell );
    //                    nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
    //                    sLastGroup = sGroup;
    //                }
    //            }
    //            },
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
                            "sPdfMessage": "Escalas Adicionais"
                        },
                        {
                            "sExtends": "text",
                            "sButtonText": "Adicionar",
                            "fnClick" : function(){
                                 ajaxLoadDialog(Routing.generate("escalaFunAdd"));
                            }
                        }, 
                        {
                            "sExtends": "select_single",
                            "sButtonText": "Editar",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0]["id"];
                                 ajaxLoadDialog(Routing.generate("escalaFunEdit", {"id" : id}));
                                 
                            }
                        },
                         {
                            "sExtends": "select_single",
                            "sButtonText": "Deletar",
                            "sButtonClass": "hidden",
                            "fnClick" : function(){
                                 var aaData = this.fnGetSelectedData()
                                 id = aaData[0]["id"];
                                 $( "#dialog-confirm" ).dialog("open");
                                 $( "#dialog-confirm" ).dialog("option", "buttons", {
                                     "Deletar": function() {
                                            ajaxDelete(Routing.generate("escalaFunRemove", {"id" : id})); 
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
        
         $("div.toolbar02").html('<b>Escalas Adicionais</b>');
        
}