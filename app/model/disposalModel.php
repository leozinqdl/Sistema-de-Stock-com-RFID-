<?php
class disposalModel{

    public function disposalInsert($vet)
    {
        var_dump($vet);
        $dbcon = new DbConnection();
        $dbcon->Query("BEGIN;");
        $dbcon->Query("INSERT INTO tb_disposal(
                            date_disposal,
                            lot_disposal,
                            seed_class_disposal,
                            sector_disposal,
                            evaluated_quantity_disposal,
                            total_weight_disposal,
                            quantity_good_garlic_disposal,
                            amount_chopped_garlic_disposal,
                            amount_monkey_disposal,
                            amount_membership_disposal
                        )
                        Values(
                            now(),
                            $vet[lot_disposal],
                            $vet[seed_class_disposal],
                            $vet[sector_disposal],
                            $vet[evaluated_quantity_disposal],
                            $vet[total_weight_disposal], 
                            $vet[quantity_good_garlic_disposal], 
                            $vet[amount_chopped_garlic_disposal], 
                            $vet[amount_monkey_disposal],
                            $vet[amount_membership_disposal]
                        )");
        $dbcon->Query("SELECT LAST_INSERT_ID() AS id_disposal");
        if($Campo = $dbcon->Fetch())
            $id_disposal = $Campo["id_disposal"];
        $dbcon->Query("COMMIT;");

        return $id_disposal;
    }
}