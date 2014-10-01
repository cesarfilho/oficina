<?php

class Banco {

    private $bancodados = 'MYSQL';

    public function __construct($host, $user, $pass, $db)
    {
        $this->dbh = new PDO("mysql:host=" . $host . ";dbname=" . $db, $user, $pass);
    } 

	public Insere($tabela,$dados){
		//descobrir como faz para chamar uma classe mysql aqui!!!!.
		Insere($tabela,$dados,$bancodados);
	}

	public Salva($tabela,$dados){
		
	}

	public Consulta($sql){
		
	}

	public Consulta($campos,$tabela,$condicao){
		
	}

	public Apaga($campos,$tabela,$condicao){
	$sql = 'delete '+$tabela+' where'+ $condicao;	

    $this->dbh execute($sql);
	}

}

?>