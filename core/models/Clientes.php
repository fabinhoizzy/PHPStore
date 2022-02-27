<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes
{

    public function verificar_email_existe($email)
    {
        //verifica se já existe outra conta de email

        $db = new Database();
        $paramentros = [
            ':email' => strtolower(trim($email))
        ];
        $resultados = $db->select("SELECT email FROM clientes WHERE email = :email", $paramentros);

        //se o cliente existe...
        if (count($resultados) != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registrar_cliente()
    {

        //registra o novo cliente no bando de dados
        $db = new Database();

        // cria uma hash para o registro do cliente
        $purl = Store::criarHash();

        //paramentros
        $paramentros = [
            ':email' => strtolower(trim($_POST['text_email'])),
            ':senha' => password_hash(trim($_POST['text_senha_1']), PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['text_nome_completo']),
            ':morada' => trim($_POST['text_morada']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':activo' => 0
        ];

        $db->insert("INSERT INTO clientes VALUES(
            0, 
            :email, :senha, :nome_completo, :morada,
            :cidade, :telefone, :purl, :activo, NOW(), NOW(), NULL
            )", $paramentros);

        // retorna o purl criado
        return $purl;
    }

    public function validar_email($purl)
    {

        $db = new Database();
        $parametros = [':purl' => $purl];

        $resultados = $db->select("SELECT * FROM clientes WHERE purl = :purl", $parametros);
        // verifica se foi encontrado o cliente
        if (count($resultados) != 1) {

            return false;
        }
        // foi encontrado este cliente com o purl indicado
        $id_cliente = $resultados[0]->id_cliente;

        //atualizar os dados do cliente
        $parametros = [':id_cliente' => $id_cliente];

        $db->update("UPDATE clientes SET purl = NULL, activo = 1, updated_at = NOW() WHERE id_cliente = :id_cliente", $parametros);

        return true;
    }

    public function validar_login($usuario, $senha)
    {
        $paramentros = [
            ':usuario' => $usuario
        ];

        $db = new Database();
        $resultados = $db->select(
            "SELECT * FROM clientes 
            WHERE email = :usuario 
            AND activo = 1 
            AND deleted_at IS NULL
        ", $paramentros); 

        if(count($resultados) != 1){
            
            // não existe usuario
            return false;
        } else {

            // temos um usuario, agora verificar sua senha
            $usuario = $resultados[0];

            // verificar senha
            if(!password_verify($senha, $usuario->senha)){
                
                //password inválida
                return false;
            } else {

                //login válido
                return $usuario;
            }



        }
    }
    public function buscar_dados_cliente($id_cliente)
    {
        $parametros = [
            'id_cliente' => $id_cliente
        ];

        $db = new Database();
        $resultado = $db->select("SELECT * FROM clientes WHERE id_cliente = :id_cliente", $parametros);
        return $resultado[0];
    }
}
