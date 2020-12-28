    
    <!-- <?= validation_errors("<p class='alert alert-danger'>", "</p>") ?> -->
    <h1>Cadastro de Produtos</h1>
    <?php
    // Inicia um formulário e define o caminho do controlador que será chamado ao enviar
    // Um submit. No caso produtos/novo.
    echo form_open("produtos/novo");

    //form_label associa um label com um input
    echo form_label("Nome", "nome");
    echo form_input(array(
        "name" => "nome",
        "class" => "form-control",
        "id" => "nome",
        "maxlength" => 255,
        //Faz com que o campo permaneça preenchido com o último valor, mesmo quando 
        //houver um erro de validação do formulário e ele for recarregado.
        "value" => set_value("nome", "")
    ));
    //mensagem de erro que aparecerá caso haja algum. 
    echo form_error("nome");

    echo form_label("Preço", "preco");
    echo form_input(array(
        "name" => "preco",
        "class" => "form-control",
        "id" => "preco",
        "maxlength" => 255,
        "type" => "number",
        "value" => set_value("preco", 0)
    ));
    echo form_error("preco");

    echo form_textarea(array(
        "name" => "descricao",
        "class" => "form-control",
        "id" => "descricao",
        "value" => set_value("descricao", "")
    ));
    echo form_error("descricao");

    echo form_button(array(
        "class" => "btn btn-primary",
        "content" => "Cadastrar",
        "type" => "submit"
    ));

    //fecha formulário
    echo form_close();

    ?>