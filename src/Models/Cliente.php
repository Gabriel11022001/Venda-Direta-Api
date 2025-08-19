<?php

namespace Models;

class Cliente extends Model {

    private $clienteId;
    private $nomeCompleto;
    private $cpf;
    private $dataNascimento;
    private $status;
    private $usuarioId;
    /**
     * @property Endereco $endereco
     */
    private $endereco;
    /**
     * @property array $emails
     */
    private $emails;
    /**
     * @property array $telefones
     */
    private $telefones;

    public function __construct() {
        $this->clienteId = 0;
        $this->nomeCompleto = "";
        $this->cpf = "";
        $this->dataNascimento = "";
        $this->status = true;
        $this->endereco = null;
        $this->emails = [];
        $this->telefones = [];
    }

    public function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    public function getClienteId() {

        return $this->clienteId;
    }

    public function setNomeCompleto($nomeCompleto) {
        $this->nomeCompleto = $nomeCompleto;
    }

    public function getNomeCompleto() {

        return $this->nomeCompleto;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getCpf() {

        return $this->cpf;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    public function getDataNascimento() {

        return $this->dataNascimento;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {

        return $this->status;
    }

    /**
     * @param Endereco $endereco
     */
    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    /**
     * @return Endereco
     */
    public function getEndereco() {

        return $this->endereco;
    }

    public function setEmails($emails) {
        $this->emails = $emails;
    }

    public function getEmails() {
        
        return $this->emails;
    }

    public function setTelefones($telefones) {
        $this->telefones = $telefones;
    }

    public function getTelefones() {

        return $this->telefones;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function getUsuarioId() {

        return $this->usuarioId;
    }

    public function toArray() {
        
        return [
            "cliente_id" => $this->getClienteId(),
            "nome" => $this->getNomeCompleto(),
            "cpf" => $this->getCpf(),
            "data_nascimento" => $this->getDataNascimento(),
            "status" => $this->getStatus(),
            "usuario_id" => $this->getUsuarioId(),
            "emails" => $this->getEmails(),
            "telefones" => $this->getTelefones(),
            "endereco" => $this->getEndereco()->toArray()
        ];
    }

}