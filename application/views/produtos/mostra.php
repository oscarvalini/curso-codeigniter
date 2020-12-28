    <!-- html escape impede que o html seja interpretado -->
    <h1><?= html_escape($produto["nome"]) ?></h1> 
    <?= $produto["preco"] ?><br>
    <!-- auto_typography faz as quebras de linhada textarea serem respeitadas -->
    <?= auto_typography(html_escape($produto["descricao"])) ?>

    <h2>Compre agora mesmo</h2>
    <?php
    echo form_open("vendas/nova");

    echo form_hidden('produto_id', $produto['id']);

    echo form_label("Data de entrega", 'data_de_entrega');
    echo form_input(array(
        'name' => 'data_de_entrega',
        'class' => 'form-control',
        'id' => 'data_de_entrega',
        'maxlength' => '255',
        'value' => ''
    ));

    echo form_button(array(
        'class' => 'btn btn-primary',
        'content' => 'Comprar',
        'type' => 'submit'
    ));

    echo form_close();

    ?>