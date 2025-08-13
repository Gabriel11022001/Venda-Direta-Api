<?php

namespace Repositorio\Interfaces;

interface IProdutoRepositorio extends IRepositorio, IBuscarPeloNomeRepositorio {

    function buscarEntrePrecos($precoInicial, $precoFinal, $paginaAtual, $elementosPorPagina);

    function buscarSomentePossuemUnidadesEstoque($paginaAtual, $elementosPorPagina);

    function buscarPelaCategoria($categoriaId);

}