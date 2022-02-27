<div class="container">
    <div class="row">
        <div class="col text-center">
            <hr>
            <h4 class="my-3">Seu carrinho</h4>
            <hr>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">

            <?php if ($carrinho == null) : ?>
                <div class="col text-center mt-3">
                    <h4><p>No momento não a produtos</p></h4>
                   <h4><a href="?a=loja" class="btn btn-primary">Ir para a loja</a></h4> 
                </div>
            <?php else : ?>
                <div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Imagens do produto</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor total</th>
                                <th>Editar pedido</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $index = 0;
                            $total_rows = count($carrinho);
                            ?>
                            <?php foreach ($carrinho as $produto) : ?>
                                <?php if ($index < $total_rows - 1) : ?>
                                    <!-- lista dos produtos -->
                                    <tr>
                                        <td class="align-middle"><img src="assets/images/produtos/<?= $produto['imagem']; ?>" class="img-fluid" width="80px"></td>
                                        <td class="align-middle"><?= $produto['titulo'] ?></td>
                                        <td class="align-middle"><?= $produto['quantidade'] ?></td>
                                        <td class="align-middle">R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></td>

                                        <td class="align-middle">
                                            <a href="?a=remover_produto_carrinho&id_produto=<?=$produto['id_produto'];?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <!-- total de preço -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="align-middle">
                                            <h4>Total:</h4>
                                        </td>
                                        <td class="align-middle">
                                            <h4>R$ <?= number_format($produto, 2, ',') ?></h4>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php $index++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col">
                            <!-- <a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Limpar carrinho</a> -->
                            <button onclick="limpar_carrinho()" class="btn btn-sm btn-primary">Limpar carrinho</button>
                            <span id= "confirmar_limpar_carrinho" style="display: none;">Tem a certeza?
                                    <button class="btn btn-sm btn-danger" onclick="limpar_carrinho_off()">Não</button>
                                    <a href="?a=limpar_carrinho" class="btn btn-sm btn-success">Sim</a>        
                            </span>
                        </div>
                        <div class="col text-end">
                            <a href="?a=loja" class="btn btn-sm btn-secondary">Continuar comprando</a>
                            <a href="?a=finalizar_encomenda" class="btn btn-sm btn-success">Finalizar pedido</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>