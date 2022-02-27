<div class="container">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3">
            <h3 class="text-center">Registro de Novo Cliente</h3>

            <form action="?a=criar_cliente" method="post">

                <div class="my-3">
                    <label>Email</label>
                    <input type="email" name="text_email" class="form-control" placeholder="Email" required />
                </div>

                <div class="my-3">
                    <label>Senha</label>
                    <input type="password" name="text_senha_1" class="form-control" placeholder="Senha" required />
                </div>
                
                <div class="my-3">
                    <label>Repetir a Senha</label>
                    <input type="password" name="text_senha_2" class="form-control" placeholder="Repetir a Senha" required />
                </div>

                <div class="my-3">
                    <label>Nome completo</label>
                    <input type="text" name="text_nome_completo" class="form-control" placeholder="Nome completo" required />
                </div>

                <div class="my-3">
                    <label>Morada</label>
                    <input type="text" name="text_morada" class="form-control" placeholder="Morada" required />
                </div>

                <div class="my-3">
                    <label>Cidade</label>
                    <input type="text" name="text_cidade" class="form-control" placeholder="Cidade" required />
                </div>

                <div class="my-3">
                    <label>Telefone</label>
                    <input type="text" name="text_telefone" class="form-control" placeholder="Telefone"/>
                </div>

                <div class="my-4">
                    <input type="submit" value="Criar conta" class="btn btn-primary" />
                </div>

                <?php if(isset($_SESSION['erro'])) : ?> 
                    <div class="alert alert-danger text-center p-2">
                        <?= $_SESSION['erro'] ?>
                        <?php unset($_SESSION['erro']) ?>
                    </div>
                <?php endif;?>

            </form>


        </div>
    </div>
</div>
