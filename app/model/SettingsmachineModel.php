<?php
class SettingsmachineModel{
    public function SettingsmachineInsert($vet)
    {
        var_dump($vet);
        $dbcon = new DbConnection();
        $dbcon->Query("BEGIN;");
        $dbcon->Query("INSERT INTO tb_settings_machine(
                            date_settings_machine,
                            machine_settings_right_settings_machine,
                            machine_settings_left_settings_machine,
                            observations_settings_machine
                        )
                        Values(
                            now(),
                            $vet[machine_settings_right_settings_machine],
                            $vet[machine_settings_left_settings_machine],
                            $vet[observations_settings_machine]
                        )");

        $dbcon->Query("SELECT LAST_INSERT_ID() AS id_settings_machine");
        if($Campo = $dbcon->Fetch())
            $id_settingsmachine = $Campo["id_settings_machine"];
        $dbcon->Query("COMMIT;");

        return $id_settingsmachine;

    }
}
?>