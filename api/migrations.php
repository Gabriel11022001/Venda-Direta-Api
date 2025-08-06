<?php

// rodar as migrations e executar uma por uma em sequência

use Utils\BancoDados;
use Utils\Log;

require_once "autoload.php";

// conectar-se ao banco de dados
$bancoDados = BancoDados::conectarBancoDados();

try {
    // iniciar a transação
    $bancoDados->beginTransaction();

    $caminhoArquivo = __DIR__ . "/../migrations/";

    if (is_dir($caminhoArquivo)) {
        $arquivosSql = glob($caminhoArquivo . "/*.sql");

        if (!empty($arquivosSql)) {

            foreach ($arquivosSql as $arquivoSql) {
                $sql = file_get_contents($arquivoSql);

                if (!empty($sql)) {
                    $bancoDados->exec($sql);
                    
                    echo "Migration " . $arquivoSql . " executada com sucesso." . PHP_EOL;
                }   

            }

            // comitar a transação
            $bancoDados->commit();
        } else {
            echo "Nenhuma migration definida." . PHP_EOL;
        }

    } else {
        echo "Caminho do diretório com os arquivos sql não encontrado." . PHP_EOL;
    }

} catch (Exception $e) {
    Log::erro("Erro ao tentar-se executar as migrations: " . $e->getMessage());

    // cancelar a transação pois ocorreu um erro
    $bancoDados->rollBack();

    echo "Erro ao tentar-se executar as migrations: " . $e->getMessage() . PHP_EOL;
}