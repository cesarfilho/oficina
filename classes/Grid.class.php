<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grid
 *
 * @author CesarFilho
 */
class Grid {

    //put your code here

    public function __construct() {
        //definir caracterisiticas iniciais do grid nome, id, style, etc...;
    }

    public function getGrid($tabela,$dados, $aTituloCampos,$campos) {

        $grid = " 
        <div>
            <form class='form-search'>
                <input type='text' class='input-medium search-query' id='sBusca'>
                <button type='button' class='btn' id='btBusca'>Busca</button>
                <button type='button' class='btn btn-primary' id='addCadastro'>Novo</button> 
                <input type='hidden' name='".$tabela."' id='gridTabela'>
            </form>
        </div>  
            
        <table class='table table-striped'>
          <caption>Lista de Clientes</caption>
          <thead>
            <tr>
                ".$this->TituloColunas($aTituloCampos)."
                <th>Opções</th>
            </tr>
          </thead>
          <tbody>
                ".$this->DadosColunas($tabela,$dados,$campos)."
          </tbody>
        </table> ";
        $grid .='<script src="cad_'.$tabela.'.js"></script>';
        return $grid;

    }

    public function TituloColunas($aTituloCampos){
        $sCampos = null;
        foreach ($aTituloCampos as $ll => $pp) {
            $sCampos.="<th>". utf8_encode($pp). "</th>";            
        }
        return $sCampos;

    }
    public function DadosColunas($tabela,$dados,$campos){
        $sDados = null;
        foreach ($dados as $kk) {
            $sDados .="<tr>";
            foreach ($kk as $ll => $pp) {
                if (in_array($ll, $campos)) {
                    if ($ll == 'id') {
                        $id = $pp;
                    }
                    $sDados.="<td>".$pp."</td>";
                }
            }
            if (isset($id) && $id != '') {
                $sDados .= '<td><button type="button" class="btn btn-info" id ="btEditar" name ="ed_cad_'.$tabela.'_'.$id.'">Editar</button></td>';                
            }
            $sDados .="</tr>";
        } 
        return $sDados;
    }

    public function GetCadTabela($tabela){
        $NomeArquivo = explode('_',$tabela);
        return $NomeArquivo[1];
    }

}

?>
