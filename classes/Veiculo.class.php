<?php

/**
 * Description of Cliente
 *
 * @author CesarFilho
 */
class Veiculo extends MySQL {

    //put your code here

    public function __construct() {
        
    }
        
    public function  getCamposTabelaFormatado(){
        $aCTabela = $this->GetInfoFieldsTable(tb_veiculo);        
        $sCampos = null;
        foreach ($aCTabela as $key => $value) {
            $sNomeCampo = $value['Field'];
            if ($value['Type'] == 'timestamp' ){
              $sDataFormatada =  "date_format($sNomeCampo,'%d/%m/%Y') as $sNomeCampo"; 
              $sCampos .= ($sCampos ==null)?$sDataFormatada:",$sDataFormatada";                    
            }else{   
              $sCampos .= ($sCampos ==null)?$sNomeCampo:",$sNomeCampo";  
            }
        }
        return $sCampos;
    }

    public function getVeiculo($id = null, $campos = array()) {
        if (empty($id)) {
            return erro_id;
        }
        
        if ($campos == null) {
            $lista_campos = $this->getCamposTabelaFormatado();
            $sql = "select $lista_campos from " . tb_veiculo . " where id = $id";
            return $this->fetch($sql);
        } else {
            $lista_campos = '';
            foreach ($campos as $key => $val) {
                $lista_campos .="$val";
            }
            $query = $this->fetch("select $lista_campos from " . tb_veiculo . " where id = $id");
            return $query;
        }
    }

    public function getVeiculoMascara($id = null, $campos = array()) {
        $mask = new Util;
        if (empty($id)) {
            return erro_id;
        }
        $temp = $this->getVeiculo($id);
        $saida = array();
        foreach ($temp[0] as $key => $value) {
            $saida[$key] = $mask->mascara($key, $value);
        }
        return $saida;
    }

    public function getVeiculos($campos = array(), $filtro = array()) {
        if (empty($campos)) {
            $lista_campos = '*';
        } else {
            $lista_campos = '';
            foreach ($campos as $key => $val) {
                $lista_campos .="$val";
            }
        }
        $filtros = null;
        if (!empty($filtro)) {
            if (!empty($filtro['tipo'])){
                $tipo = $filtro['tipo'];
                unset($filtro['tipo']);                
            }else{
                $tipo = 'and';
            }
            $filtros .=" where ";
            foreach ($filtro as $k => $v) {
                if (trim($filtros) !='where'){$filtros.=$tipo;}
                $filtros .= " ( $k like '%$v%' ) ";
            }
        }
        $sql = "select $lista_campos from " . tb_veiculo . " $filtros";
        $query = $this->fetch($sql);
        return $query;
    }

    public function fields_tb_clientes() {

        return $this->FieldsTable(tb_veiculo);
    }

}

?>
