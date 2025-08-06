<?php

namespace Servico;

use Exception;
use Models\Usuario;
use Repositorio\Interfaces\IUsuarioRepositorio;
use Repositorio\UsuarioRepositorio;
use Utils\Funcoes;
use Utils\Log;
use Utils\Resposta;

class UsuarioServico extends ServicoBase {
    
    /**
     * @property IUsuarioRepositorio $usuarioRepositorio
     */
    private $usuarioRepositorio;

    public function __construct() {
        parent::__construct();

        $this->usuarioRepositorio = new UsuarioRepositorio($this->bancoDados);
    }

    public function cadastrar() {

        try {
            $nome        = getParametro("nome");
            $email       = getParametro("email");
            $login       = getParametro("login");
            $senha       = getParametro("senha");
            $nivelAcesso = getParametro("nivel_acesso");

            $errosCampos = Funcoes::validarCamposCadastroUsuario([
                "nome" => $nome,
                "email" => $email,
                "login" => $login,
                "senha" => $senha,
                "nivel_acesso" => $nivelAcesso
            ]);

            if (!empty($errosCampos)) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            // validar se já existe outro usuário cadastrado com o mesmo e-email
            if ($this->usuarioRepositorio->buscarPeloEmail($email)) {
                Resposta::response(false, "Informe outro e-mail.");
            }

            // validar se já existe outro usuário cadastrado com o mesmo login
            if ($this->usuarioRepositorio->buscarPeloLogin($login)) {
                Resposta::response(false, "Informe outro login.");
            }

            $usuario = new Usuario();

            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setLogin($login);
            $usuario->setSenha(md5($senha));
            $usuario->setNivelAcesso($nivelAcesso);

            $this->usuarioRepositorio->cadastrar($usuario);

            Resposta::response(true, "Usuário cadastrado com sucesso.", [
                "usuario_id" => $usuario->getUsuarioId(),
                "nome" => $usuario->getNome(),
                "email" => $usuario->getEmail(),
                "login" => $usuario->getLogin(),
                "nivel_acesso" => $usuario->getNivelAcesso(),
                "status" => $usuario->getStatus() ? "Ativo" : "Inativo"
            ]);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se cadastrar o usuário na base de dados: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se cadastrar o usuário.");
        }

    }

    public function listar() {

        try {
            $usuarios = $this->usuarioRepositorio->listar();

            if ($usuarios) {
                Resposta::response(true, "Usuários listados com sucesso.", $usuarios);
            }

            Resposta::response(true, "Não existem usuários cadastrados na base de dados.", array());
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se listar os usuários: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se listar os usuários.");
        }

    }

    public function buscarPeloId() {

        try {

            if (!isset($_GET["usuario_id"])) {
                Resposta::response(false, "Informe o id.");
            }

            $usuarioId = $_GET["usuario_id"];

            if (empty($usuarioId)) {
                Resposta::response(false, "Informe o id.");
            }

            $usuario = $this->usuarioRepositorio->buscarPeloId($usuarioId);

            if (empty($usuario)) {
                Resposta::response(false, "Usuário não encontrado.");
            }

            Resposta::response(true, "Usuário encontrado com sucesso.", $usuario);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se buscar o usuário pelo id: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se buscar o usuário pelo id.");
        }

    }

    public function deletar() {

        try {
            
            if (!isset($_GET["usuario_id"])) {
                Resposta::response(false, "Informe o id do usuário.");
            }

            $usuarioId = $_GET["usuario_id"];

            if (empty($usuarioId)) {
                Resposta::response(false, "Informe o id do usuário.");
            }

            if (empty($this->usuarioRepositorio->buscarPeloId($usuarioId))) {
                Resposta::response(false, "Usuário não encontrado.");
            }

            $this->usuarioRepositorio->deletar($usuarioId);

            Resposta::response(true, "Usuário deletado com sucesso.");
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se deletar o usuario: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se deletar o usuário.");
        }

    }

}