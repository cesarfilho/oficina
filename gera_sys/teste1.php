<?php
include '../classes/Mysql.class.php';
 
$mysql  = new MySQL;

$tabela = 'mod_cliente';
 
$info_campos = $mysql->GetInfoFieldsTable($tabela);
$monta_info_campos = null;
$temp =array();

function ExtrairTamanhoCampo($TextoTamanho){
    $tam1 = strpos($TextoTamanho, '(');
    $tmp1 = substr_replace($TextoTamanho, '', 0,$tam1+1);
    $tam2 = strpos($tmp1, ')');    
    $saida = substr_replace($tmp1, '', $tam2);    
    return $saida;    
}

function ExtrairTipoCampo($TextoTipo){

    $tam1 = strpos($TextoTipo, '(');
    if ($tam1 <> false){
        $TextoTipo = substr_replace($TextoTipo, '', $tam1);    
    }
    
    if ($TextoTipo == 'varchar'){
        return 'varchar';
    }elseif ($TextoTipo == 'char'){
        return 'char';
    }elseif ($TextoTipo == 'int'){
        return 'int';        
    }else{
        return $TextoTipo;        
    }     
}

function TipoCaracterCampo($TipoCampo){
    $texto = array('varchar','char');
    $numero = array('int','decimal');
    $data = array('timestamp','date','datatime'); 
    
    if (in_array($TipoCampo,$texto)){
        return 'carater(es)';
    }elseif (in_array($TipoCampo,$numero)){
        return 'digitos(s)';        
    }elseif (in_array($TipoCampo,$numero)){
        return 'data(s)';                
    }
    
}

function MontarJSCampos($form,$rules,$messages){
  //rules
  $v1 = false;
  $js_rules ='rules:{';    
  foreach ($rules as $key => $value) {
    if ($v1 == false){
        $v1 = true;        
        $js_rules .= '';
    }else{
        $js_rules .= ',';        
    }

    $js_rules .="$key:{"; 
    $v2 = false;      
    foreach ($value as $key1 => $value1) {
        if ($v2 == false){
            $v2 = true;
            $js_rules .= '';
        }else{
            $js_rules .= ',';        
        }
        
        $js_rules .="$key1 : $value1"; 
    }
    $js_rules .='}';     
  }
  $js_rules .='}';   
  

  //messages
  $v1 = false;
  $js_messages ='messages:{';    
  foreach ($messages as $key => $value) {
    if ($v1 == false){
        $v1 = true;        
        $js_messages .= '';
    }else{
        $js_messages .= ',';        
    }

    $js_messages .="$key:{"; 
    $v2 = false;      
    foreach ($value as $key1 => $value1) {
        if ($v2 == false){
            $v2 = true;
            $js_messages .= '';
        }else{
            $js_messages .= ',';        
        }
        
        $js_messages .="$key1 : $value1"; 
    }
    $js_messages .='}';     
  }
  $js_messages .='}';  
  
  $saida ='$().ready(function() {';
  $saida .= '$("#'.$form.'").validate({'. $js_rules.','.$js_messages.'})';
  $saida .= '});';     
  
  return $saida;
}

function MontarJSPagina(){
    return include 'gera_html.js';    
}

function CamposDBTable($info_campos,$monta_info_campos){
    global $mysql;
    global $tabela;
    foreach ($info_campos as $key => $value) {

        foreach ($value as $key2 => $value2) {
            if ($key2 == 'Field') {
                if (is_null($monta_info_campos) || (!array_key_exists($value2, $monta_info_campos))) {
                    $campo = $value2;
                }
            }
            $temp[$key2] = utf8_encode($value2);
        }
        $campos[] = $campo;
        $test = $mysql->GetDefCampos($tabela, $campos);
        $temp['Descricao'] = $test[$campo];
        $monta_info_campos[$campo] = $temp;
    }
    return $monta_info_campos;
}

function CamposToHtml($monta_info_campos){
    $html = '';
    foreach ($monta_info_campos as $key => $value) {
        $descricao = (empty($value['Descricao']) ) ? 'Descrição' : $value['Descricao'];
// html fileds    
        $html .="<div class='control-group'>";
        $html .="<label class='control-label' for='$descricao'>$descricao</label>";
        $html .="<div class='controls'>"; 
        $html .="<input type='text' placeholder='' id ='".$key."' name ='".$key."' class='input-xlarge'>";
        $html .="</div>";
        $html .="</div>";
    }
    return $html;
}

function CamposValores($monta_info_campos){
     foreach ($monta_info_campos as $key => $value) {

//verifica se o campo é requerido    
        if ($value['Null'] == "NO" || $value['Key'] <> '') {
            $rules[$value['Field']]['require'] = true;
        }
//tipo campo    
        $rules[$value['Field']]['type'] = ExtrairTipoCampo($value['Type']);
//tamanho campo
        $rules[$value['Field']]['maxlenght'] = ExtrairTamanhoCampo($value['Type']);
//mensagem
        if ($rules[$value['Field']]['maxlenght'] > 0) {
            $messages[$value['Field']]['maxlenght'] = 'O tamanho máximo para o campo ' . $value['Field'] . ' é de ' . $rules[$value['Field']]['maxlenght'] . ' ' . TipoCaracterCampo($rules[$value['Field']]['type']);
        }
    }
    $saida ['rules'] = $rules;
    $saida ['messages'] = $messages;
    return $saida;
   
}

function CamposToListBox($monta_info_campos){
    $html = '<select size=6 id="campostabela">';
    foreach ($monta_info_campos as $key => $value) {
        $html .="<option   value= '".$key."'>".$value['Descricao']."</option>";
    }
    $html .= '</select>';  
    return $html;
}

function PaginaMontaForm($info_campos,$monta_info_campos){

$posDB = CamposDBTable($info_campos,$monta_info_campos); 
$js = MontarJSPagina();    

$html ="<meta charset='utf-8'>" ; 
$html .="<html>";
$html .= "<head>";
$html .= "<script>";
$html .= $js;
$html .= "</script>";
$html .= "</head>";
$html .="<body>";
$html .="<table>";
$html .='<tr><td>'. CamposToListBox($posDB).'</td></tr>';
$html .="</table>";
$html .="</body>";
$html .="<html>";  

return $html;
}

function GeraPaginaHTML($info_campos,$monta_info_campos){
    global $tabela;
    
$posDB = CamposDBTable($info_campos,$monta_info_campos); 
$camposForm = CamposToHtml($posDB);
$outro = CamposValores($posDB);
$js = MontarJSCampos('dados', $outro['rules'], $outro['messages']);    
    
$html ="<meta charset='utf-8'>" ; 
$html .="<html>";
$html .= "<head>";
$html .= "<script>";
$html .= $js;
$html .= "</script>";
$html .= "</head>";
$html .="<body>";
$html .="<form id='cad_".$tabela."' name='cad_".$tabela."' action='' method='' class='form-horizontal'><fieldset>";
$html .= $camposForm;
$html .="</fieldset></form>";
//$html .="<div></div>";
$html .="</body>";
$html .="<html>";
 
return $html;
}

//$saida = '<?php ';
$saida = GeraPaginaHTML($info_campos,$monta_info_campos);
//$saida = PaginaMontaForm($info_campos,$monta_info_campos);
//$saida .= '?/>';

//echo utf8_encode($saida);

//exit();

$fp = fopen('cad_'.$tabela.'.php', 'w+');
fwrite($fp, $saida);
fclose($fp);
header('Location: cad_'.$tabela.'.php');
exit();

?>


