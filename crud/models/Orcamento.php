<?php

class Orcamento
{

    private $dbh;

    private $tabelaOrcamento = 'mod_orcamento';
    private $tabelaItensOrcamento = 'mod_itens_orcamento';    

    public function __construct($host, $user, $pass, $db)
    {
        $this->dbh = new PDO("mysql:host=" . $host . ";dbname=" . $db, $user, $pass);
    }

    public function getBuscaOrcamentos($filtro)
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaOrcamento . " where " . $filtro);
        $sth->execute();
        return $sth->fetchAll();
    }
	
    public function getOrcamentos()
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaOrcamento);
        $sth->execute();
        return json_encode($sth->fetchAll());
    }

    public function getOrcamento($orcamento)
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaOrcamento . " WHERE id=" . $orcamento);
        $sth->execute();
        return json_encode($sth->fetchAll());
    }

    public function getItensOrcamento($orcamento)
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaItensOrcamento . " WHERE idorcamento=" . $orcamento);
        $sth->execute();
        return json_encode($sth->fetchAll());
    }

    public function CriaChave()
    {
        $sth = $this->dbh->prepare("INSERT INTO " . $this->tabelaOrcamento . "(atendente) VALUES (?);");
        $sth->execute(array('CESAR FILHO' /*usuario logado do sistema*/));
        
        //if (!empty ($sth->errorInfo()))
        //{
        //    return $sth->errorInfo();
        //}
        return $this->GetChaveCriada();
    }

    public function getChaveCriada()
    {
      return $this->dbh->lastInsertId();      
    }
    
    public function add($orcamento)
    {
        $valida = $this->ValidaValores($orcamento);
        if ($valida == 0) {           
            $this->updateValores($orcamento);
        /*    
            $sth = $this->dbh->prepare("INSERT INTO " . $this->tabelaOrcamento . "(
			atendente,
			sformapagamento,
			totaitens,
			vltotal
			) VALUES (?,?,?,?);");
            $sth->execute(array(
                $orcamento->atendente,
                $orcamento->sformapagamento,
                $orcamento->totaitens,
                $orcamento->vltotal
            ));
            return json_encode($sth->errorInfo());
        } else {
            return json_encode($valida);
        */
            
        }
    }
    
    public function addItensValores($dados)
    {
///////////////////////////////////////        
///////////////////////////////////////
//valor item não esta gravando no banco
///////////////////////////////////////
///////////////////////////////////////        
        $itens = array();
        $oItensOrcamento = new stdClass();
        parse_str($dados->itens, $itens);
        //salva cada item.
        $total  = count($itens)/5; // acha o total de linhas ou registros de itens a srem salvos
        for ($n=1; $n <= $total ;$n++)
        {
            $oItensOrcamento->idorcamento =  $dados->id;
            $oItensOrcamento->descricao = $itens['descricao_'.$n];
            $oItensOrcamento->valoritem = $itens['valoritem_'.$n];			
            $oItensOrcamento->qtditem = $itens['qtditem_'.$n];			
            $oItensOrcamento->desconto = $itens['desconto_'.$n];
            $this->SalvaItemOrcamento($oItensOrcamento);
        }		
    }    

    public function SalvaItemOrcamento($dados)
    {
        $sth = $this->dbh->prepare("INSERT INTO " . $this->tabelaItensOrcamento . "(
            idorcamento,
            descricao,
            valoritem,
            qtditem,
            desconto
            ) VALUES (?,?,?,?,?);");
        $sth->execute(array(
                $dados->idorcamento,
                $dados->descricao,
                $dados->valoritem,
                $dados->qtditem,
                $dados->desconto
        ));
        return json_encode($this->dbh->errorInfo());    	
    }

    public function updateItensValores($orcamento,$dados)
    {
        DeleteItensOrcamento($orcamento);
        addItensValores($dados);
    }


    public function DeleteItensOrcamento($orcamento)
    {
        //deleta todos os registros do orcamento
        $sth = $this->dbh->prepare("DELETE FROM " . $tabelaItensOrcamento . " WHERE idorcamento=?");
        $sth->execute(array($orcamento->id));
        return json_encode(1);
    }    
    public function delete($orcamento)
    {
        $sth = $this->dbh->prepare("DELETE FROM " . $this->tabelaOrcamento . " WHERE id=?");
        $sth->execute(array($orcamento->id));
        return json_encode(1);
    }

    public function updateValue($orcamento)
    {
        $sth = $this->dbh->prepare("UPDATE " . $this->tabelaOrcamento . " SET " . $orcamento->field . "=? WHERE id=?");
        $sth->execute(array($orcamento->newvalue, $orcamento->id));
        return json_encode(1);
    }

    public function updateValores($orcamento)
    {
        $campos = null;
        $valores = array();
        $idtemp = $orcamento->id;
        unset($orcamento->id);
        foreach ($orcamento as $campo => $valor) {
            if ($campo != 'itens')
            {
                if ($campos != null)
                {
                    $campos .= ',';
                }
                $campos .= $campo . "=?";
                $valores[$campo] = $valor;
                }        
            }
        $sth = $this->dbh->prepare("UPDATE " . $this->tabelaOrcamento . " SET " . $campos . " WHERE id=" . $idtemp);
        $sth->execute(array_values($valores));
        return json_encode($sth->errorinfo());
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

    public function ValidaValores($orcamento)
    {

        if ((trim($orcamento->atendente)) == null) {
            $erro = 'atendente';
            $msg_erro = 'Atendente vazio!';
        }
        if ((trim($orcamento->sformapagamento)) == null) {
            $erro = 'sformapagamento';
            $msg_erro = 'Forma pagamento vazio!';
        }
        if ((trim($orcamento->totaitens)) == null) {
            $erro = 'totaitens';
            $msg_erro = 'Total de itens vazio!';
        }elseif(!is_numeric(trim($orcamento->totaitens))){
            $erro = 'totaitens';
            $msg_erro = 'Total de itens não é um número válido!';
        }
        if ((trim($orcamento->vltotal)) == null) {
            $erro = 'vltotal';
            $msg_erro = 'Valor total vazio!';
        }elseif(!is_numeric(trim($orcamento->vltotal))){
            $erro = 'vltotal';
            $msg_erro = 'Valor total não é um número válido!';
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