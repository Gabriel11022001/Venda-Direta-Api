<?php

namespace Servico;

use Exception;
use Repositorio\UsuarioRepositorio;
use Utils\Funcoes;
use Utils\Log;
use Utils\Resposta;

class LoginServico extends ServicoBase {

    /**
     * @property UsuarioRepositorio $usuarioRepositorio
     */
    private $usuarioRepositorio;

    public function __construct() {
        parent::__construct();

        $this->usuarioRepositorio = new UsuarioRepositorio($this->bancoDados);
    }

    public function login() {

        try {
            $login = getParametro("login");
            $senha = getParametro("senha");

            $errosCampos = Funcoes::validarLoginSenha($login, $senha);

            if ($errosCampos) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            $senha = md5($senha);

            $usuario = $this->usuarioRepositorio->buscarPeloLoginESenha($login, $senha);

            if (empty($usuario)) {
                Resposta::response(false, "Login ou senha inválidos.");
            }

            if ($usuario["status"]) {
                $usuario["status"] = "Ativo";
            } else {
                $usuario["status"] = "Inativo";
            }

            Resposta::response(true, "Usuário encontrado com sucesso.", $usuario);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se realizar login: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se realizar login.");
        }

    }

}