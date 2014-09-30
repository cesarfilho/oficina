<?
require_once "../controle.php";


function remove_mascara($campo,$valor){
    $utils = new Util;
    $procura = array('cpf','telefonecelular','cep');
    if (in_array($campo,$procura)){
        return $utils->mascara($campo, $valor,'remover');        
    }elseif($campo == 'nascimento'){
        return $utils->FormataDataToDb($valor);
    }else{
        return $valor;
    }
}

$post = $_POST;

$id_cliente = $post['id_cliente'];
$acao = $post['acao'];
//remove campos que não fazem parte da tabela.
unset($post['submit']);
unset($post['acao']);
unset($post['id_cliente']);

switch ($acao) {
    case 'inserir':
            $sql = ' ';
            $cps = null;    
            $fld = null;                
            foreach ($post as $campo=>$valor){
                $cps .= " $campo ,";
                $fld .= " '".remove_mascara($campo,$valor)."' ,";                
            }
            $cps = substr_replace($cps ,"",-1); 
            $fld = substr_replace($fld ,"",-1); 
            $sql .= 'insert into '.tb_cliente." ($cps) values ($fld)";
        break;
    case 'editar':
            $sql = 'update '.tb_cliente.' set ';
            foreach ($post as $campo=>$valor){
                $sql .= " $campo = '".remove_mascara($campo,$valor)."',";
            }
            $sql = substr_replace($sql ,"",-1);
            $sql .= ' where id = '.$id_cliente;
        break;
    
    default:
        
        break;
}

if (!empty($sql)){
    $cliente = new Cliente();
    echo $sql;
    $cliente->executa_sql($sql);
}else{
    echo 'Nenhuma operaçao foi executada!';
}


exit();

?>