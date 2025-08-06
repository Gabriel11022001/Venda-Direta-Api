<?php

use Controllers\Rota;
use Controllers\UsuarioController;
use Utils\Resposta;

require_once "autoload.php";
require_once __DIR__ . "/configurar.php";
require_once __DIR__ . "/../src/Utils/getParametro.php";

try {   
    $rota = new Rota();
    $endpoint = $rota->getRotaAtual();

    // cadastrar usuário
    if ($endpoint === "/usuarios/cadastrar") {
        $rota->post("/usuarios/cadastrar", UsuarioController::class, "cadastrar");
    }

    // listar usuários
    if ($endpoint === "/usuarios/listar") {
        $rota->get("/usuarios/listar", UsuarioController::class, "listar");
    }

    // buscar usuário pelo id
    if ($endpoint === "/usuarios/consultar") {
        $rota->get("/usuarios/consultar", UsuarioController::class, "buscarPeloId");
    }

    Resposta::response(false, "404 - Rota inválida.");
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "<br>";
}