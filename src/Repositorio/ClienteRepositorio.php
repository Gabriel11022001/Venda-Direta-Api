<?php

namespace Repositorio;

use Exception;
use Models\Cliente;
use Models\Email;
use Models\Endereco;
use Models\Telefone;
use PDO;
use Repositorio\Interfaces\IClienteRepositorio;

class ClienteRepositorio extends Repositorio implements IClienteRepositorio {

    /**
     * @param PDO $bancoDados
     */
    public function __construct($bancoDados) {
        parent::__construct($bancoDados);
    }

    /**
     * @param Cliente $clienteCadastrar
     */
    public function cadastrar($clienteCadastrar) {
        $query = "INSERT INTO tb_clientes(nome, cpf, data_nascimento, status, usuario_id)
        VALUES(:nome, :cpf, :data_nascimento, :status, :usuario_id)";

        $stmt = $this->bancoDados->prepare($query);
        $stmt->bindValue(":nome", $clienteCadastrar->getNomeCompleto(), PDO::PARAM_STR);
        $stmt->bindValue(":cpf", $clienteCadastrar->getCpf(), PDO::PARAM_STR);
        $stmt->bindValue(":data_nascimento", $clienteCadastrar->getDataNascimento(), PDO::PARAM_STR);
        $stmt->bindValue(":status", $clienteCadastrar->getStatus(), PDO::PARAM_BOOL);
        $stmt->bindValue(":usuario_id", $clienteCadastrar->getUsuarioId(), PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se cadastrar o cliente na base de dados.");
        }

        $clienteCadastrar->setClienteId($this->bancoDados->lastInsertId());
    }

    /**
     * @param Cliente $clienteEditar
     */
    public function editar($clienteEditar) {
        
    }

    public function listarPaginado($paginaAtual, $elementosPorPagina) {
        
    }

    public function deletar($id) {
        $stmt = $this->bancoDados->prepare("DELETE FROM tb_clientes WHERE cliente_id = :cliente_id");

        $stmt->bindValue(":cliente_id", $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se deletar o cliente na base de dados.");
        }

    }

    public function buscarPeloId($id) {
        
    }

    public function alterarStatus($idClienteAlterarStatus, $novoStatus) {
        
    }

    public function listarEnderecosCliente($clienteId) {
        
    }

    public function listarEmailsCliente($clienteId) {
        
    }

    public function listarTelefonesCliente($clienteId) {
        
    }

    /**
     * @param Endereco $enderecoCadastrar
     */
    public function cadastrarEnderecoCliente($enderecoCadastrar) {
        $stmt = $this->bancoDados->prepare("INSERT INTO tb_enderecos(cep, complemento, logradouro, cidade, bairro, uf, numero,
        cliente_id) VALUES(:cep, :complemento, :logradouro, :cidade, :bairro, :uf, :numero, :cliente_id)");

        $stmt->bindValue(":cliente_id", $enderecoCadastrar->getClienteId(), PDO::PARAM_INT);
        $stmt->bindValue(":cep", $enderecoCadastrar->getCep(), PDO::PARAM_STR);
        $stmt->bindValue(":logradouro", $enderecoCadastrar->getLogradouro(), PDO::PARAM_STR);
        $stmt->bindValue(":complemento", $enderecoCadastrar->getComplemento(), PDO::PARAM_STR);
        $stmt->bindValue(":cidade", $enderecoCadastrar->getCidade(), PDO::PARAM_STR);
        $stmt->bindValue(":bairro", $enderecoCadastrar->getBairro(), PDO::PARAM_STR);
        $stmt->bindValue(":uf", $enderecoCadastrar->getUf(), PDO::PARAM_STR);
        $stmt->bindValue(":numero", $enderecoCadastrar->getNumero(), PDO::PARAM_STR);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se cadastrar o endereço do cliente.");
        }

