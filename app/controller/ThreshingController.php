<?php
class threshingController extends ControllerView
{
    public function indexAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("threshing", "insert");
    }

    public function insertAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("threshing", "insert");
        $model = new threshingModel();
        $AlertJquery = new AlertJquery();

        if (empty($_POST)) {
            $AlertJquery->addAlert("Erro ao gravar Ordem de Manutenção, favor entrar em contato com o Administrador do sistema!");
            return;
        }

        $form = new FormValidate();
        $vet_db["quantity_teeth_threshing"] = $form->int_db($_POST['quantity_teeth_threshing']);
        $vet_db["amended_quantity_threshing"] = $form->int_db($_POST['amended_quantity_threshing']);
        $vet_db["severe_injury_quantity_threshing"] = $form->int_db($_POST['severe_injury_quantity_threshing']);
        $vet_db["minor_injury_quantity_threshing"] = $form->int_db($_POST['minor_injury_quantity_threshing']);
        $vet_db["observations_threshing"] = $form->string_db($_POST['observations_threshing']);
        // $vet_db["type_threshing"] = $form->string_db($_POST['type_threshing']);

        if (is_numeric($vet_db["quantity_teeth_threshing"]) && $vet_db["quantity_teeth_threshing"] > 0) {
            $vet_db["porcentage_amended_threshing"] = round(
                ($vet_db["amended_quantity_threshing"] / $vet_db["quantity_teeth_threshing"]) * 100,
                2
            );

            $vet_db["porcentage_serious_injury_threshing"] = round(
                ($vet_db["severe_injury_quantity_threshing"] / $vet_db["quantity_teeth_threshing"]) * 100,
                2
            );
        } else {
            $vet_db["porcentage_amended_threshing"] = 0;
            $vet_db["porcentage_serious_injury_threshing"] = 0;
        }

        // Verifica se os campos são nulos ou não foram enviados, mas permite o valor 0
        if (!isset($vet_db["quantity_teeth_threshing"]) || $vet_db["quantity_teeth_threshing"] === "")
            $AlertJquery->addAlert("O Campo 'Quantidade(Dentes)' é obrigatório!");
        if (!isset($vet_db["amended_quantity_threshing"]) || $vet_db["amended_quantity_threshing"] === "")
            $AlertJquery->addAlert("O Campo 'Quantidade Emendados' é obrigatório!");
        if (!isset($vet_db["severe_injury_quantity_threshing"]) || $vet_db["severe_injury_quantity_threshing"] === "")
            $AlertJquery->addAlert("O Campo 'Quantidade Machucado Manual Grave' é obrigatório!");
        if (!isset($vet_db["minor_injury_quantity_threshing"]) || $vet_db["minor_injury_quantity_threshing"] === "")
            $AlertJquery->addAlert("O Campo 'Quantidade Machucado Leve' é obrigatório!");
        if (empty($vet_db["observations_threshing"]))
            $AlertJquery->addAlert("O Campo 'Observações' é obrigatório!");

        if ($AlertJquery->hasAlert()) {
            $AlertJquery->printAlert(2, "/threshing");
            return; // Impede a inserção em caso de erro
        }

        // Se houver alertas, exibe e redireciona
        if ($AlertJquery->hasAlert()) {
            $AlertJquery->printAlert(2, "/settingsmachine");
            return;
        }

        $model->threshingInsert($vet_db);
        $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
    }
}
