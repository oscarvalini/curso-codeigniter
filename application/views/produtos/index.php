    <h1> Produtos </h1>
    <!-- Class table no bootstrap tem uma configuração melhor para exibição de tabelas -->
    <table class="table">
        <!-- foreach - Lembrar de colocar o ':' -->
        <?php foreach($produtos as $produto) : ?>
            <tr>
                <td>
                    <!-- Cria um link para uma outra página e utiliza html_escape para que não seja possível executar
                    código html não autorizado -->
                    <?= anchor("produtos/{$produto['id']}", html_escape($produto['nome'])) ?>
                </td>
                <!-- Define 80 como o numero máximo de caracteres e impede execução de código html -->
                <td><?= character_limiter(html_escape($produto['descricao']), 80)?></td>
                <!-- numeroEmReais é uma função personalizada que mostra o valor em formato de moeda brasileira -->
                <td><?= numeroEmReais($produto['preco']) ?></td>
            </tr>
        <?php endforeach ?>
    </table>

    <!-- verifica se a sessao contem em userdata a chave usuario_logado. Na prática está verificando 
    se o usuario está logado -->
    <?php if($this->session->userdata("usuario_logado")) : ?>
        <!-- Se estiver logado exibe os links para os controladores de formulario de produtos e logout -->
        <?= anchor('produtos/formulario', 'Novo Produto', array("class" => "btn btn-primary")) ?>
        <?= anchor('login/logout', 'Logout', array("class" => "btn btn-primary")) ?>
    <!-- Se o usuário não estiver logado:  -->
    <?php else : ?>
     <!--Exibe formulário de login e de Cadastro  -->
    <h1>Login</h1>
    <?php
    // Abre o formulário e define o controlador
    echo form_open("login/autenticar");
    echo form_label("Email", "email");
    echo form_input(array(
        "name" => "email",
        "id" => "email",
        "class" => "form-control",
        "maxlength" => "255"
    ));

    echo form_label("Senha", "senha");
    echo form_password(array(
        "name" => "senha",
        "id" => "senha",
        "class" => "form-control",
        "maxlength" => "255"
    ));
    echo form_button(array(
        "class" => "btn btn-primary",
        "content" => "Login",
        "type" => "submit"
    ));
    echo form_close();
    ?>

    <h1>Cadastro</h1>
    <?php
    // Abre outro formulário e define o controlador.
    echo form_open("usuarios/novo");
    echo form_label("Nome", "nome");
    echo form_input(array(
        "name" => "nome",
        "id" => "nome",
        "class" => "form-control",
        "maxlength" => "255"
    ));

    echo form_label("Email", "email");
    echo form_input(array(
        "name" => "email",
        "id" => "email",
        "class" => "form-control",
        "maxlength" => "255"
    ));

    echo form_label("Senha", "senha");
    echo form_password(array(
        "name" => "senha",
        "id" => "senha",
        "class" => "form-control",
        "maxlength" => "255"
    ));

    echo form_button(array(
        // btn e btn-primary são classes do bootstrap para botões
        "class" => "btn btn-primary",
        "content" => "cadastrar",
        "type" => "submit"
    ));

    echo form_close();
    ?>

    <?php endif ?>
