<?php

class Cliente
{

    private $dbh;

    private $tabelaCliente = 'mod_cliente';

    public function __construct($host, $user, $pass, $db)
    {
        $this->dbh = new PDO("mysql:host=" . $host . ";dbname=" . $db, $user, $pass);
    }

    public function getClientes()
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaCliente);
        $sth->execute();
        return json_encode($sth->fetchAll());
    }

    public function getCliente($cliente)
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaCliente . " WHERE id=" . $cliente);
        $sth->execute();
        return json_encode($sth->fetchAll());
    }

    public function getClienteVeiculo($cliente)
    {
        $sth = $this->dbh->prepare("SELECT v.id,v.marca,v.placa,v.modelo FROM  mod_veiculos_clientes vc inner join mod_veiculo v on (vc.cd_veiculo = v.id)  WHERE vc.cd_cliente=".$cliente);        
        $sth->execute();
        return json_encode($sth->fetchAll());
    }    

    public function salvaVeiculo($cliente,$veiculo)
    {
        $sth = $this->dbh->prepare("INSERT INTO  mod_veiculos_clientes (cd_veiculo,cd_cliente,status) values (".$veiculo.",".$cliente.",'A')");        
        $sth->execute();
        return json_encode($sth->fetchAll());
    }   

    public function add($cliente)
    {
        $valida = $this->ValidaValores($cliente);
        if ($valida == 0) {
            $sth = $this->dbh->prepare("INSERT INTO " . $this->tabelaCliente . "(
			nome,
			nascimento,
			cpf,
			endereco,
			cidade,
			uf,
			bairro,
			cep,
			complemento,
			email,
			telefonecelular,
			rg,
			pais
			) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $sth->execute(array(
                $cliente->nome,
                $this->FormataDataToDb($cliente->nascimento),
                $cliente->cpf,
                $cliente->endereco,
                $cliente->cidade,
                $cliente->uf,
                $cliente->bairro,
                $cliente->cep,
                $cliente->complemento,
                $cliente->email,
                $cliente->telefonecelular,
                $cliente->rg,
                $cliente->pais
            ));
            return json_encode($this->dbh->lastInsertId());
        } else {
            return json_encode($valida);
        }
    }

    public function delete($cliente)
    {
        $sth = $this->dbh->prepare("DELETE FROM " . $this->tabelaCliente . " WHERE id=?");
        $sth->execute(array($cliente->id));
        return json_encode(1);
    }

    public function updateValue($cliente)
    {
        $sth = $this->dbh->prepare("UPDATE " . $this->tabelaCliente . " SET " . $cliente->field . "=? WHERE id=?");
        $sth->execute(array($cliente->newvalue, $cliente->id));
        return json_encode(1);
    }

    public function updateValores($cliente)
    {
        $campos = null;
        $valores = array();
        $idtemp = $cliente->id;
        unset($cliente->id);
        foreach ($cliente as $campo => $valor) {
            if ($campos != null) {
                $campos .= ',';
            }
            $campos .= $campo . "=?";
            $valores[$campo] = $valor;
        }
        $sth = $this->dbh->prepare("UPDATE " . $this->tabelaCliente . " SET " . $campos . " WHERE id=" . $idtemp);
        $sth->execute(array_values($valores));
        return json_encode($sth->errorinfo());
    }

    public function updateVeiculoCliente($cliente,$veiculo)
    {
    	$status = 'A';
        $sth = $this->dbh->prepare("SELECT count(cd_cliente) as total FROM mod_veiculos_clientes where cd_cliente = ".$cliente." and cd_veiculo = ".$veiculo );
        $sth->execute();
        $total = $sth->fetchAll();
        if ($total[0]['total'] == 0){
	        $sth = $this->dbh->prepare("INSERT INTO mod_veiculos_clientes (CD_CLIENTE,CD_VEICULO,STATUS) values (".$cliente.",".$veiculo.",'".$status."');");
	        $sth->execute();
            return json_encode(2);            
        }else{
        	var_dump('<><><><><><><><><><><><>');

            return json_encode(1);                        
        }
    }  

    public function FormataDataToDb($data)
    {
        $saida = explode('/', $data);
        if (count($saida) < 2) {
            return $erro = 'data2 formato inválido';
        }
        if (checkdate($saida[1], $saida[2], $saida[0]) == 1) {
            $saida = "$saida[2]-$saida[1]-$saida[0]";
            return $saida;
        } else
            return $erro = 'data iválida';

    }

    public function ValidaValores($cliente)
    {

        if ((trim($cliente->nome)) == null) {
            $erro = 'nome';
            $msg_erro = 'Nome vazio ou inválido!';
        }
        if ((trim($cliente->nascimento)) == null) {
            $erro = 'nascimento';
            $msg_erro = 'Data Nascimento Vazio!';
        } elseif (!$this->FormataDataToDb($cliente->nascimento)) {
            $erro = 'nascimento';
            $msg_erro = 'Data Nascimento Inválida!';
        }
        if ((trim($cliente->cpf)) == null) {
            $erro = 'CPF';
            $msg_erro = 'CPF vazio!';
        }
        if ((trim($cliente->endereco)) == null) {
            $erro = 'endereco';
            $msg_erro = 'Endereco vazio ou inválido!';
        }
        if ((trim($cliente->cidade)) == null) {
            $erro = 'cidade';
            $msg_erro = 'Cidade vazio ou inválido!';
        }
        if ((trim($cliente->uf)) == null) {
            $erro = 'uf';
            $msg_erro = 'UF vazio ou inválido!';
        }
        if ((trim($cliente->bairro)) == null) {
            $erro = 'bairro';
            $msg_erro = 'Bairro vazio ou inválido!';
        }
        if ((trim($cliente->cep)) == null) {
            $erro = 'cep';
            $msg_erro = 'CEP vazio ou inválido!';
        }
        if ((trim($cliente->complemento)) == null) {
            $erro = 'complemento';
            $msg_erro = 'Complemento vazio ou inválido!';
        }
        if ((trim($cliente->email)) == null) {
            $erro = 'email';
            $msg_erro = 'Email vazio!';
        } elseif (!filter_var($cliente->email, FILTER_VALIDATE_EMAIL)) {
            $erro = 'email';
            $msg_erro = 'Email inválido!';
        }
        if ((trim($cliente->telefonecelular)) == null) {
            $erro = 'telefonecelular';
            $msg_erro = 'Telefone Celular vazio ou inválido!';
        }
        if ((trim($cliente->rg)) == null) {
            $erro = 'rg';
            $msg_erro = 'RG vazio ou inválido!';
        }
        if ((trim($cliente->pais)) == null) {
            $erro = 'pais';
            $msg_erro = 'País vazio ou inválido!';
        }

        if (isset($erro)) {
            $saida['campo'] = $erro;
            $saida['msg_erro'] = $msg_erro;
            return $saida;
        } else {
            return 0;
        }
    }
}

?>