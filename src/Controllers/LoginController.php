<?php

namespace Controllers;

use Servico\LoginServico;

class LoginController {

    /**
     * @property LoginServico $loginServico
     */
    private $loginServico;

    public function __construct() {
        $this->loginServico = new LoginServico();
    }

    public function login() {
        $this->loginServico->login();
    }

}