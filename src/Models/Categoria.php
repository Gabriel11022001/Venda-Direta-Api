<?php

namespace Models;

class Categoria extends Model {

    private $categoriaId;
    private $nome;
    private $status;

    public function __construct() {
        $this->categoriaId = 0;
        $this->nome        = "";
        $this->status      = true;
    }

    public function setCategoriaId($categoriaId) {
        $this->categoriaId = $categoriaId;
    }

    public function getCategoriaId() {

        return $this->categoriaId;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {

        return $this->nome;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {

        return $this->status;
    }

    public function toArray() {
        
        return [
            "categoria_id" => $this->getCategoriaId(),
            "nome" => $this->getNome(),
            "status" => $this->getStatus() ? "Ativo" : "Inativo"
        ];
    }

}