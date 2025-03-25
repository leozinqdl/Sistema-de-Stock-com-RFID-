<?php
class SettingsmachineController extends ControllerView
{
    public function indexAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("settingsmachine", "insert");
    }

    public function insertAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("settingsmachine", "insert");
        $model = new SettingsmachineModel();
        $AlertJquery = new AlertJquery();

        if (empty($_POST)) {
            $AlertJquery->addAlert("Erro ao gravar Ordem de Manutenção, favor entrar em contato com o Administrador do sistema!");
            return;
        }


        // Validação dos dados do formulário
        $form = new FormValidate();
        $vet_db["machine_settings_right_settings_machine"] = $form->string_db($_REQUEST['machine_settings_right_settings_machine']);
        $vet_db["machine_settings_left_settings_machine"] = $form->string_db($_REQUEST['machine_settings_left_settings_machine']);
        $vet_db["observations_settings_machine"] = $form->string_db($_REQUEST['observations_settings_machine']);

        // Verificação de campos obrigatórios
        if (empty($vet_db["machine_settings_right_settings_machine"])) {
            $AlertJquery->addAlert("O Campo 'Data de Configuração Direita' é obrigatório!");
        }
        if (empty($vet_db["machine_settings_left_settings_machine"])) {
            $AlertJquery->addAlert("O Campo 'Data de Configuração Esquerda' é obrigatório!");
        }
        if (empty($vet_db["observations_settings_machine"])) {
            $vet_db["observations_settings_machine"] = null; // Define como NULL se estiver vazio
        }

        // Tenta inserir os dados no banco de dados
        if ($model->SettingsmachineInsert($vet_db)) {
            $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
            $AlertJquery->printAlert(1, "/settingsmachine");
        } else {
            $AlertJquery->addAlert("Erro ao gravar Ordem de Manutenção. Favor entrar em contato com o Administrador do sistema!");
            $AlertJquery->printAlert(2, "/settingsmachine");
        }
    }
}