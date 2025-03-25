<?php
class tagsrfidModel{

    public function tagsrfidInsert($vet)
    {
        var_dump($vet);
        // id_tags_rfid, tags_id_tags_rfid, name_tags_rfid, product_name_tags_rfid, date_entry_tags_rfid, date_exit_tags_rfid, lot_tags_rfid
        $dbcon = new DbConnection();
        $dbcon->Query("BEGIN;");
        $dbcon->Query("INSERT INTO tb_tags_rfid (
                            tags_id_tags_rfid,
                            product_name_tags_rfid,
                            date_exit_tags_rfid
                        )
                        VALUES(
                            $vet[tags_id_tags_rfid],
                            $vet[product_name_tags_rfid],
                            now()
                        )");
        $dbcon->Query("SELECT LAST_INSERT_ID() AS id_tags_rfid");
        if($Campo = $dbcon->Fetch())
            $id_tags_rfid = $Campo["id_tags_rfid"];
        $dbcon->Query("COMMIT;");
        return $id_tags_rfid;

    }
}