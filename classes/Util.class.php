<?php

/**
 * Description of Cliente
 *
 * @author CesarFilho
 */
class Util {

    //put your code here

    public function __construct() {
        
    }

    public function formata_POST($post) {

        if (is_array($post)) {
            foreach ($post as $var) {
                if (is_array($var)) {
                    
                } elseif (is_bool($var)) {
                    
                } elseif (is_float($var)) {
                    
                } elseif (is_int($var)) {
                    
                } elseif (is_numeric($var)) {
                    
                } elseif (is_string($var)) {
                    
                }
            }
        }
    }

    public function mascara($tipo, $valor, $acao=null) {

        if ($acao == 'remover') {
            $saida = preg_replace("/[^0-9]/", "", $valor);
            if ($saida == ''){
                return $valor;
            }else{
                return $saida;
            }
            
        } else {
            if ($tipo == 'cep') {
                return $this->mask($valor, "99999-999");
            } elseif ($tipo == 'telefonecelular') {
                return $this->mask($valor, "(99) 9999-9999");
            } elseif ($tipo == 'cpf') {
                return $this->mask($valor, "999.999.999-99");
            } else {
                return $valor;
            }
        }
    }
    
    public function FormataDataToDb($data){
        $saida = explode('/',$data);
        $saida = "$saida[2]-$saida[1]-$saida[0]";
        return $saida;
    }

    public function mask($expr, $mask) {
        $ret = "";
        $j = 0;
        $i = 0;
        $expr = (string) $expr;
        while ($i < strlen($expr)) {
            if (($mask[$j] != "9") and ($mask[$j] != "X")) {
                $ret.=$mask[$j];
                $j++;
            }else{
                $ret.=$expr[$i];
                $j++;
                $i++;                
            }
        }
        return $ret;
    }
}

?>
