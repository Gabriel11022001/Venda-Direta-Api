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

    public function editar() {

        try {
            $categoriaId = getParametro("categoria_id");
            $nome = getParametro("nome");
            $status = getParametro("status");

            $errosCampos = [];

            if (empty($categoriaId)) {
                $errosCampos["categoria_id"] = "Informe o id da categoria.";
            }

            if (empty($nome)) {
                $errosCampos["nome"] = "Informe o nome da categoria.";
            } elseif (strlen($nome) < 3) {
                $errosCampos["nome"] = "O nome da categoria deve possuir no mínimo 3 caracteres.";
            }

            if (!empty($errosCampos)) {
                Resposta::response(false, "Campos inválidos.", $errosCampos);
            }

            $categoriaValidar = $this->categoriaRepositorio->buscarPeloId($categoriaId);

            // validar se existe outra categoria cadastrada com o id informado
            if (empty($categoriaValidar)) {
                Resposta::response(false, "Não existe uma categoria cadastrada com o id informado.");
            }

            // validar se existe outra categoria com o mesmo nome informado
            if ($categoriaValidar["nome"] == $nome && $categoriaId != $categoriaValidar["categoria_id"]) {
                Resposta::response(false, "Já existe outra categoria cadastrada na base de dados com o mesmo nome.");
            }

            $categoria = new Categoria();
            $categoria->setCategoriaId($categoriaId);
            $categoria->setNome($nome);
            $categoria->setStatus($status);

            $this->categoriaRepositorio->editar($categoria);

            Resposta::response(true, "Categoria salva com sucesso na base de dados.", $categoria->toArray());
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se editar a categoria: " . $e->getMessage());
            
            Resposta::response(false, "Erro ao tentar-se editar a categoria.");
        }

    }

    public function buscarPeloId() {

        try {
            
            if (!isset($_GET["categoria_id"])) {
                Resposta::response(false, "Informe o id da categoria.");
            }

            $categoriaId = $_GET["categoria_id"];

            if (empty($categoriaId)) {
                Resposta::response(false, "Informe o id da categoria.");
            }

            $categoria = $this->categoriaRepositorio->buscarPeloId($categoriaId);

            if (!$categoria) {
                Resposta::response(false, "Categoria não encontrada.");
            }

            Resposta::response(true, "Categoria encontrada com sucesso.", [
                "categoria_id" => $categoria["categoria_id"],
                "nome" => $categoria["nome"],
                "status" => $categoria["status"] ? "Ativo" : "Inativo"
            ]);
        } catch (Exception $e) {
            Log::erro("Erro ao tentar-se buscar a categoria pelo id: " . $e->getMessage());

            Resposta::response(false, "Erro ao tentar-se buscar a categoria pelo id.");
        }

    }

}