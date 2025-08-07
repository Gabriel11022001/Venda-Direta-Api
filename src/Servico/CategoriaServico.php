<?php

namespace Servico;

use Exception;
use Models\Categoria;
use Repositorio\CategoriaRepositorio;
use Repositorio\Interfaces\ICategoriaRepositorio;
use Utils\Log;
use Utils\Resposta;

class CategoriaServico extends ServicoBase {

    /**
     * @property ICategoriaRepositorio $categoriaRepositorio
     */
    private $categoriaRepositorio;

    public function __construct() {
        parent::__construct();

        $this->categoriaRepositorio = new CategoriaRepositorio($this->bancoDados);
    }

    private function validarCamposCadastroCategoria($nomeCategoriaValidar) {
        $erros = [];

        if (empty($nomeCategoriaValidar)) {
            $erros["nome"] = "Informe o nome da categoria.";
        } elseif (strlen($nomeCategoriaValidar) < 3) {
            $erros["nome"] = "O nome da categoria deve possuir no mínimo 3 caracteres.";
        }

        return $erros;
    }

    public function cadastrar() {

        try {
            $nome = getParametro("nome");
            $status = getParametro("status");
            
            $errosCampos = $this->validarCamposCadastroCategoria($nome);

            if ($errosCampos) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            // validar se já existe outra categoria cadastrada com o mesmo nome
            if ($this->categoriaRepositorio->buscarPeloNome($nome)) {
                Resposta::response(false, "Já existe outra categoria cadastrada com o mesmo nome na base de dados.");
            }

            $categoria = new Categoria();

            $categoria->setNome($nome);
            $categoria->setStatus($status);

            $this->categoriaRepositorio->cadastrar($categoria);

            Resposta::response(true, "Categoria cadastrada com sucesso.", $categoria->toArray());
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se cadastrar a categoria: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se cadastrar a categoria.");
        }

    }

}