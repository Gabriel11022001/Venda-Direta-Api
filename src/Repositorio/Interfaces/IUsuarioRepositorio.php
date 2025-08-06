<?php

namespace Repositorio\Interfaces;

interface IUsuarioRepositorio {

    function cadastrar($usuarioCadastrar);

    function editar($usuarioEditar);

    function listar();

    function deletar($idUsuario);

    function alterarStatus($idUsuario, $novoStatus);

    function buscarPeloId($idUsuario);

}