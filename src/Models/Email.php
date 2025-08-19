<?php

namespace Models;

class Email extends Model {

    private $emailId;
    private $email;
    private $clienteId;

    public function __construct() {
        $this->emailId = 0;
        $this->clienteId = 0;
        $this->email = "";
    }

    public function setEmailId($emailId) {
        $this->emailId = $emailId;
    }

    public function getEmailId() {

        return $this->emailId;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {

        return $this->email;
    }

    public function setClienteId($clienteId) {
        $this->clienteId = $clienteId;
    }

    public function getClienteId() {

        return $this->clienteId;
    }

    public function toArray() {
        
        return [
            "email_id" => $this->getEmailId(),
            "email" => $this->getEmail(),
            "cliente_id" => $this->getClienteId()
        ];
    }

}