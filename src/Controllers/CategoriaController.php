<?php

namespace Controllers;

use Servico\CategoriaServico;

class CategoriaController {
    
    /**
     * @property CategoriaServico $categoriaServico
     */
    private $categoriaServico;

    public function __construct() {
        $this->categoriaServico = new CategoriaServico();
    }

    public function cadastrar() {
        $this->categoriaServico->cadastrar();
    }

    public function editar() {
        $this->categoriaServico->editar();
    }

    public function buscarPeloId() {
        $this->categoriaServico->buscarPeloId();
    }

    public function alterarStatus() {
        $this->categoriaServico->alterarStatus();
    }

}