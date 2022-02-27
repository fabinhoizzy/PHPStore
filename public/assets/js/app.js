

function adicionar_carrinho(id_produto) {

    //adicionar produtos ao carrinho
    axios.default.withCredentials = true;
    axios.get('?a=adicionar_carrinho&id_produto=' + id_produto)
        .then(function (response) {

            var total_produtos = response.data;
            document.getElementById('carrinho').innerText = total_produtos;
        });

}

function limpar_carrinho() {

    var e = document.getElementById("confirmar_limpar_carrinho");
    e.style.display = "inline";
}

function limpar_carrinho_off() {
    var e = document.getElementById("confirmar_limpar_carrinho");
    e.style.display = "none";
}

function mudar_endereco() {
    // mostrar o quadro para definir morada alternativa
    var e = document.getElementById('check_alterar_endereco');
    if(e.checked == true) {
        
        //mostra o layout para alterar endereço alternativo
        document.getElementById("alterar_endereco").style.display = 'block';

    } else {
        
        //esconde o loyout para alterar endereço alternativo
        document.getElementById("alterar_endereco").style.display = 'none';
    }
    
}

function endereco_alternativo() {

    axios({
        method: 'post',
        url: '?a=endereco_alternativo',
        data: {
            text_morada: document.getElementById('text_mudar_morada').value,
            text_cidade: document.getElementById('text_mudar_cidade').value,
            text_email: document.getElementById('text_mudar_email').value,
            text_telefone: document.getElementById('text_mudar_telefone').value,
        }   
    })
    .then(function(response){
        console.log('ok')
    });

}
