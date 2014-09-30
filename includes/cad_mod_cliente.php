<?
require_once "../controle.php";
$modulo = 1;
?>

<!DOCTYPE html>
<html>
    <head>
    <?
    require_once ('cabecalho.php');
    require_once ('cad.js');    
    require_once ('cad_mod_cliente.js');        
    ?>
    </head>
    <body>
<?
require_once ('menu.php');
require_once ('barra_cad.php');
  

if (isset($_GET['item'])){
  $item = $_GET['item'];
  $id_cliente = explode('_', $item);
  $id_cliente = $id_cliente[4];
  $acao = 'editar';
} 
else{
  $acao = 'inserir';  
}

?>
<form id='cad_mod_cliente' name='cad_mod_cliente' action='' method='' class="form-horizontal">    
    <fieldset>
        <div class="control-group">
          <input type='hidden' id='acao' name='acao' value='acao' value = '<?if (!empty($acao)){echo $acao;}?>'>
          <div id ="id_cliente_inc">
            <label class="control-label" for="id_cliente">ID</label>
            <div class="controls">
                <input type="text" placeholder="" id ='id_cliente' name ='id_cliente' value ="<?if (!empty($id_cliente)){echo $id_cliente;}?>" readonly="readonly" class="input-xlarge">
            </div>
          </div>
        </div>        
        <div class="control-group">
          <!-- Text input-->
          <label class="control-label" for="nome">Nome Completo</label>
          <div class="controls">
            <input type="text" placeholder="" id ='nome' name ='nome' class="input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <!-- Text input-->
          <label class="control-label" for="cpf">CPF</label>
          <div class="controls">
            <input type="text" placeholder="" id ='cpf' name ='cpf' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="nascimento">Data Nascimento</label>
          <div class="controls">
            <input type="text" placeholder="" id ='nascimento' name ='nascimento' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="cep">CEP</label>
          <div class="controls">
            <input type="text" placeholder="" id ='cep' name ='cep' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="telefonecelular">Telefone Celular</label>
          <div class="controls">
            <input type="text" placeholder="" id ='telefonecelular' name ='telefonecelular' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="endereco">Endereço</label>
          <div class="controls">
            <input type="text" placeholder="" id ='endereco' name ='endereco' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="complemento">Complemento</label>
          <div class="controls">
            <input type="text" placeholder="" id ='complemento' name ='complemento' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="cidade">Cidade</label>
          <div class="controls">
            <input type="text" placeholder="" id ='cidade' name ='cidade' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="bairro">Bairro</label>
          <div class="controls">
            <input type="text" placeholder="" id ='bairro' name ='bairro' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="uf">UF</label>
          <div class="controls">
            <input type="text" placeholder="" id ='uf' name ='uf' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="pais">País</label>
          <div class="controls">
            <input type="text" placeholder="" id ='pais' name ='pais' class="input-xlarge">
          </div>
        </div><div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="email">Email</label>
          <div class="controls">
            <input type="text" placeholder="" id ='email' name ='email' class="input-xlarge">
          </div>
        </div><div class="control-group">
          <label class="control-label"></label>
          <!-- Button -->
          <div class="controls" >
            <button type='submit' id='submit' name='submit' class="btn btn-danger">Salvar</button>
          </div>
        </div>
    </fieldset>
  </form>
  <script>
    $(document).ready(function() {
      getInfo(<?echo $item;?>);
    }
  </script>
