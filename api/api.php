<?php

use Controllers\CategoriaController;
use Controllers\LoginController;
use Controllers\ProdutoController;
use Controllers\Rota;
use Controllers\UsuarioController;
use Utils\Resposta;

require_once "autoload.php";
require_once __DIR__ . "/configurar.php";
require_once __DIR__ . "/../src/Utils/getParametro.php";

session_start();

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

    // buscar categoria pelo id
    if ($endpoint === "/categorias/consultar") {
        $rota->get("/categorias/consultar", CategoriaController::class, "buscarPeloId");
    }

    // alterar o status da categoria
    if ($endpoint === "/categorias/status/editar") {
        $rota->put("/categorias/status/editar", CategoriaController::class, "alterarStatus");
    }

    // habilitar o perfil do usuário
    if ($endpoint === "/usuarios/perfil/habilitar") {
        $rota->put("/usuarios/perfil/habilitar", UsuarioController::class, "habilitarPerfil");
    }

    // cadastrar produto
    if ($endpoint === "/produtos/cadastrar") {
        $rota->post("/produtos/cadastrar", ProdutoController::class, "cadastrar");
    }

    // listar os produtos de forma paginada
    if  ($endpoint === "/produtos/listar") {
        $rota->get("/produtos/listar", ProdutoController::class, "listar");
    }

    // deletar categoria de produto
    if ($endpoint === "/categorias/deletar") {
        $rota->delete("/categorias/deletar", CategoriaController::class, "deletar");
    }

    Resposta::response(false, "404 - Rota inválida.");
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "<br>";
}