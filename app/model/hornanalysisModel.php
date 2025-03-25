<?php
class hornanalysisModel{

    public function hornanalysisInsert($vet)
    {
        $dbcon = new DbConnection();
        $dbcon->Query("BEGIN;");
        $dbcon->Query("INSERT INTO tb_hornanalysis(
                            date_hornanalysis,
                            total_quantity_teeth_hornanalysis,
                            total_weight_hornanalysis,
                            quantity_horn_hornanalysis,
                            quantity_tick_hornanalysis,
                            quantity_filipado_hornanalysis,
                            quantity_amended_hornanalysis,
                            sector_hornanalysis
                        )
                        Values(
                            now(),
                            $vet[total_quantity_teeth_hornanalysis],
                            $vet[total_weight_hornanalysis],
                            $vet[quantity_horn_hornanalysis],
                            $vet[quantity_tick_hornanalysis],
                            $vet[quantity_filipado_hornanalysis],
                            $vet[quantity_amended_hornanalysis],
                            $vet[sector_hornanalysis]
                        )");
        $dbcon->Query("SELECT LAST_INSERT_ID() AS id_hornanalysis");
        if($Campo = $dbcon->Fetch())
            $id_hornanalysis = $Campo["id_hornanalysis"];
        $dbcon->Query("COMMIT;");
        return $id_hornanalysis;

    }
}