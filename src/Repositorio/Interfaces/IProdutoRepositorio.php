<?php

namespace Repositorio\Interfaces;

interface IProdutoRepositorio extends IRepositorio {

    function buscarEntrePrecos($precoInicial, $precoFinal, $paginaAtual, $elementosPorPagina);

    function buscarSomentePossuemUnidadesEstoque($paginaAtual, $elementosPorPagina);

}