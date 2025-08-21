<?php

namespace Repositorio\Interfaces;

interface IClienteRepositorio extends IRepositorio {

    function listarEnderecosCliente($clienteId);

    function listarEmailsCliente($clienteId);

    function listarTelefonesCliente($clienteId);

    function cadastrarEnderecoCliente($enderecoCadastrar);

    function editarEnderecoCliente($enderecoEditar);

    function deletarEnderecoCliente($idEnderecoDeletar);

    function cadastrarEmailCliente($emailClienteCadastrar);

    function editarEmailCliente($emailClienteEditar);

    function deletarEmailCliente($idEmailDeletar);

    function cadastrarTelefoneCliente($telefoneCadastrar);

    function editarTelefoneCliente($telefoneEditar);

    function deletarTelefoneCliente($idTelefoneDeletar);

    function alterarStatus($idClienteAlterarStatus, $novoStatus);

    function buscarPeloCpf($cpf);

    function validarExisteEmailBaseDados($email);

    function listarClientesUsuario($paginaAtual, $elementosPorPagina, $usuarioId);

}