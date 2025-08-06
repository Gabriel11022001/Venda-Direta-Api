<?php

namespace Repositorio;

use Exception;
use Models\Usuario;
use PDO;
use Repositorio\Interfaces\IUsuarioRepositorio;

class UsuarioRepositorio extends Repositorio implements IUsuarioRepositorio {

    /**
     * @param PDO $bancoDados
     */
    public function __construct($bancoDados) {
        parent::__construct($bancoDados);
    }

    /**
     * @param Usuario $usuarioCadastrar
     */
    public function cadastrar($usuarioCadastrar) {
        $query = "INSERT INTO tb_usuarios(nome, email, login, senha, nivel_acesso)
        VALUES(:nome, :email, :login, :senha, :nivel_acesso)";

        $stmt = $this->bancoDados->prepare($query);
        $stmt->bindValue(":nome", $usuarioCadastrar->getNome());
        $stmt->bindValue(":email", $usuarioCadastrar->getEmail());
        $stmt->bindValue(":login", $usuarioCadastrar->getLogin());
        $stmt->bindValue(":senha", $usuarioCadastrar->getSenha());
        $stmt->bindValue(":nivel_acesso", $usuarioCadastrar->getNivelAcesso());

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se cadastrar o usuário na base de dados.");
        }

        $usuarioCadastrar->setUsuarioId($this->bancoDados->lastInsertId());
    }

    /**
     * @param Usuario $usuarioEditar
     */
    public function editar($usuarioEditar) {
        $stmt = $this->bancoDados->prepare("UPDATE tb_usuarios SET email = :email, status = :status,
        nivel_acesso = :nivel_acesso 
        WHERE usuario_id = :usuario_id");

        $stmt->bindValue(":email", $usuarioEditar->getEmail());
        $stmt->bindValue(":status", $usuarioEditar->getStatus(), PDO::PARAM_BOOL);
        $stmt->bindValue(":nivel_acesso", $usuarioEditar->getNivelAcesso());

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se editar o usuário na base de dados.");
        }

    }

    public function deletar($idUsuario) {
        $stmt = $this->bancoDados->prepare("DELETE FROM tb_usuarios WHERE usuario_id = :usuario_id");
        $stmt->bindValue(":usuario_id", $idUsuario);
        
        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se deletar o usuário na base de dados.");
        }

    }

    public function listar() {
        $stmt = $this->bancoDados->prepare("SELECT usuario_id, nome, email, status, nivel_acesso
        FROM tb_usuarios");

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    }

    public function buscarPeloId($idUsuario) {
        $stmt = $this->bancoDados->prepare("SELECT usuario_id, nome, email, status, nivel_acesso
        FROM tb_usuarios
        WHERE usuario_id = :usuario_id");

        $stmt->bindValue(":usuario_id", $idUsuario);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function alterarStatus($idUsuario, $novoStatus) {
        $stmt = $this->bancoDados->prepare("UPDATE tb_usuarios SET status = :novo_status
        WHERE usuario_id = :usuario_id");

        $stmt->bindValue(":novo_status", $novoStatus, PDO::PARAM_BOOL);
        $stmt->bindValue(":usuario_id", $idUsuario);

        if (!$stmt->execute()) {

            throw new Exception("Erro ao tentar-se alterar o status do usuário.");
        }

    }

}