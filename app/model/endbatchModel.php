<?php
class EndbatchModel
{
    public function updateWeightTag($pallet_identification_tags, $evaluated_quantity_disposal)
{
    $dbcon = new DbConnection();

    try {
        // Iniciar transação
        $dbcon->Query("BEGIN;");

        // 3. Buscar a linha com base no pallet_identification_tags
        $dbcon->Query("SELECT id_tags, epx_tags, weight_tags FROM tb_tags WHERE pallet_identification_tags = '$pallet_identification_tags' LIMIT 1");
        if ($row = $dbcon->Fetch()) {
            $id_tags = $row["id_tags"];
            $epx_tags = $row["epx_tags"];
            $weight_tags = $row["weight_tags"];

            // 4. Verificar se weight_tags é 0
            if ($weight_tags >= 0) {
                // 5. Atualizar tanto tb_tags quanto tb_sync_data dentro da mesma transação
                $dbcon->Query("UPDATE tb_tags SET weight_tags = $evaluated_quantity_disposal WHERE id_tags = $id_tags");
                $dbcon->Query("UPDATE tb_sync_data SET weight_tags_sync = $evaluated_quantity_disposal WHERE epc_hex_sync = '$epx_tags'");

                // 6. Confirmar transação
                $dbcon->Query("COMMIT;");

                return true; // Atualização bem-sucedida
            } else {
                // 7. Rollback se weight_tags não for 0
                $dbcon->Query("ROLLBACK;");
                return true; // Não há atualização porque o weight_tags não é 0
            }
        } else {
            // 8. Rollback se nenhum registro for encontrado
            $dbcon->Query("ROLLBACK;");
            return false; // Nenhum registro encontrado
        }
    } catch (Exception $e) {
        // 9. Rollback em caso de erro
        $dbcon->Query("ROLLBACK;");
        throw new Exception("Erro ao atualizar weight_tags: " . $e->getMessage());
    }
}
}