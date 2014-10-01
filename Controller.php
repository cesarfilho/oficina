<?php
function __autoload($className)
{
    include_once("models/$className.php");
}

$clientes = new Cliente("localhost", "root", "", "ipamp_sys");
$veiculos = new Veiculo("localhost", "root", "", "ipamp_sys");
$orcamentos = new Orcamento("localhost", "root", "", "ipamp_sys");

if (!isset($_POST['action']) && !isset($_GET['action'])) {
    print json_encode(0);
    return;
}
$acao = $_REQUEST['action'];

switch ($acao) {

////////////////////// Cliente //////////////////////////
    case 'get_clientes':
        print $clientes->getClientes();
        break;

    case 'get_cliente':
        $cliente = new stdClass;
        $cliente = json_decode($_POST['cliente']);
        print $clientes->getCliente($cliente);
        break;

    case 'add_cliente':
        $cliente = new stdClass;
        $cliente = json_decode($_POST['cliente']);
        print $clientes->add($cliente);
        break;

    case 'delete_cliente':
        $cliente = new stdClass;
        $cliente = json_decode($_POST['cliente']);
        print $clientes->delete($cliente);
        break;

    case 'update_cliente_data':
        $cliente = new stdClass;
        $cliente = json_decode($_POST['cliente']);
        //pega  id do veiculo selecionado se tiver.
        print $clientes->updateValores($cliente);

        break;

    case 'get_cliente_veiculo':
        $cliente = new stdClass;
        $cliente = json_decode($_POST['cliente']);
        print $clientes->getClienteVeiculo($cliente);
        break;    

    case 'salvaVeiculoCliente':
        $cliente = json_decode($_POST['cliente']);
        $veiculo = json_decode($_POST['veiculo']);   
        print $clientes->salvaVeiculo($cliente,$veiculo);
        break;    
        
////////////////////// Veiculo //////////////////////////
    case 'get_veiculos':
        print $veiculos->getVeiculos();
        break;

    case 'get_veiculo':
        $veiculo = new stdClass;
        $veiculo = json_decode($_POST['veiculo']);
        print $veiculos->getVeiculo($veiculo);
        break;

    case 'get_busca_veiculo':
        $sBusca = $_POST['sbusca'];
        if ($sBusca == null) {
            print $veiculos->getVeiculos();
        } else {
            print $veiculos->getBuscaVeiculo($sBusca);
        }
        break;

    case 'add_veiculo':
        $veiculo = new stdClass;
        $veiculo = json_decode($_POST['veiculo']);
        print $veiculos->add($veiculo);
        break;

    case 'delete_veiculo':
        $veiculo = new stdClass;
        $veiculo = json_decode($_POST['veiculo']);
        print $veiculos->delete($veiculo);
        break;

    case 'update_veiculo_data':
        $veiculo = new stdClass;
        $veiculo = json_decode($_POST['veiculo']);
        print $veiculos->updateValores($veiculo);
        break;

////////////////////// Orcamentos //////////////////////////

    case 'get_orcamentos':
        print $orcamentos->getOrcamentos();
        break;

    case 'get_orcamento':
        $orcamento = new stdClass;
        $orcamento = json_decode($_POST['orcamento']);
        print $orcamentos->getOrcamento($orcamento);
        break;

    case 'get_itens_orcamento':
        $orcamento = new stdClass;
        $orcamento = json_decode($_POST['orcamento']);
        print $orcamentos->getItensOrcamento($orcamento);
        break;

    case 'get_busca_orcamento':
        $sBusca = $_POST['sbusca'];
        if ($sBusca == null) {
            print $orcamentos->getOrcamentos();
        } else {
            print $orcamentos->getBuscaOrcamento($sBusca);
        }
        break;

    case 'add_orcamento':
        $orcamento = new stdClass;
        $orcamento = json_decode($_POST['orcamento']);
        $id_chave = $orcamentos->CriaChave();
        $orcamento->id = $id_chave;                
        $orcamentos->add($orcamento);
        $orcamento->id = $id_chave;        
        $orcamentos->addItensValores($orcamento);
        print json_encode(0);
        break;

    case 'delete_orcamento':
        $orcamento = new stdClass;
        $orcamento = json_decode($_POST['orcamento']);
        print $orcamentos->delete($orcamento);
        break;

    case 'update_orcamento_data':
        $orcamento = new stdClass;
        $orcamento = json_decode($_POST['orcamento']);
        print $orcamentos->updateValores($orcamento);
        break;

    case 'update_itens_orcamento_data':
        $orcamento = new stdClass;
        $orcamento = json_decode($_POST['orcamento']);
        print $orcamentos->updateItensValores($orcamento);
        break;
}

exit();