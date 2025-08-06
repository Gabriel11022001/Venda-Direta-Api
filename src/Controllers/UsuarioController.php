<?php

namespace Controllers;

use Servico\UsuarioServico;

class UsuarioController {

    /**
     * @property UsuarioServico $usuarioServico
     */
    private $usuarioServico;

    public function __construct() {
        $this->usuarioServico = new UsuarioServico();
    }

    public function cadastrar() {
        $this->usuarioServico->cadastrar();
    }

    public function listar() {
        $this->usuarioServico->listar();
    }

    public function buscarPeloId() {
        $this->usuarioServico->buscarPeloId();
    }

}