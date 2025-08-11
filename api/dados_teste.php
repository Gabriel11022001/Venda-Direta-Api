<?php

use Models\Categoria;
use Models\Produto;
use Repositorio\CategoriaRepositorio;
use Repositorio\ProdutoRepositorio;
use Utils\BancoDados;
use Utils\Log;

require_once "autoload.php";

$bancoDados = BancoDados::conectarBancoDados();

try {
    $bancoDados->beginTransaction();
    // registrar categorias de produtos de teste
    $categoriasCadastradas = cadastrarCategorias($bancoDados, 999);

    $bancoDados->commit();

    $bancoDados->beginTransaction();
    // registrar produtos de teste
    cadastrarProdutos($bancoDados, $categoriasCadastradas);

    $bancoDados->commit();

    echo "<p style='color: green; text-size: 20px;'>Registros efetivados com sucesso!</p><br>";
} catch (Exception $e) {
    $bancoDados->rollBack();

    Log::erro("Erro ao tentar-se salvar dados para teste: " . $e->getMessage());

    echo "Erro ao tentar-se salvar dados de teste: " . $e->getMessage() . "<br>";
}

/**
 * @param PDO $bancoDados
 */
function cadastrarCategorias($bancoDados, $limite = 100) {
    $categoriaRepositorio = new CategoriaRepositorio($bancoDados);
    $categoriasCadastradas = [];

    for ($i = 0; $i < $limite; $i++) {
        $categoriCadastrar = new Categoria();
        
        $nomeCategoria = "categoria de teste " . ($i + 1);

        if (!empty($categoriaRepositorio->buscarPeloNome($nomeCategoria))) {

            continue;
        }

        $categoriCadastrar->setNome("categoria de teste " . ($i + 1));
        $categoriCadastrar->setStatus(true);
        
        $categoriaRepositorio->cadastrar($categoriCadastrar);

        $categoriasCadastradas[] = $categoriCadastrar;
    }

    return $categoriasCadastradas;
}

/**
 * @param PDO $bancoDados
 */
function cadastrarProdutos($bancoDados, $categorias, $limite = 100) {
    $produtoRepositorio = new ProdutoRepositorio($bancoDados);

    if (empty($categorias)) {

        return;
    }

    $primeiraCategoria = $categorias[0];
    $segundaCategoria = $categorias[1];

    // obter todas as categorias que foram cadastradas

    for ($i = 0; $i < $limite; $i++) {
        $produtoCadastrar = new Produto();

        $nomeProduto = "produto de teste: " . ($i + 1);

        $stmt = $bancoDados->prepare("SELECT * FROM tb_produtos WHERE nome_produto = :nome_produto");
        $stmt->bindValue(":nome_produto", $nomeProduto, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {

            continue;
        }

        $produtoCadastrar->setNomeProduto("produto de teste: " . ($i + 1));
        $produtoCadastrar->setPrecoVenda(20);
        $produtoCadastrar->setUnidadesEstoque(100);
        $produtoCadastrar->setStatus(true);
        $produtoCadastrar->setFoto("");

        $produtoCadastrar->setCategoriaId($i % 2 == 0 ? $primeiraCategoria->getCategoriaId() : $segundaCategoria->getCategoriaId());

        $produtoRepositorio->cadastrar($produtoCadastrar);
    }

}