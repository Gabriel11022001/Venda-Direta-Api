<?php

namespace Models;

class Telefone extends Model {

    private $telefoneId;
    private $telefone;
    private $principal;
    private $clienteId;

    public function __construct() {
        $this->telefoneId = 0;
        $this->telefone = "";
        $this->principal = false;
        $this->clienteId = 0;
    }

    public function setTelefoneId($telefoneId) {
        $this->telefoneId = $telefoneId;
    }

    public function getTelefoneId() {

        return $this->telefoneId;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getTelefone() {

        return $this->telefone;
    }

    public function setPrincipal($principal) {
        $this->principal = $principal;
    }

    public function getPrincipal() {

        return $this->principal;
    }

    public function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    public function getClienteId() {
    
        return $this->clienteId;
    }

    public function toArray() {
        
        return [
            "telefone_id" => $this->getTelefoneId(),
            "telefone" => $this->getTelefone(),
            "principal" => $this->getPrincipal(),
            "cliente_id" => $this->getClienteId()
        ];
    }

}