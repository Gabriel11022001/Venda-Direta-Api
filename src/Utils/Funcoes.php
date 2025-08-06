<?php

namespace Utils;

class Funcoes {

    // validar e-mail
    public static function validarEmail($email) {
        $email = trim($email);

        if (empty($email)) {

            return false;
        }

        $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        return preg_match($regex, $email) === 1;
    }

    public static function validarCamposCadastroUsuario($camposCadastroUsuario = array()) {
        $erros = array();

        if (empty($camposCadastroUsuario["nome"])) {
            $erros["nome"] = "Informe o nome.";
        }

        if (empty($camposCadastroUsuario["login"])) {
            $erros["login"] = "Informe o login.";
        } elseif (strlen($camposCadastroUsuario["login"]) < 6) {
            $erros["login"] = "O login deve possuir no mínimo 6 caracteres.";
        }

        if (empty($camposCadastroUsuario["email"])) {
            $erros["email"] = "Informe o e-mail.";
        } elseif (!self::validarEmail($camposCadastroUsuario["email"])) {
            $erros["email"] = "E-mail inválido.";
        }

        if (empty($camposCadastroUsuario["senha"])) {
            $erros["senha"] = "Informe a senha.";
        } elseif (strlen($camposCadastroUsuario["senha"]) < 6) {
            $erros["senha"] = "A senha deve possuir no mínimo 6 caracteres.";
        } 

        if (empty($camposCadastroUsuario["nivel_acesso"])) {
            $erros["nivel_acesso"] = "Informe o nivel de acesso.";
        } elseif (!self::validarNivelAcesso($camposCadastroUsuario["nivel_acesso"])) {
            $erros["nivel_acesso"] = "Nível de acesso inválido.";
        }

        return $erros;
    }

    private static function validarNivelAcesso($nivelAcesso) {
        $niveisAcesso = [
            "Admin",
            "Vendedor"
        ];

        if (!in_array($nivelAcesso, $niveisAcesso)) {

            return false;
        }

        return true;
    }

    public static function validarLoginSenha($login, $senha) {
        $erros = [];

        if (empty($login)) {
            $erros["login"] = "Informe o login.";
        } elseif (strlen($login) < 6) {
            $erros["login"] = "O login deve possuir no mínimo 6 caracteres.";
        }

        if (empty($senha)) {
            $erros["senha"] = "Informe a senha.";
        } elseif (strlen($senha) < 6) {
            $erros["senha"] = "A senha deve possuir no mínimo 6 caracteres.";
        }

        return $erros;
    }

}