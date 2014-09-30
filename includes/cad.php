<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
?>
    <div class='pre_pop' id="div_pre_add" style="display:none;">
        <span align="right" id="close_cad" style="cursor:pointer;" class="badge badge-important"><strong>[X] FECHAR</strong></span>    
        <legend id="titulocadastro" align='center'>#</legend>
        <div class='pop' id="div_add" >
                //forms com os cadatrso
        </div>
    </div>
    <!-- Máscara para cobrir a tela -->
      <div id="mask"></div>
    </body>
</html>
