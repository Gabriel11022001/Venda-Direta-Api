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

    public static function validarDadosProdutoCadastro($dadosProduto) {
        $erros = [];
        
        return $erros;
    }

    public static function validarCamposCadastroCliente($dadosCliente) {
        $erros = array();

        if (empty($dadosCliente["nome"])) {
            $erros["nome"] = "Informe o nome do cliente.";
        }

        if (empty($dadosCliente["cpf"])) {
            $erros["cpf"] = "Informe o cpf do cliente.";
        } else if (!self::validarCpf($dadosCliente["cpf"])) {
            $erros["cpf"] = "O cpf informado é inválido.";
        }

        if (empty($dadosCliente["data_nascimento"])) {
            $erros["data_nascimento"] = "Informe a data de nascimento.";
        } else if (!self::validarDataNascimento($dadosCliente["data_nascimento"])) {
            $erros["data_nascimento"] = "Data de nascimento inválida.";
        }

        if (empty($dadosCliente["usuario_id"])) {
            $erros["usuario_id"] = "Informe o id do usuário.";
        }

        if (empty($dadosCliente["endereco"])) {
            $erros["endereco"] = "Informe o endereço do cliente.";
        } else {
            // validar endereço do cliente
        }

        if (empty($dadosCliente["emails"])) {
            $erros["emails"] = "Informe os e-mails do cliente.";
        } else {

            foreach ($dadosCliente["emails"] as $email) {

                if (!self::validarEmail($email->email)) {
                    
                    throw new EmailInvalidoException("O e-mail " . $email->email . " é inválido.");
                }

            }

        }

        if (empty($dadosCliente["telefones"])) {
            $erros["telefones"] = "Informe os telefones do cliente.";
        } else {

            foreach ($dadosCliente["telefones"] as $telefone) {
                $validarTelefone = self::validarTelefone($telefone->telefone);
                
                if (!empty($validarTelefone)) {

                    throw new TelefoneInvalidoException($validarTelefone);
                }

            }

        }

        return $erros;
    }

    public static function validarCpf($cpf) {

        return true;
    }

    public static function validarDataNascimento($dataNascimento) {

        return true;
    }

    public static function validarTelefone($telefone) {

        if (empty($telefone)) {

            return "Você informou um telefone vazio.";
        }

        return "";
    }

}