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

            $usuarioCadastradoLoginInformado = $this->usuarioRepositorio->buscarPeloLogin($login);
            $usuario = $this->usuarioRepositorio->buscarPeloLoginESenha($login, $senha);

            if (!empty($usuarioCadastradoLoginInformado)) {

                if (!$usuarioCadastradoLoginInformado["status"]) {
                    Resposta::response(false, "Seu perfil está inativo.");
                }

            }

            /**
             * se não encontrar o usuário, validar se já é a terceira tentativa,
             * se for, bloquear o perfil do usuário
             */
            if (!empty($usuarioCadastradoLoginInformado) && empty($usuario)) {
                
                if (isset($_SESSION["tentativas_login"])) {
                    $_SESSION["tentativas_login"] = $_SESSION["tentativas_login"] + 1;

                    if ($_SESSION["tentativas_login"] === 3) {
                        // bloquear o perfil do usuário
                        $this->desativarPerfilUsuario($usuarioCadastradoLoginInformado["usuario_id"]);

                        unset($_SESSION["tentativas_login"]);

                        Resposta::response(false, "Você atingiu o número de tentativas de login, seu perfil foi bloqueado, solicite ao administrador do sistema que o mesmo seja ativo novamente.");
                    } else {
                        Resposta::response(false, "Login ou senha inválidos, você ainda possui " . (3 - $_SESSION["tentativas_login"]) . " tentativas antes que seu perfil seja bloqueado.");
                    }

                } else {
                    // primeira tentativa de fazer o login
                    $_SESSION["tentativas_login"] = 1;

                    Resposta::response(false, "Login ou senha inválidos, você ainda possui " . (3 - $_SESSION["tentativas_login"]) . " tentativas antes que seu perfil seja bloqueado.");
                }

            }

            $usuario["status"] = $usuario["status"] ? "Ativo" : "Inativo";

            Resposta::response(true, "Usuário encontrado com sucesso.", $usuario);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se realizar login: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se realizar login.");
        }

    }

    private function desativarPerfilUsuario($idUsuarioDesativar) {
        $this->usuarioRepositorio->alterarStatus($idUsuarioDesativar, false);
    }

}