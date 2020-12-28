<?php if (! defined('BASEPATH')) exit('No Direct script access allowed');

class Vendas extends CI_Controller {
    public function nova() {

        //Verifica o usuário logado
        $usuario = autoriza();

        //Carrega o modelo
        $this->load->model(array("vendas_model", "produtos_model", "usuarios_model"));
        $this->load->helper("date_helper");
        //carrega os dados da venda no array
        $venda = array(
            'produto_id' => $this->input->post('produto_id'),
            'comprador_id' => $usuario['id'],
            'data_de_entrega' => dataPtBrParaMysql($this->input->post('data_de_entrega'))
        );
        //salva a venda no banco de dados
        $this->vendas_model->salva($venda);

        $this->load->library("email");
        $config['protocol']  = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_user'] = 'mercadoalura@gmail.com';
        $config['smtp_pass'] = 'Abc@1234';
        $config['smtp_port'] = 465;
        $config['charset']   = 'utf-8';
        $config['mailtype']  = 'html';
        $config['newline']   = "\r\n"; 
        $this->email->initialize($config);

        $produto = $this->produtos_model->busca($venda["produto_id"]);
        //$vendedor = $this->usuarios_model->busca($produto["usuario_id"]);

        $dados = array("produto" => $produto);
        //Passamos o TRUE para que a view não seja renderizada e sim devolvida
        $conteudo = $this->load->view("vendas/email.php", $dados, TRUE);

        $this->email->from("codeigniteralura@gmail.com", "Mercado");
        $this->email->to(array($usuario['email']));
        $this->email->subject("Seu Produto {$produto['nome']} foi vendido");
        $this->email->message($conteudo);
        $this->email->send();

        //mensagem para a próxima tela
        $this->session->set_flashdata("success", "Pedido de compra efetudado com sucesso.");
        //redireciona para a página inicial
        redirect('/');
    }

    public function index() {

        $usuario = autoriza();
        $this->load->model("produtos_model");
        $this->load->helper("date_helper"); //Pode adicionar no autoload.php
        $produtosVendidos = $this->produtos_model->buscaVendidos($usuario);
        $dados = array("produtosVendidos" => $produtosVendidos);

        $this->load->view("cabecalho.php");
        $this->load->view("vendas/index", $dados);
        $this->load->view("rodape.php");
        
    }
}