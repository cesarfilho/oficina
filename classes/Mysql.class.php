<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of banco
 *
 * @author CesarFilho
 */

class MySQL {
 
    private $conexao, $host, $user, $pass, $db, $dbon;
 
    /**
     * Esta funзгo й o construtor da classe, isso й, й a classe que serб chamada
     * quando um novo objeto deste tipo for instanciado
     */
    public function __construct() {
        //verificamos se temos todos os dados de conexгo
            
            $host = 'localhost';
            $user = 'root';
            $pass = '';
            $db = 'ipamp_sys';
            
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->db = $db;

    }
 
    /**
     * Esta função responsбvel por abrir a conexгo com o banco de dados
     */
    private function abreConexao() {

        $this->conexao = mysql_connect('localhost', 'root', '');
        if ($this->conexao != false){
            $this->dbon  = mysql_select_db('ipamp_sys',$this->conexao);
            
            if($this->dbon == false){
               var_dump(mysql_error());
            }
        }
        else{
            var_dump("erro ao conectar o banco");
        }
    }
 
    /**
     * Funзгo responsável por finalizar a conexгo ao banco de dados
     */
    private function fechaConexao() {
        mysql_close($this->conexao);
    }
 
    public function fetch($sql = null) {
        if ($sql == null) {
            throw new Exception("Consulta SQL está vazia");
        }
 
        $ret = (array) array(); //Crio um array vazio, esse será o retorno
        $this->abreConexao(); //Abro a conexгo com o servidor de dados
        
        $exe = $this->exec($sql);

        while ($row = mysql_fetch_assoc($exe)) {
            $ret[] = $row;
        }
        return $ret;
    }
 
    public function exec($sql = null) {
        $this->abreConexao();
        if ($sql == null) {
            throw new Exception("Consulta SQL está vazia");
        }
        //$sql = mysql_real_escape_string($sql); // reavaliar para fazer funcionar corretamente;
        $query  = mysql_query($sql);
        $this->fechaConexao();
        return $query;
    }
 
    public function GetFieldsTable($table = null) {
    //pega os nomes das tabelas
        if ($table == null) {
            throw new Exception("Table não definida");
        }        
        $this->abreConexao();

        $sql = "SHOW COLUMNS FROM $table";

        $exe = $this->exec($sql);


        while ($row = mysql_fetch_assoc($exe)) {
            $ret[] = $row['Field'];
        }
        return $ret;

    }
    
    public function GetInfoFieldsTable($table = null) {
    // info dos campos da tabela    
        $this->abreConexao();

        $sql = "show columns from $table";
        $exe = $this->exec($sql);

        while ($row = mysql_fetch_assoc($exe)) {
            $ret[] = $row;
        }
        return $ret;

    }
    public function GetCommentFieldsTable($table = null) {
    //lista comment da table    
        $this->abreConexao();
        
        $sql = "SELECT COLUMN_COMMENT as comment FROM information_schema.COLUMNS
                WHERE TABLE_NAME ='".$table."'";         

        $exe = $this->exec($sql);

        while ($row = mysql_fetch_assoc($exe)) {
            $ret[] = $row['comment'];
        }
        return $ret;

    }
    public function GetDefCampos($sTable = null,$aCampos = null) {
    //nome dos campos passados no parametro
       if ($sTable == null)
           return 'Tabela não definida';
       if ($aCampos == null)
           return 'Campos não definida';
       
       $aInfo = $this->GetInfoFieldsTable($sTable);
       $aComment = $this->GetCommentFieldsTable($sTable);
        
       for ($i = 0; $i <= count($aInfo)-1; $i++) {
           if (in_array($aInfo[$i]['Field'], $aCampos)){
             $aRetorno[$aInfo[$i]['Field']] = $aComment[$i];
           }
       } 
       return $aRetorno;
    }
    
    public function executa_sql ($sql = null){

        $result = $this->exec($sql);
    }
}
 
?>
   
