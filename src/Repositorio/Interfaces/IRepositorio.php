<?php

namespace Repositorio\Interfaces;

interface IRepositorio {

    function cadastrar($modelCadastrar);

    function editar($modelEditar);

    function deletar($id);

    function listarPaginado($paginaAtual, $elementosPorPagina);

    function buscarPeloId($id);

}