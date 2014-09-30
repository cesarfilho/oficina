<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$modulo = 1 ;

require_once "../controle.php";


$action = $_GET['acao'];
if (isset($_GET['ID'])) $ID = $_GET['ID'];
$filtro = array();
$campos= array('id','marca','modelo','cpf','ano','cor','placa','km');    
$veiculo = new Veiculo();
switch ($action) {
    case "getVeiculos":

        $grid = new grid();

        if (!empty($_GET['busca']))
        { 
            foreach ($campos as $key => $value) {
                $filtro[$value] = $_GET['busca'];
            }
            $filtro['tipo'] = 'or';        
        }else{
            $filtro = null;            
        }
        $aListaCampos = $veiculo->GetDefCampos(tb_veiculo, $campos);

        $saida = $grid->getGrid(tb_veiculo,$veiculo->getVeiculos(null,$filtro),$aListaCampos,$campos);

        echo $saida;

    break;

    case "getVeiculo":
              
        $saida = $grid->getGrid($veiculo->getVeiculo(),$campos);
        
        echo utf8_encode($saida);
        
    break;    

    default:
        break;
}

exit();
?>
