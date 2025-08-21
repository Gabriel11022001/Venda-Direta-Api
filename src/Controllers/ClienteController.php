<?php

namespace Controllers;

use Servico\ClienteServico;

class ClienteController {

    /**
     * @property ClienteServico $clienteServico
     */
    private $clienteServico;

    public function __construct() {
        $this->clienteServico = new ClienteServico();
    }

    public function cadastrar() {
        $this->clienteServico->cadastrar();
    }

    public function listar() {
        $this->clienteServico->listar();
    }

}