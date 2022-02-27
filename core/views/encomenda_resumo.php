<div class="container">
    <div class="row">
        <div class="col text-center">
            <hr>
            <h4 class="my-3 text-center">Verifica seu pedido, Por favor.</h4>
            <hr>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <div>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor total</th>
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
                                    <td class="align-middle"><?= $produto['titulo'] ?></td>
                                    <td class="align-middle"><?= $produto['quantidade'] ?></td>
                                    <td class="align-middle">R$ <?= number_format($produto['preco'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php else : ?>
                                <!-- total de preço -->
                                <tr>
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

                <h5 class="bg-dark text-white text-center p-2">Dados Cliente</h5>

                <div class="row mt-4">
                    <div class="col">
                        <p>Nome: <strong><?= $cliente->nome_completo ?></strong></p>
                        <p>Endereço Completo: <strong><?= $cliente->morada ?></strong></p>
                        <p>Cidade: <strong><?= $cliente->cidade ?></strong></p>
                    </div>

                    <div class="col">
                        <p>Telefone: <strong><?= $cliente->telefone ?></strong></p>
                        <p>E-mail: <strong><?= $cliente->email ?></strong></p>
                    </div>
                </div>

                <div class="form-check">
                    <input class="form-check-input" onchange="mudar_endereco()" type="checkbox" name="check_alterar_endereco" id="check_alterar_endereco">
                    <label class="form-check-label" for="alterar_endereco">Definir outro endereço</label>
                </div>

                <div id="alterar_endereco" style="display: none">
                    
                    <div class="mb-3">
                         <label class="form-label">Endereço</label>
                         <input class="form-control" type="text" id="text_mudar_morada">       
                    </div>

                    <div class="mb-3">
                         <label class="form-label">Cidade</label>
                         <input class="form-control" type="text" id="text_mudar_cidade">       
                    </div>

                    <div class="mb-3">
                         <label class="form-label">Email</label>
                         <input class="form-control" type="email" id="text_mudar_email">       
                    </div>


                    <div class="mb-3">
                         <label class="form-label">Telefone</label>
                         <input class="form-control" type="text" id="text_mudar_telefone">       
                    </div>
                
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <a href="?a=carrinho" class="btn btn-danger">cancelar</a>
                    </div>
                    <div class="col text-end">
                        <a href="?a=escolher_metodo_pagamento" onclick="endereco_alternativo()" class="btn btn-primary">Escolher o método de pagamento</a>
                    </div>
                </div>
                <div>
                    <br><br><br><br>
                </div>
            </div>

        </div>
    </div>
</div>