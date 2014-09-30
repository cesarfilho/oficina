        <script>

            function carrega(tmp,busca) {
                if (tmp == 'CadCli') {
                    var pagina = 'lista_pessoas.php';
                    var acao = 'getClientes';
                }
                else if (tmp == 'CadVec') {
                    var pagina = 'lista_veiculos.php';
                    var acao = 'getVeiculos';
                }

                else if (tmp == 'CadOrc') {
                    var pagina = 'lista_orcamentos.php';
                    var acao = 'getOrcamentos';                    
                }

                else if (tmp == 'CadNot') {
                    var pagina = 'lista_notasficais.php';
                }

                else if (tmp == 'I') {
                    var pagina = 'start.php';
                    window.location = pagina;                                                            
                }

                else {
                    alert("Página não encontrada!");
                }
                Grid(tmp,pagina,acao,busca);
            }

            function Grid(tmp,pagina,acao,busca){
                $.ajax({
                    type: "GET",
                    url: pagina,
                    data: "acao=" + acao +"&busca="+busca,
                    success: function(data) {
                        $('#'+tmp+'Div').html(data);
                    }
                });                
            }

            function MostraCadTabela(tabela){
                tabela = tabela.split('_');
                window.location = href+'?cadastro=cad_'+tabela[1];
            }

            $(document).ready(function() {
                $("a").click(function(e) {
                    e.preventDefault();                                            
                    var tmp = $(this).attr("id");
                    if (tmp.search('Cad') >= 0){
                        carrega(tmp,'');
                    }else{
                        location.href = $(this).attr("href");
                    }
                });

                $("body").on('click','#close_cad',function() {
                    $("#div_pre_add").hide();
                }); 

                $("body").on('click','#addCadastro',function() {
                    var url = 'cad_' + $("#gridTabela").attr('name') + '.php';
                    window.location = url;
                }); 
                //campo busca no grid
                $("body").on("click","#btBusca", function(){
                  if ($("#gridTabela").attr('name') == 'mod_cliente'){
                    var acao = 'getClientes';
                    var div = 'CadCliDiv';
                    var arq = 'lista_pessoas.php';
                  }else if($("#gridTabela").attr('name') == 'mod_veiculo'){
                    var acao = 'getClientes';
                    var div = 'CadVecDiv';        
                    var arq = 'lista_veiculos.php';
                  }else if($("#gridTabela").attr('name') == 'mod_orcamento'){
                    var acao = 'getClientes';
                    var div = 'CadOrcDiv';
                    var arq = 'lista_orcamentos.php';                    
                  }else if($("#gridTabela").attr('name') == 'mod_notafiscal'){
                    var acao = 'getClientes';
                    var div = 'CadNotDiv';
                    var arq = 'lista_notafiscal.php';                                        
                  }

                  $.ajax({
                      type: "GET",
                      url: arq,
                      data: "acao="+acao+"&busca="+$('#sBusca').val(),
                      success: function(data) {
                          $("#"+div).html(data);
                      }
                  });                
                });

                $("body").on("click","#btEditar", function(){
                    var item = this.name;
                    //id = id.split('_');
                    var url = 'cad_' + $("#gridTabela").attr('name') + '.php?item='+item;
                    window.location = url;
                }); 


            });
                    


        </script>    
