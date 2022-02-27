<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class Main
{

    public function index()
    {


        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'inicio',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }

    public function loja()
    {

        //apresenta a página da loja


        //buscar a lista de produtos disponiveis

        $produtos = new Produtos();

        //analisa que categoria e para mostrar
        $c = 'todos';
        if(isset($_GET['c'])) {
            $c = $_GET['c'];
        }

        //buscar informação a base de dados
        $lista_produtos = $produtos->lista_produtos_disponiveis($c); 
        $lista_categorias = $produtos->lista_categorias();

        $dados = [
            'produtos' => $lista_produtos,
            'categorias' => $lista_categorias,
        ];

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'loja',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    public function novo_cliente()
    {

        // verifica se já existe sessao aberta

        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // apresentar o layout para criar um novo usuario

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'criar_cliente',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }

    public function criar_cliente()
    {

        //verificar se ja existe sessao

        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verificar se houve submissao de um formulario
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // criação do novo cliente
        // verifica se senha 1 = senha 2
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            // as senhas são diferente
            $_SESSION['erro'] = 'As senhas são diferentes';
            $this->novo_cliente();
            return;
        }

        // verifica no bando de dados se existe o mesmo email
        $cliente = new Clientes();
        if ($cliente->verificar_email_existe($_POST['text_email'])) {

            $_SESSION['erro'] = 'Já existe um cliente com esse E-mail!';
            $this->novo_cliente();
            return;
        }

        //inserir novo cliente no bando de dados e devolver o purl

        $purl = $cliente->registrar_cliente();
        $email_cliente = strtolower(trim($_POST['text_email']));

        // envio do email para o cliente
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_novo_clinte($email_cliente, $purl);

        if ($resultado) {

            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'criar_cliente_sucesso',
                'layouts/footer',
                'layouts/html_footer'
            ]);
            return;
        } else {
            echo 'acontenceu um erro';
        }
    }

    public function confirmar_email()
    {
        //verifica se já existe sessao
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verificar se existe na query string um purl
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }

        $purl = $_GET['purl'];

        // verificar se o purl é valido
        if (strlen($purl) != 12) {
            $this->index();
            return;
        }

        $cliente = new Clientes();
        $resultado = $cliente->validar_email($purl);

        if ($resultado) {

            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'conta_confirmada_sucesso',
                'layouts/footer',
                'layouts/html_footer'
            ]);
            return;
        } else {

            //redirecionar para página ínicial
            Store::redirect();
        }
    }

    public function login()
    {

        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'login_frm',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }

    public function login_submit()
    {
        //verifica se já existe um usuário logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        //verifica se foi efetuado o post do formulário de login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        //verificar se o login é válido
        if (
            !isset($_POST['text_usuario']) ||
            !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)
        ) {
            //Erro de preenchimento de usuário
            $_SESSION['erro'] = 'login inválido';
            Store::redirect('login');
            return;
        }
        //prepara os dados para o model

        $usuario = trim(strtolower($_POST['text_usuario']));
        $senha = trim($_POST['text_senha']);

        // carrega o model e verifica se login e valido
        $cliente = new Clientes();
        $resultado = $cliente->validar_login($usuario, $senha);

        //analisa o resultado
        if (is_bool($resultado)) {

            //login invalido
            $_SESSION['erro'] = 'login inválido';
            Store::redirect('login');
            return;
        } else {

            // login válido
            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['usuario'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;

            //redirecionar para o local correto

            if(isset($_SESSION['tmp_carrinho'])) {

                //remove a variável temporária da sessão
                unset($_SESSION['tmp_carrinho']);
                
                //redireciona para o resumo do carrinho
                Store::redirect('finalizar_encomenda_resumo');
            } else {
                Store::redirect();
                
            }
        }
    }

    public function logout()
    {

        //remove as variaveis da sessao
        unset($_SESSION['cliente']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nome_cliente']);

        //redireciona para o inicio da loja
        Store::redirect();
    }

}
