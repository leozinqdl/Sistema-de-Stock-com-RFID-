<?php
class ChangeController extends ControllerView
{
    public function indexAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("change","insert");
    }

    public function insertAction() 

    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("change", "insert");
        $model = new changeModel();
        $AlertJquery = new AlertJquery();
    
        if (empty($_POST)) {
            $AlertJquery->addAlert("Erro ao gravar Ordem de Manutenção. Favor entrar em contato com o Administrador do sistema!");
        } else {
            $form = new FormValidate();
            
            // Buscar o último new_lot_change e definir como old_lot_change
            $lastLot = $model->getLastNewLotChange();
            $vet_db["old_lot_change"] = $lastLot ? $lastLot : null;
            
            // Inserir o novo valor em new_lot_change
            $vet_db["new_lot_change"] = $form->int_db($_REQUEST['new_lot_change']);
    
            if ($AlertJquery->hasAlert()) {
                $AlertJquery->printAlert(2, "/change");
            }
            
            $model->changeInsert($vet_db);
            $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
        }
    }

}