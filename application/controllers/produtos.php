<?php if (! defined('BASEPATH')) exit('No Direct script access allowed');

    class Produtos extends CI_Controller {

        public function index() {

            //profiler mostra dados da execução do sistema
            //$this->output->enable_profiler(TRUE);

            //Carrega um helper que tem a função auto typography, responsável por converter newlines e quebras html
            $this->load->helper("typography");
            //carrega a classe do modelo de produtos
            $this->load->model("produtos_model");

            //Acessa uma função do modelo
            $produtos = $this->produtos_model->buscaTodos();

            //define dados como um array associativo 
            $dados = array("produtos" => $produtos);
            //Carrega o helper currency que contém uma função que ajuda a exibir valores em formato monetário brasileiro
            //currency está localizado na pasta helper
            $this->load->helper(array("currency"));
            //carrega a view e envia os dados para a view
            $this->load->view("cabecalho.php");
            $this->load->view("produtos/index.php", $dados);
            $this->load->view("rodape.php");
        }

        //Carrega a view de formulário
        public function formulario() {
            autoriza();
            $this->load->view("cabecalho.php");
            $this->load->view("produtos/formulario");
            $this->load->view("rodape.php");
        }

        //Cria um novo produto
        public function novo() {

            $usuarioLogado = autoriza();
            //carrega a biblioteca de validação de formulário
            $this->load->library("form_validation");

            //Define os parâmetros de validação do nome. 
            //required -> obrigatório   | min_length[num] -> tamanho minimo | trim -> elimita espaços em branco
            //e impede que os espaços em branco sejam utilizados na contagem de caracteres minima
            //Define uma função de callback que aplica uma regra de validação personalizada 
            $this->form_validation->set_rules("nome", "nome", "required|min_length[5]|callback_nao_tenha_a_palavra_melhor");
            $this->form_validation->set_rules("preco", "preco", "required");
            $this->form_validation->set_rules("descricao", "descricao", "trim|required|min_length[10]");
            //define quais serãos as tags html que vão embrulhar a mensagem de validação.
            //No caso um paragrafo com classes bootstrap
            $this->form_validation->set_error_delimiters("<p class='alert, alert-danger'>", "</p>");

            //Faz a validação segundo os critérios definidos pelo set_rules e retorna o resultado
            $sucesso = $this->form_validation->run();

            //Se sucesso não for null
            if($sucesso) { 
                //verifica se o usuário está logado
                //$usuarioLogado = $this->session->userdata("usuario_logado");

                //define o produto com um array com os dados que foram enviados por formulário
                $produto = array(
                    "nome" => $this->input->post("nome"),
                    "descricao" => $this->input->post("descricao"),
                    "preco" => $this->input->post("preco"),
                    "usuario_id" => $usuarioLogado["id"]
                );

                //carrega o modelo de produtos
                $this->load->model("produtos_model");
                //salva o novo produto utilizando função do modelo
                $this->produtos_model->salva($produto);
                //Define um flashdata com uma mensagem de sucesso que será exibida após a página ser redirecionada
                $this->session->set_flashdata("success", "Produto salvo com sucesso");
                //redireciona para a raiz ou index;
                redirect("/");
            } else {
                //Caso a validação falhe volta para o formulário
                $this->load->view("produtos/formulario");
            }
        }

        //mostra os detalhes do produto selecionado
        public function mostra($id) {
            $this->load->model("produtos_model");
            $produto = $this->produtos_model->busca($id);
            $dados = array("produto" => $produto);
            //typography troca os newlines por quebra de linha html
            $this->load->helper("typography");
            //carrega view e envia dados
            $this->load->view("cabecalho.php");
            $this->load->view("produtos/mostra", $dados);
            $this->load->view("rodape.php");
        }

        //Função personalizada que verifica se o campo nome tem a palavra 'melhor'
        public function nao_tenha_a_palavra_melhor($nome) {
            //strpos verifica a posição em que a palavra "melhor" está presente. Se não houver retorna FALSE
            $posicao = strpos($nome, "melhor");

            
            if($posicao == FALSE) {
                return TRUE;
            }
            else {
                //Se tiver a palavra melhor, define uma mensagem de erro de validação e retorna FALSE.
                $this->form_validation->set_message("nao_tenha_a_palavra_melhor", 
                 "O campo '%s' não pode conter a palavra 'melhor'");
                return FALSE;
            }
        }
    }

?>
