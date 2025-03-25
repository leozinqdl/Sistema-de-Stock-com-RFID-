<?php
class MechanicalthreshingController extends ControllerView
{
    public function indexAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("mechanicalthreshing","insert");
    }

    public function insertAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("mechanicalthreshing","insert");
        $model = new mechanicalthreshingModel();
        $AlertJquery = new AlertJquery();

        if (empty($_POST)) {
            $AlertJquery->addAlert("Erro ao gravar Ordem de Manutenção, favor entrar em contato com o Administrador do sistema!");
            return;
        }

        $form = new FormValidate();
        $vet_db["quantity_teeth_mechanical_threshing"] = $form->int_db($_REQUEST['quantity_teeth_mechanical_threshing']);
        $vet_db["severe_mechanical_injury_quantity_mechanical_threshing"] = $form->int_db($_REQUEST['severe_mechanical_injury_quantity_mechanical_threshing']);
        $vet_db["minor_injury_quantity_mechanical_threshing"] = $form->int_db($_REQUEST['minor_injury_quantity_mechanical_threshing']);
        $vet_db['observations_mechanical_threshing'] = $form->string_db($_REQUEST['observations_mechanical_threshing']);
        $vet_db["number_of_whole_heads_mechanical_threshing"] = $form->int_db($_REQUEST['number_of_whole_heads_mechanical_threshing']);

        // Verifica se o valor é numérico e maior ou igual a 0
        if (is_numeric($vet_db["quantity_teeth_mechanical_threshing"]) && $vet_db["quantity_teeth_mechanical_threshing"] >= 0) {
            $vet_db["serious_injury_porcentage_mechanical_threshing"] = round(
                ($vet_db["severe_mechanical_injury_quantity_mechanical_threshing"] / $vet_db["quantity_teeth_mechanical_threshing"]) * 100, 2
            );
        } else {
            $vet_db["serious_injury_porcentage_mechanical_threshing"] = 0;
        }

        // Verifica se o campo é vazio ou não foi enviado
        if ($vet_db["quantity_teeth_mechanical_threshing"] === null || $vet_db["quantity_teeth_mechanical_threshing"] === "") {
            $AlertJquery->addAlert("O Campo 'Quantidade(Dentes):' é obrigatório!");
        }
        if ($vet_db["severe_mechanical_injury_quantity_mechanical_threshing"] === null || $vet_db["severe_mechanical_injury_quantity_mechanical_threshing"] === "") {
            $AlertJquery->addAlert("O Campo 'Quantidade Machucado Mecânico Grave:' é obrigatório!");
        }
        if ($vet_db["minor_injury_quantity_mechanical_threshing"] === null || $vet_db["minor_injury_quantity_mechanical_threshing"] === "") {
            $AlertJquery->addAlert("O Campo 'Quantidade Machucado Leve:' é obrigatório!");
        }
        if ($vet_db["observations_mechanical_threshing"] === null || $vet_db["observations_mechanical_threshing"] === "") {
            $vet_db["observations_mechanical_threshing"] = "";
        }

        if ($AlertJquery->hasAlert()) {
            $AlertJquery->printAlert(2, "/mechanicalthreshing");
        } else {
            $model->mechanicalthreshingInsert($vet_db);
            $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
            $AlertJquery->printAlert(1, "/mechanicalthreshing");
        }
    }
}
?>