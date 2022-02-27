<?php

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database {

   private $ligacao;

   private function ligar() {
       //ligação ao banco de dados
        $this->ligacao = new PDO(
            'mysql:'.
            'host='.MYSQL_SERVER.';'.
            'dbname='.MYSQL_DATABASE.';'.
            'charset'.MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );

        //DEBUG
        $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   }

   public function desligar() {
       //desligar-se da base de dados
       $this->ligacao = null;
   }

   //CRUD

   public function select($sql, $parametros = null){

        //verifica se é uma instrução SELECT
        if(!preg_match("/^SELECT/i", $sql)){
            throw new Exception('Base de dados - Não é um instrução SELECT.');
        }
        

        //execução função de pesquisa de SQL
        $this->ligar();

        $resultados = null;

        try{
            if(!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            }
        } catch(PDOException $e) {
            return false;
        }

        $this->desligar();
            return $resultados;
}

   public function insert($sql, $parametros = null){


    //verifica se é uma instrução INSERT
    if(!preg_match("/^INSERT/i", $sql)){
        throw new Exception('Base de dados - Não é um instrução INSERT.');
    }
    

    //liga
    $this->ligar();

    try{
        if(!empty($parametros)) {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute($parametros);
        } else {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute();
        }
    } catch(PDOException $e) {
        return false;
    }

    $this->desligar();
}

    public function update($sql, $parametros = null){

        //verifica se é uma instrução UPDATE
        if(!preg_match("/^UPDATE/i", $sql)){
            throw new Exception('Base de dados - Não é um instrução UPDATE.');
        }
    
        //liga
        $this->ligar();
    
        try{
            if(!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch(PDOException $e) {
            return false;
        }
    
        $this->desligar();
}

    public function delete($sql, $parametros = null){

        //verifica se é uma instrução DELETE
        if(!preg_match("/^DELETE/i", $sql)){
            throw new Exception('Base de dados - Não é um instrução DELETE.');
        }
        
    
        //liga
        $this->ligar();
    
        try{
            if(!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch(PDOException $e) {
            return false;
        }
    
        $this->desligar();
}

//Generica

public function statement($sql, $parametros = null){

    //verifica se é uma instrução diferente das anteriores
    if(preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)){
        throw new Exception('Base de dados - Não é um instrução inválida.');
    }
    
    //liga
    $this->ligar();

    try{
        if(!empty($parametros)) {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute($parametros);
        } else {
            $executar = $this->ligacao->prepare($sql);
            $executar->execute();
        }
    } catch(PDOException $e) {
        return false;
    }

    $this->desligar();
}

}