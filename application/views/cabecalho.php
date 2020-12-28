<html lang="pt-BR">

<head>
    <link rel="stylesheet" href="<?= base_url("css/bootstrap.css")?>">
</head>

<body>

<div class="container">

    <!-- verifica se a chave "success" está definida em flashdata -->
    <!-- Obs.: Não esquecer de colocar o ':' precisar encerrar o php em outra tag -->
    <?php if($this->session->flashdata("success")) : ?>
        <!-- Se sim, mostra um alerta com o valor armazenado pela chave -->
        <p class="alert alert-success"><?= $this->session->flashdata("success") ?></p>
        <!-- Encerra o if -->
    <?php endif ?>
    <!-- verifica se a chave "danger" está definida em flashdata -->
    <?php if($this->session->flashdata("danger")) : ?>
        <p class="alert alert-danger"><?= $this->session->flashdata("danger") ?></p>
    <?php endif ?>
