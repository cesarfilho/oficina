<script>
$(document).ready(function() {
    // validate the comment form when it is submitted
    $("#cad_mod_cliente").validate({
        debug :true,
        rules:{
            nome:{
                required: true,
                minlength: 10,
                maxlength: 256
            },
            uf:{required:true,
                minlength:2,
                maxlength:2   
            }
        },
        messages:{
            nome:{
                required: "Nome completo obrigatório",
                minlength: "Tamanho mínimo é de 11 digitos.",
                maxlength: "Tamanho máximo é de 256 digitos."
            },
            uf:{
                required: "UF é obrigatório",
                minlength: "Tamanho mínimo é de 2 digitos.",
                maxlength: "Tamanho máximo é de 2 digitos."                
            }
        },
        
        highlight: function(element) {
          $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function(element) {
          element
          .text('OK!').addClass('valid')
          .closest('.control-group').removeClass('error').addClass('success');
        }
        
    });

   
});

function getInfo(obj){
var name = obj.name;
var id = name.split('_');
alert(name);
/*
//mostra o cadastro
    $.ajax({
     url: 'envia_html',
     data: "tipocad="+id[3],
     success: function(data){
        $('#div_add').html(data);
     }
    });
*/

//preenche os dados
    $.ajax({
     type: "GET",
     data: { get_param: 'value' },
     dataType: "json",
     url: 'editar_registro',
     data: "ID="+id[4]+"&tipocad="+id[3],
     success: function(data){

        $('#nome').attr('value' ,data.nome);
        $('#cpf').mask("?999.999.999-99",{placeholder:" "}).val(data.cpf);
        $('#nascimento').mask("?99/99/9999",{placeholder:" "}).val(data.nascimento);
        $('#cep').mask("?99999-999",{placeholder:" "}).val(data.cep);
        $('#telefonecelular').mask("?(99) 9999-9999",{placeholder:" "}).val(data.telefonecelular);
        $('#endereco').attr('value' ,data.endereco);
        $('#complemento').attr('value' ,data.complemento);
        $('#cidade').attr('value' ,data.cidade);
        $('#bairro').attr('value' ,data.bairro);
        $('#uf').attr('value' ,data.uf);
        $('#pais').attr('value' ,data.pais);
        $('#email').attr('value' ,data.email);
        $('#id_cliente_inc').show();        
        $('#id_cliente').attr('value' ,data.id);
        $('#acao').attr('value' ,'editar');

        $("#div_pre_add").show();
        $('#nome').focus();
     }
   });
}

function RemoveMask(){
  $('#cpf').unmask("?999.999.999-99");
  $('#nascimento').unmask("?99/99/9999");
  $('#cep').unmask("?99999-999");
  $('#telefonecelular').unmask("?(99) 9999-9999");    
        
}

function InsereMask(){
  $("#cpf").mask("?999.999.999-99",{placeholder:' '});
  $("#nascimento").mask("?99/99/9999",{placeholder:' '});
  $("#cep").mask("?99999-999",{placeholder:' '});
  $("#telefonecelular").mask("?(99) 9999-9999",{placeholder:' '});    
}

function cleanInfo(){


  //campos sem mascara  
  $('#nome').attr('value' ,'');
  $('#endereco').attr('value' ,'');
  $('#complemento').attr('value' ,'');
  $('#cidade').attr('value' ,'');
  $('#bairro').attr('value' ,'');
  $('#uf').attr('value' ,'');
  $('#pais').attr('value' ,'');
  $('#email').attr('value' ,'');
  $('#id_cliente').attr('value' ,'');
  //campos com mascara

  $('#cpf').attr('value' ,'');
  $('#nascimento').attr('value' ,'');
  $('#cep').attr('value' ,'');
  $('#telefonecelular').attr('value' ,'');

  $('#cpf').val('');
  $('#nascimento').val('');
  $('#cep').val('');
  $('#telefonecelular').val('');

}

function cleanInfo2(){

  $('#nome').val('');
  $('#endereco').val('');
  $('#complemento').val('');
  $('#cidade').val('');
  $('#bairro').val('');
  $('#uf').val('');
  $('#pais').val('');
  $('#email').val('');  
}

function SalvaDados(){

    $.ajax({

        type: "POST",
        data: $('#cad_mod_cliente').serialize(),
        url: "valida_pessoas.php",
        dataType: "html",
        success: function(result){
        },
        beforeSend: function(){
        },
        complete: function(msg){
            carrega('A');
            $('#cad_mod_cliente')[0].reset();
            cleanInfo();
            $('#div_add').hide();
        }
    });
}  

$.validator.setDefaults({
    submitHandler: function() { SalvaDados(); }
});

</script>