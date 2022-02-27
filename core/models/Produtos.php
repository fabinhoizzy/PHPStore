<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos
{

    public function lista_produtos_disponiveis($categoria)
    {
        $this->lista_categorias();

        //buscar todas as informações dos produtos da base de dados
        $db = new Database();

        //buscar a lista de categorias da loja
        $categorias = $this->lista_categorias();

        $sql = "SELECT * FROM produtos ";
        $sql .= "WHERE visivel = 1 ";

        if (in_array($categoria, $categorias)) {
            $sql .= "AND categoria = '$categoria'";
        }

        $produtos = $db->select($sql);

        return $produtos;
    }

    public function lista_categorias()
    {
        //devolve a lista de categorias existentes na base de dados
        $db = new Database();

        $resultados = $db->select("SELECT DISTINCT categoria FROM produtos");
        $categorias = [];
        
        foreach($resultados as $resultado) {
            array_push($categorias, $resultado->categoria);
        }

        return $categorias;
    }

    public function verificar_estoque_produto($id_produto)
    {
        $db = new Database();
        $parametros = [
            ':id_produto' => $id_produto
        ];
        $resultados = $db->select("SELECT * FROM produtos 
            WHERE id_produto = :id_produto
            AND visivel = 1 
            AND stock > 0    
            ", $parametros);

        return count($resultados) != 0 ? true : false;    
    }

    public function buscar_produtos_por_ids($ids)
    {
        $db = new Database();
        $parametros = [
            ':ids' => $ids
        ];

        return $db->select("SELECT * FROM produtos WHERE id_produto IN ($ids)");
    }
}
