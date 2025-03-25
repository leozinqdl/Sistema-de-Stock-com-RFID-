<?php
class threshingModel{

    public function threshingInsert($vet){
        
        var_dump($vet);
        $dbcon = new DbConnection();
        $dbcon->Query("BEGIN;");
        $dbcon->Query("INSERT INTO tb_threshing(
                            date_threshing,
                            quantity_teeth_threshing,
                            amended_quantity_threshing,
                            severe_injury_quantity_threshing,
                            minor_injury_quantity_threshing,
                            observations_threshing,
                            porcentage_amended_threshing,
                            porcentage_serious_injury_threshing
                            -- type_threshing
                        )
                        Values(
                            now(),
                            $vet[quantity_teeth_threshing],
                            $vet[amended_quantity_threshing],
                            $vet[severe_injury_quantity_threshing],
                            $vet[minor_injury_quantity_threshing],
                            $vet[observations_threshing],
                            $vet[porcentage_amended_threshing],
                            $vet[porcentage_serious_injury_threshing]
                            -- $vet[type_threshing]
                        )");
        $dbcon->Query("SELECT LAST_INSERT_ID() AS id_threshing");
        if($Campo = $dbcon->Fetch())
            $id_threshing = $Campo["id_threshing"];
        $dbcon->Query("COMMIT;");

        return $id_threshing;

    }
}