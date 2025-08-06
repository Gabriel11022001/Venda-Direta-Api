<?php

namespace Models;

class Usuario extends Model {

    private $usuarioId;
    private $nome;
    private $email;
    private $login;
    private $senha;
    private $status;
    private $nivelAcesso;

    public function __construct() {
        $this->usuarioId = 0;
        $this->nome = "";
        $this->email = "";
        $this->login = "";
        $this->senha = "";
        $this->nivelAcesso = "";
        $this->status = true;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function getUsuarioId() {

        return $this->usuarioId;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getNome() {

        return $this->nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {

        return $this->email;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getLogin() {

        return $this->login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getSenha() {

        return $this->senha;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {

        return $this->status;
    }

    public function setNivelAcesso($nivelAcesso) {
        $this->nivelAcesso = $nivelAcesso;
    }

    public function getNivelAcesso() {

        return $this->nivelAcesso;
    }

    public function toArray() {
        
    }

}