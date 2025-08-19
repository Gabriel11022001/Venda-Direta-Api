<?php

namespace Models;

class Endereco extends Model {

    private $enderecoId;
    private $cep;
    private $complemento;
    private $logradouro;
    private $cidade;
    private $bairro;
    private $uf;
    private $numero;
    private $clienteId;

    public function __construct() {
        $this->enderecoId = 0;
        $this->clienteId = 0;
        $this->cep = "";
        $this->logradouro = "";
        $this->complemento = "";
        $this->cidade = "";
        $this->bairro = "";
        $this->uf = "";
        $this->numero = "";
    }

    public function setEnderecoId($enderecoId) {
        $this->enderecoId = $enderecoId;
    }

    public function getEnderecoId() {

        return $this->enderecoId;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function getCep() {

        return $this->cep;
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function getLogradouro() {

        return $this->logradouro;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function getComplemento() {

        return $this->complemento;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function getCidade() {

        return $this->cidade;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function getBairro() {

        return $this->bairro;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }

    public function getUf() {

        return $this->uf;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
    public function getNumero() {

        return $this->numero;
    }

    public function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    public function getClienteId() {

        return $this->clienteId;
    }

    public function toArray() {
        
        return [
            "endereco_id" => $this->getEnderecoId(),
            "cep" => $this->getCep(),
            "logradouro" => $this->getLogradouro(),
            "complemento" => $this->getComplemento(),
            "cidade" => $this->getCidade(),
            "bairro" => $this->getBairro(),
            "uf" => $this->getUf(),
            "numero" => $this->getNumero()
        ];
    }

}