        $enderecoCadastrar->setEnderecoId($this->bancoDados->lastInsertId());
    }

    /**
     * @param Email $emailClienteCadastrar
     */
    public function cadastrarEmailCliente($emailClienteCadastrar) {
        $stmt = $this->bancoDados->prepare("INSERT INTO tb_emails(email, cliente_id) VALUES(:email, :cliente_id)");

        $stmt->bindValue(":email", $emailClienteCadastrar->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":cliente_id", $emailClienteCadastrar->getClienteId(), PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se cadastrar o e-mail do cliente.");
        }

        $emailClienteCadastrar->setEmailId($this->bancoDados->lastInsertId());
    }

    /**
     * @param Telefone $telefoneCadastrar
     */
    public function cadastrarTelefoneCliente($telefoneCadastrar) {
        $stmt = $this->bancoDados->prepare("INSERT INTO tb_telefones(telefone, principal, cliente_id)
        VALUES(:telefone, :principal, :cliente_id)");

        $stmt->bindValue(":telefone", $telefoneCadastrar->getTelefone());
        $stmt->bindValue(":principal", $telefoneCadastrar->getPrincipal(), PDO::PARAM_BOOL);
        $stmt->bindValue(":cliente_id", $telefoneCadastrar->getClienteId());

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se cadastrar o telefone na base de dados.");
        }

        $telefoneCadastrar->setTelefoneId($this->bancoDados->lastInsertId());
    }

    /**
     * @param Email $emailClienteEditar
     */
    public function editarEmailCliente($emailClienteEditar) {
        
    }

    /**
     * @param Endereco $enderecoEditar
     */
    public function editarEnderecoCliente($enderecoEditar) {
        
    }

    /**
     * @param Telefone $telefoneEditar
     */
    public function editarTelefoneCliente($telefoneEditar) {
        
    }

    public function deletarEmailCliente($idEmailDeletar) {
        $stmt = $this->bancoDados->prepare("DELETE FROM tb_emails WHERE email_id = :email_id");

        $stmt->bindValue(":email_id", $idEmailDeletar, PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se deletar o e-mail do cliente na base de dados.");
        }

    }

    public function deletarEnderecoCliente($idEnderecoDeletar) {
        $stmt = $this->bancoDados->prepare("DELETE FROM tb_enderecos WHERE endereco_id = :endereco_id");

        $stmt->bindValue(":endereco_id", $idEnderecoDeletar, PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se deletar o endereço do cliente na base de dados.");
        }

    }

    public function deletarTelefoneCliente($idTelefoneDeletar) {
        $stmt = $this->bancoDados->prepare("DELETE FROM tb_telefones WHERE telefone_id = :telefone_id");

        $stmt->bindValue(":telefone_id", $idTelefoneDeletar, PDO::PARAM_INT);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se deletar o telefone do cliente na base de dados.");
        }

    }

    public function buscarPeloCpf($cpf) {
        $stmt = $this->bancoDados->prepare("SELECT c.*, e.endereco_id, e.cep, e.logradouro, e.complemento,
        e.cidade, e.bairro, e.uf, e.numero
        FROM tb_clientes AS c
        INNER JOIN tb_enderecos AS e
        ON c.cliente_id = e.cliente_id
        AND c.cpf = :cpf");
        $stmt->bindValue(":cpf", $cpf, PDO::PARAM_STR);
        $stmt->execute();

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {

            return null;
        }

        // buscar e-mails do cliente
        $stmt = $this->bancoDados->prepare("SELECT * FROM tb_emails WHERE cliente_id = :cliente_id");
        $stmt->bindValue(":cliente_id", $cliente["cliente_id"], PDO::PARAM_INT);
        $stmt->execute();

        $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // buscar telefones do cliente
        $stmt = $this->bancoDados->prepare("SELECT * FROM tb_telefones WHERE cliente_id = :cliente_id");
        $stmt->bindValue(":cliente_id", $cliente["cliente_id"], PDO::PARAM_INT);
        $stmt->execute();

        $telefones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cliente["emails"] = $emails;
        $cliente["telefones"] = $telefones;

        return $cliente;
    }

    public function validarExisteEmailBaseDados($email) {
        $stmt = $this->bancoDados->prepare("SELECT * FROM tb_emails WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}