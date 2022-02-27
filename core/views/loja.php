
<div class="container espaco-fundo">

    <div class="row">
        <div class="col-12 text-center my-4">

            <a href="?a=loja&c=todos" class="btn btn-primary">Todos</a>

            <?php foreach ($categorias as $categoria) : ?>
                <a href="?a=loja&c=<?= $categoria ?>" class="btn btn-primary">
                    <?= ucfirst(preg_replace("/\_/", " ", $categoria)) ?></a>
            <?php endforeach; ?>
        </div>

    </div>

    <!--Produtos -->
    <div class="row">

        <?php if (count($produtos) == 0): ?>
            <div class="text_center">
                <h3>Não existem produtos disponíveis</h3>
            </div>
        <?php else: ?>

            <?php foreach ($produtos as $produto): ?>

                <div class="col-sm-4 col-6 p-2">
                    <div class="text-center p-3 box-produto">
                        <img src="assets/images/produtos/<?= $produto->imagem ?>" class="img-fluid">
                        <h4><?= $produto->nome_produto ?></h4>
                        <h3><small>R$ <?= preg_replace("/\./", "," , $produto->preco) ?></small></h3>
                        <div>
                            <?php if($produto->stock > 0): ?>
                                <button class="btn btn-primary" onclick="adicionar_carrinho(<?= $produto->id_produto ?>)"><i class="fas fa-shopping-cart me-2"> Adicionar ao carrinho</i></button>
                            <?php else: ?>
                                <button class="btn btn-danger"><i class="fas fa-shopping-cart me-2"> Indisponível no Momento</i></button>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif ?>
    </div>
</div>