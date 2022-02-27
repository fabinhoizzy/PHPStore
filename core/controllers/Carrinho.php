<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class Carrinho
{

    public function adicionar_carrinho()
    {
        //vai buscar o id do produto a query string
        if (!isset($_GET['id_produto'])) {

            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        //define o id do produto
        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();
        $resultados = $produtos->verificar_estoque_produto($id_produto);

        if (!$resultados) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        //adiciona/gestao da variavel de sessao do carrinho
        $carrinho = [];

        if (isset($_SESSION['carrinho'])) {
            $carrinho = $_SESSION['carrinho'];
        }

        //adicionar o produto ao carrinho

        if (key_exists($id_produto, $carrinho)) {

            //já existe o produto. Acrescenta mais uma unidade
            $carrinho[$id_produto]++;
        } else {
            //adicionar novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }

        //atualiza oso dados do carrinho na sessão 
        $_SESSION['carrinho'] = $carrinho;

        //devolve a resposta (número de produtos do carrinho)
        $total_produtos = 0;
        foreach ($carrinho as $quantidade) {
            $total_produtos += $quantidade;
        }

        echo $total_produtos;
    }

    public function limpar_carrinho()
    {
        //limpa o carrinho de todos os produtos

        unset($_SESSION['carrinho']);

        //refresh da página do carrinho
        $this->carrinho();
    }


    public function carrinho()
    {
        // verificar se existe carrinho
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                'carrinho' => null
            ];
        } else {

            $ids = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                array_push($ids, $id_produto);
            }

            $ids = implode(",", $ids);
            $produtos = new Produtos();
            $resultados = $produtos->buscar_produtos_por_ids($ids);

            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

                //imagem do produto
                foreach ($resultados as $produto) {
                    if ($produto->id_produto == $id_produto) {
                        $id_produto = $produto->id_produto;
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco * $quantidade;

                        //colocar o produto na coleção
                        array_push($dados_tmp, [
                            'id_produto' => $id_produto,
                            'imagem' => $imagem,
                            'titulo' => $titulo,
                            'quantidade' => $quantidade,
                            'preco' => $preco,
                        ]);

                        break;
                    }
                }
            }

            //calcular o total de preços dos produtos
            $total_da_encomenda = 0;
            foreach ($dados_tmp as $item) {
                $total_da_encomenda += $item['preco'];
            }

            array_push($dados_tmp, $total_da_encomenda);

            $dados = [
                'carrinho' => $dados_tmp
            ];
        }

        // mostrar pagina da loja carrinho 
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    public function remover_produto_carrinho()
    {
        //vai buscar o id_produto na query string
        $id_produto = $_GET['id_produto'];

        //buscar o carrinho na sessão 
        $carrinho = $_SESSION['carrinho'];

        //remover o produto do carrinho
        unset($carrinho[$id_produto]);

        //atualizar o carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        //apresentar novamente a página do carrinho
        $this->carrinho();
    }

    public function finalizar_encomenda()
    {
        //Store::printData($_SESSION); 

        //verifica se a cliente logado
        if (!isset($_SESSION['cliente'])) {

            // coloca na sessão um referrer temporário
            $_SESSION['tmp_carrinho'] = true;

            //redirecionar para a pagina da loja
            Store::redirect('login');
        } else {

            Store::redirect('finalizar_encomenda_resumo');
        }
    }

    public function finalizar_encomenda_resumo()
    {
        //verificar se existe cliente logado
        if(!isset($_SESSION['cliente'])) {
            Store::redirect('inicio');
        }

        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }

        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $resultados = $produtos->buscar_produtos_por_ids($ids);

        $dados_tmp = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

            //imagem do produto
            foreach ($resultados as $produto) {
                if ($produto->id_produto == $id_produto) {
                    $id_produto = $produto->id_produto;
                    $imagem = $produto->imagem;
                    $titulo = $produto->nome_produto;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produto->preco * $quantidade;

                    //colocar o produto na coleção
                    array_push($dados_tmp, [
                        'id_produto' => $id_produto,
                        'imagem' => $imagem,
                        'titulo' => $titulo,
                        'quantidade' => $quantidade,
                        'preco' => $preco,
                    ]);

                    break;
                }
            }
        }

        //calcular o total de preços dos produtos
        $total_da_encomenda = 0;
        foreach ($dados_tmp as $item) {
            $total_da_encomenda += $item['preco'];
        }

        array_push($dados_tmp, $total_da_encomenda);

        // Preparar os dados da viem
        $dados = [];
        $dados['carrinho'] = $dados_tmp;
        
        //buscar informações do cliente
        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);
        $dados['cliente'] = $dados_cliente;

          // mostrar pagina da loja carrinho 
          Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_resumo',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);
    }

    public function endereco_alternativo()
    {
        //receber os dados via AXIOS
        $post = json_decode(file_get_contents('php://input'), true);

        $_SESSION['dados_alternativos'] = [
            'morada' => $post['text_morada'],
            'cidade' => $post['text_cidade'],
            'email' => $post['text_email'],
            'telefone' => $post['text_telefone'],
        ];
    }

    public function escolher_metodo_pagamento()
    {

        echo 'escolher metodo de pagamento';
        // $_SESSION['dados_alternativos'] = [

        // ];    

        Store::printData($_SESSION);

    }


}
