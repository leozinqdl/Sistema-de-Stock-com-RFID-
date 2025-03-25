<?php
class changeModel {

    // Método para inserir uma mudança no banco de dados
    public function changeInsert($vet)
    {
        // Verifica se o valor de 'new_lot_change' é repetido
        $lastNewLotChange = $this->getLastNewLotChange();
        
        if ($vet['new_lot_change'] == $lastNewLotChange) {
            echo "Erro: O valor de 'new_lot_change' não pode ser repetido.";
            return; // Impede a inserção
        }

        // Verifica se 'old_lot_change' está vazio ou não definido e define como NULL
        if (!isset($vet['old_lot_change']) || $vet['old_lot_change'] === '') {
            $vet['old_lot_change'] = null;
        }

        // Conecta ao banco de dados
        $dbcon = new DbConnection();

        try {
            // Inicia uma transação
            $dbcon->Query("BEGIN;");

            // Monta a query de inserção
            $query = "INSERT INTO tb_change (
                        new_lot_change,
                        old_lot_change,
                        date_change
                    ) VALUES (
                        {$vet['new_lot_change']},
                        " . ($vet['old_lot_change'] !== null ? $vet['old_lot_change'] : 'NULL') . ",
                        now()
                    )";

            // Executa a query de inserção
            $dbcon->Query($query);

            // Obtém o ID da última inserção
            $dbcon->Query("SELECT LAST_INSERT_ID() AS id_change");

            // Recupera o ID gerado
            if ($Campo = $dbcon->Fetch()) {
                $id_lot = $Campo["id_change"];
            }

            // Confirma a transação
            $dbcon->Query("COMMIT;");

        } catch (Exception $e) {
            // Em caso de erro, faz rollback e lança a exceção novamente
            $dbcon->Query("ROLLBACK;");
            throw new Exception("Erro ao inserir no banco de dados: " . $e->getMessage());
        }
    }

    // Método para obter o último valor de 'new_lot_change'
    public function getLastNewLotChange()
    {
        $dbcon = new DbConnection();

        // Query para buscar o último valor de 'new_lot_change'
        $query = "SELECT new_lot_change FROM tb_change ORDER BY id_change DESC LIMIT 1";
        $result = $dbcon->Query($query);

        // Retorna o valor encontrado ou NULL se não houver registros
        if ($row = $dbcon->Fetch()) {
            return $row['new_lot_change'];
        }

        return null;
    }
}