<?
require_once "../controle.php";


if (isset($_GET['acao'])) $acao = $_GET['acao'];
if (isset($_GET['ID'])) $ID = $_GET['ID'];
if (isset($_GET['tipocad'])) $tipocad = $_GET['tipocad'];

	switch ($tipocad) {
		case 'cliente':
                    $cliente = new Cliente();	        
                    $grid = new Grid();	        
                    $saida = $cliente->getClienteMascara($ID);
                    //$saida = $cliente->getCliente($ID); //sem mascaras
                    echo json_encode($saida);
		break;

        case 'veiculo':
                    $veiculo = new Veiculo();
                    $grid = new Grid();         
                    $saida = $veiculo->getVeiculoMascara($ID);
                    //$saida = $cliente->getCliente($ID); //sem mascaras
                    echo json_encode($saida);
        break;
		
		default:
                    # code...
                break;
	}

?>