<?php
class DisposalController extends ControllerView
{
    public function indexAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("disposal","insert");
    }

	public function insertAction()
    {

        $perm = new Permission();
        $perm->isSessionActive();
        $this->run("disposal","insert");
        $model = new disposalModel();
        $AlertJquery = new AlertJquery();
        
        if(empty($_POST))
        {
            $AlertJquery->addAlert("Erro ao gravar Ordem de Manutenção favor Entrar em contato com o Administrador do sistema!");
        }
        else
        {
            $form = new FormValidate();
            $vet_db['lot_disposal'] = $form->string_db($_REQUEST['lot_disposal']);
            $vet_db['seed_class_disposal'] = $form->string_db($_REQUEST['seed_class_disposal']);
            $vet_db['sector_disposal'] = $form->int_db($_REQUEST['sector_disposal']);
            $vet_db['evaluated_quantity_disposal'] = $form->int_db($_REQUEST['evaluated_quantity_disposal']);
            $vet_db['total_weight_disposal'] = $form->int_db($_REQUEST['total_weight_disposal']);
            $vet_db['quantity_good_garlic_disposal'] = $form->int_db($_REQUEST['quantity_good_garlic_disposal']);
            $vet_db['amount_chopped_garlic_disposal'] = $form->int_db($_REQUEST['amount_chopped_garlic_disposal']);
            $vet_db['amount_monkey_disposal'] = $form->int_db($_REQUEST['amount_monkey_disposal']);
            $vet_db['amount_membership_disposal'] = $form->int_db($_REQUEST['amount_membership_disposal']);
            
            if($vet_db['lot_disposal'] == "NULL")
                $vet_db['lot_disposal'] = 0;
            if($vet_db['seed_class_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Lote' é obrigatório!");
            if($vet_db['sector_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Peso' é obrigatório!");
            if($vet_db['evaluated_quantity_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade' é obrigatório!");
            if($vet_db['total_weight_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Tipo' é obrigatório!");
            if($vet_db['quantity_good_garlic_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Tipo' é obrigatório!");
            if($vet_db['amount_chopped_garlic_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Tipo' é obrigatório!");
            if($vet_db['amount_monkey_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Tipo' é obrigatório!");
            if($vet_db['amount_membership_disposal'] == "NULL")
                $AlertJquery->addAlert("O Campo 'Tipo' é obrigatório!");

            if($AlertJquery->hasAlert())
                $AlertJquery->printAlert(2, "/disposal");
                $model->disposalInsert($vet_db);
                $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
        }

    }
}
