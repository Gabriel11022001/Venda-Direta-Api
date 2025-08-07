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

}