<?php

class Veiculo
{

    private $dbh;

    private $tabelaVeiculo = 'mod_veiculo';

    public function __construct($host, $user, $pass, $db)
    {
        $this->dbh = new PDO("mysql:host=" . $host . ";dbname=" . $db, $user, $pass);
    }

    public function getVeiculos()
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaVeiculo);
        $sth->execute();
        return json_encode($sth->fetchAll());
    }

    public function getVeiculo($veiculo)
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaVeiculo . " WHERE id=" . $veiculo);
        $sth->execute();
        return json_encode($sth->fetchAll());
    }


    public function getBuscaVeiculo($string)
    {
        $sth = $this->dbh->prepare("SELECT * FROM " . $this->tabelaVeiculo . " WHERE marca like'%" . $string . "%' or modelo like'%" . $string . "%' or placa like'%" . $string . "%'");
        $sth->execute();
        return json_encode($sth->fetchAll());
    }


    public function add($veiculo)
    {
        $valida = $this->ValidaValores($veiculo);
        if ($valida == 0) {
            $sth = $this->dbh->prepare("INSERT INTO " . $this->tabelaVeiculo . "(
			marca,
			modelo,
			ano,
			cor,
			placa,
			km,
			cdcliente
			) VALUES (?,?,?,?,?,?,?)");
            $sth->execute(array(
                $veiculo->marca,
                $veiculo->modelo,
                $veiculo->ano,
                $veiculo->cor,
                $veiculo->placa,
                $veiculo->km,
                1
            ));
            return json_encode($this->dbh->lastInsertId());
        } else {
            return json_encode($valida);
        }
    }

    public function delete($veiculo)
    {
        $sth = $this->dbh->prepare("DELETE FROM " . $this->tabelaVeiculo . " WHERE id=?");
        $sth->execute(array($veiculo->id));
        return json_encode(1);
    }

    public function updateValue($veiculo)
    {
        $sth = $this->dbh->prepare("UPDATE " . $this->tabelaVeiculo . " SET " . $veiculo->field . "=? WHERE id=?");
        $sth->execute(array($veiculo->newvalue, $veiculo->id));
        return json_encode(1);
    }

    public function updateValores($veiculo)
    {
        $campos = null;
        $valores = array();
        $idtemp = $veiculo->id;
        unset($veiculo->id);
        foreach ($veiculo as $campo => $valor) {
            if ($campos != null) {
                $campos .= ',';
            }
            $campos .= $campo . "=?";
            $valores[$campo] = $valor;
        }
        $sth = $this->dbh->prepare("UPDATE " . $this->tabelaVeiculo . " SET " . $campos . " WHERE id=" . $idtemp);
        $sth->execute(array_values($valores));
        return json_encode(1);
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

    public function ValidaValores($veiculo)
    {

        if ((trim($veiculo->marca)) == null) {
            $erro = 'marca';
            $msg_erro = 'Marca vazia ou inválida!';
        }
        if ((trim($veiculo->modelo)) == null) {
            $erro = 'modelo';
            $msg_erro = 'Modelo vazio!';
        }
        if ((trim($veiculo->ano)) == null) {
            $erro = 'ano';
            $msg_erro = 'Ano vazio ou inválido!';
        }
        if ((trim($veiculo->cor)) == null) {
            $erro = 'cor';
            $msg_erro = 'Cor vazio ou inválido!';
        }
        if ((trim($veiculo->placa)) == null) {
            $erro = 'placa';
            $msg_erro = 'Placa vazio ou inválido!';
        }
        if ((trim($veiculo->km)) == null) {
            $erro = 'km';
            $msg_erro = 'KM vazio ou inválido!';
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
