<?php
class spoutsModel{

    public function spoutsInsert($vet)
    {
        
        $dbcon = new DbConnection();
        $dbcon->Query("BEGIN;");
        $dbcon->Query("INSERT INTO tb_spouts(
                            date_spouts,
                            lot_spouts,
                            seed_rank_spouts,
                            sector_rank_spouts,
                            evaluated_quantity_spouts,
                            total_weight_spouts,
                            medium_weight_spouts,
                            minor_injury_spouts,
                            severe_injury_spouts,
                            mid_rotten_quantity_spouts,
                            serious_rotten_quantity_spouts,
                            amended_quantity_spouts,
                            monkey_quantity_spouts,
                            filipado_quantity_spouts,
                            horned_quantity_spouts
                        )
                        Values(
                            now(),
                            $vet[lot_spouts],
                            $vet[seed_rank_spouts],
                            $vet[sector_rank_spouts],
                            $vet[evaluated_quantity_spouts],
                            $vet[total_weight_spouts],
                            $vet[medium_weight_spouts],
                            $vet[minor_injury_spouts],
                            $vet[severe_injury_spouts],
                            $vet[mid_rotten_quantity_spouts],
                            $vet[serious_rotten_quantity_spouts],
                            $vet[amended_quantity_spouts],
                            $vet[monkey_quantity_spouts],
                            $vet[filipado_quantity_spouts],
                            $vet[horned_quantity_spouts]
                        )");
        $dbcon->Query("SELECT LAST_INSERT_ID() AS id_spouts");
        if($Campo = $dbcon->Fetch())
            $id_spouts = $Campo["id_spouts"];
        $dbcon->Query("COMMIT;");
        return $id_spouts;

    }
}