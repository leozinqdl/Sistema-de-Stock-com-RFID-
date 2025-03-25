<?php
class mechanicalthreshingModel{
    public function mechanicalthreshingInsert($vet)
    {
        var_dump($vet);
        $dbcon = new DbConnection();
        $dbcon->Query("BEGIN;");
        $dbcon->Query("INSERT INTO tb_mechanical_threshing(
                            date_mechanical_threshing,
                            quantity_teeth_mechanical_threshing,
                            severe_mechanical_injury_quantity_mechanical_threshing,
                            minor_injury_quantity_mechanical_threshing,
                            observations_mechanical_threshing,
                            serious_injury_porcentage_mechanical_threshing,
                            number_of_whole_heads_mechanical_threshing
                        )
                        Values(
                            now(),
                            $vet[quantity_teeth_mechanical_threshing],
                            $vet[severe_mechanical_injury_quantity_mechanical_threshing],
                            $vet[minor_injury_quantity_mechanical_threshing],
                            $vet[observations_mechanical_threshing],
                            $vet[serious_injury_porcentage_mechanical_threshing],
                            $vet[number_of_whole_heads_mechanical_threshing]
                        )");
        $dbcon->Query("SELECT LAST_INSERT_ID() AS id_mechanical_threshing");
        if($Campo = $dbcon->Fetch())
            $id_mechanicalthreshing = $Campo["id_mechanical_threshing"];
        $dbcon->Query("COMMIT;");

        return $id_mechanicalthreshing;

    }
}
?>