<?php

namespace Servico;

use Exception;
use Models\Cliente;
use Models\Email;
use Models\Endereco;
use Models\Telefone;
use Repositorio\ClienteRepositorio;
use Repositorio\Interfaces\IClienteRepositorio;
use Repositorio\Interfaces\IUsuarioRepositorio;
use Repositorio\UsuarioRepositorio;
use Utils\EmailInvalidoException;
use Utils\Funcoes;
use Utils\Log;
use Utils\Resposta;
use Utils\TelefoneInvalidoException;

class ClienteServico extends ServicoBase {

    /**
     * @property IClienteRepositorio $clienteRepositorio
     */
    private $clienteRepositorio;
    /**
     * @property IUsuarioRepositorio $usuarioRepositorio
     */
    private $usuarioRepositorio;

    public function __construct() {
        parent::__construct();

        $this->clienteRepositorio = new ClienteRepositorio($this->bancoDados);
        $this->usuarioRepositorio = new UsuarioRepositorio($this->bancoDados);
    }

    public function cadastrar() {
        
        $this->bancoDados->beginTransaction();

        try {
            $nome = getParametro("nome");
            $cpf = getParametro("cpf");
            $dataNascimento = getParametro("data_nascimento");
            $status = getParametro("status");
            $usuarioId = getParametro("usuario_id");
            $emails = getParametro("emails");
            $telefones = getParametro("telefones");
            $endereco = getParametro("endereco");

            $errosCampos = Funcoes::validarCamposCadastroCliente([
                "nome" => $nome,
                "cpf" => $cpf,
                "data_nascimento" => $dataNascimento,
                "usuario_id" => $usuarioId,
                "emails" => $emails,
                "telefones" => $telefones,
                "endereco" => $endereco
            ]);

            if ($errosCampos) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            // validar se já existe outro cliente cadastrado com o mesmo cpf
            if ($this->clienteRepositorio->buscarPeloCpf($cpf)) {
                Resposta::response(false, "Já existe outro cliente cadastrado com o cpf informado.");
            }

            // validar se existe um usuário cadastrado com o id informado
            if (!$this->usuarioRepositorio->buscarPeloId($usuarioId)) {
                Resposta::response(false, "Não existe um usuário cadastrado com o id informado.");
            }

            // validar duplicidade de e-mails
            foreach ($emails as $email) {
                
                if ($this->clienteRepositorio->validarExisteEmailBaseDados($email->email)) {
                    Resposta::response(false, "Já existe outro e-mail como o informado na base de dados.");
                }

            }

            $clienteCadastrar = new Cliente();
            $clienteCadastrar->setNomeCompleto($nome);
            $clienteCadastrar->setCpf($cpf);
            $clienteCadastrar->setDataNascimento($dataNascimento);
            $clienteCadastrar->setStatus($status);
            $clienteCadastrar->setUsuarioId($usuarioId);

            $this->clienteRepositorio->cadastrar($clienteCadastrar);

            $enderecoCliente = new Endereco();
            $enderecoCliente->setCep($endereco->cep);
            $enderecoCliente->setComplemento($endereco->complemento);
            $enderecoCliente->setLogradouro($endereco->logradouro);
            $enderecoCliente->setCidade($endereco->cidade);
            $enderecoCliente->setBairro($endereco->bairro);
            $enderecoCliente->setUf($endereco->uf);
            $enderecoCliente->setNumero($endereco->numero);
            $enderecoCliente->setClienteId($clienteCadastrar->getClienteId());

            // cadastrar o endereço do cliente
            $this->clienteRepositorio->cadastrarEnderecoCliente($enderecoCliente);

            $clienteCadastrar->setEndereco($enderecoCliente);

            $emailsCliente = array();

            // cadastrar os e-mails do cliente
            foreach ($emails as $emailArray) {
                $email = new Email();

                $email->setClienteId($clienteCadastrar->getClienteId());
                $email->setEmail($emailArray->email);

                $this->clienteRepositorio->cadastrarEmailCliente($email);

                $emailsCliente[] = $email->toArray();
            }

            $clienteCadastrar->setEmails($emailsCliente);

            $telefonesCliente = array();

            // cadastrar os telefones do cliente
            foreach ($telefones as $telefoneArray) {
                $telefone = new Telefone();

                $telefone->setClienteId($clienteCadastrar->getClienteId());
                $telefone->setTelefone($telefoneArray->telefone);
                $telefone->setPrincipal($telefoneArray->principal);

                $this->clienteRepositorio->cadastrarTelefoneCliente($telefone);

                $telefonesCliente[] = $telefone->toArray();
            }

            $clienteCadastrar->setTelefones($telefonesCliente);

            $this->bancoDados->commit();

            Resposta::response(true, "Cliente cadastrado com sucesso.", $clienteCadastrar->toArray());
        } catch (EmailInvalidoException $e) {
            $this->bancoDados->rollBack();

            Log::erro($e->getMessage());

            Resposta::response(false, $e->getMessage());
        } catch (TelefoneInvalidoException $e) {
            $this->bancoDados->rollBack();

            Log::erro($e->getMessage());
            
            Resposta::response(false, $e->getMessage());
        } catch (Exception $e) {
            $this->bancoDados->rollBack();
            Log::erro("Erro ao tentar-se cadastrar o cliente na base de dados: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se cadastrar o cliente na base de dados.");
        }

    }

    public function listar() {

        try {
            $paginaAtual = getParametro("pagina_atual");
            $elementoPorPagina = getParametro("elementos_por_pagina");
            $usuarioId = getParametro("usuario_id");

            if (empty($paginaAtual) || empty($elementoPorPagina) || empty($usuarioId)) {
                Resposta::response(false, "Informe a página atual, a quantidade de elementos por página e o id do usuário na url.");
            }

            if ($paginaAtual <= 0) {
                $paginaAtual = 1;
            }

            if ($elementoPorPagina != 5 && $elementoPorPagina != 10 && $elementoPorPagina != 15) {
                $elementoPorPagina = 5;
            }

            if (empty($this->usuarioRepositorio->buscarPeloId($usuarioId))) {
                Resposta::response(false, "Não existe um usuário na base de dados com o id informado.", null);
            }

            $clientes = $this->clienteRepositorio->listarClientesUsuario($paginaAtual, $elementoPorPagina, $usuarioId);

            if (empty($clientes)) {
                Resposta::response(true, "Não foram encontrados clientes na base de dados.", array());
            }

            Resposta::response(true, "Clientes listados com sucesso.", $clientes);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se listar os clientes: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se listar os clientes.");
        }

    }

}