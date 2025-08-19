<?php

namespace Utils;

use Exception;

class EmailInvalidoException extends Exception {

    public function __construct($mensagemErro) {
        parent::__construct($mensagemErro);
    }

}