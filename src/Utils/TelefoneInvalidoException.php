<?php

namespace Utils;

use Exception;

class TelefoneInvalidoException extends Exception {

    public function __construct($mensagemErro) {
        parent::__construct($mensagemErro);
    }

}