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
    
switch ($action) {
    case "getClientes":

        $grid = new grid();

        $cliente = new Cliente();

        $campos= array('id','nome','telefonecelular','cpf','endereco','cidade','uf','email');
        if (!empty($_GET['busca']))
        { 
            foreach ($campos as $key => $value) {
                $filtro[$value] = $_GET['busca'];
            }
            $filtro['tipo'] = 'or';        
        }else{
            $filtro = null;            
        }
        $aListaCampos = $cliente->GetDefCampos(tb_cliente, $campos);
        $saida = $grid->getGrid(tb_cliente,$cliente->getClientes(null,$filtro),$aListaCampos,$campos);
        echo $saida;

    break;

    case "getCliente":
        
        $cliente = new Cliente();
        
        $campos= array('id','nome','telefonecelular','cpf','endereco','cidade','uf','email');

        $saida = $grid->getGrid($cliente->getCliente(),$campos);
        
        echo utf8_encode($saida);
        
    break;    

    default:
        break;
}


?>