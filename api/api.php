<?php

use Controllers\CategoriaController;
use Controllers\LoginController;
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

    // deletar usuário
    if ($endpoint === "/usuarios/deletar") {
        $rota->delete("/usuarios/deletar", UsuarioController::class, "deletar");
    }

    // login
    if ($endpoint === "/login") {
        $rota->post("/login", LoginController::class, "login");
    }

    // cadastrar categoria
    if ($endpoint === "/categorias/cadastrar") {
        $rota->post("/categorias/cadastrar", CategoriaController::class, "cadastrar");
    }

    // editar categoria
    if ($endpoint === "/categorias/editar") {
        $rota->put("/categorias/editar", CategoriaController::class, "editar");
    }

    Resposta::response(false, "404 - Rota inválida.");
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "<br>";
}