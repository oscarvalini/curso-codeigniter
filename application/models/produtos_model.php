<?php
class Produtos_model extends CI_Model {

    public function busca($id) {
        // $this->db->where("id", $id); //Essa seria outra forma de aplicar um Where
        // $this->db->get("produtos");
        //get_where é um atalho para as duas chamadas anteriores
        return $this->db->get_where("produtos", array(
            "id" => $id
        ))->row_array(); //row_array é apenas a primeira linha retornada
    }

    public function buscaTodos() {
        //resulta_array retorna um array com todos os resultados da busca
        return $this->db->get("produtos")->result_array();
    }

    public function salva($produto) {
        //insert faz uma inserção no banco de dados
        $this->db->insert("produtos", $produto);
    }

    public function buscaVendidos($usuario) {
        $id = $usuario["id"];
        $this->db->select("produtos.*, vendas.data_de_entrega");
        $this->db->from("produtos");
        $this->db->join("vendas", "vendas.produto_id = produtos.id");
        //No Postgre precisamos usar o true entre aspas para tipos boolean
        $this->db->where("vendido", 'true');
        $this->db->where("usuario_id", $id);
        //Como foi especificado o from e o join, não precisamos colocar nada no get
        return $this->db->get()->result_array();
    }

}