<?php
class SpoutsController extends ControllerView
{
    // Método indexAction, provavelmente a ação padrão do controlador
    public function indexAction()
    {
        // Cria uma instância da classe Permission, provavelmente para gerenciar permissões de acesso
        $perm = new Permission();
        // Verifica se há uma sessão ativa. Se não houver, provavelmente redireciona para a página de login ou exibe uma mensagem de erro.
        $perm->isSessionActive();
        // Chama o método run, passando "stock" e "insert" como argumentos.  Isso pode ser usado para definir qual view/template será renderizado, neste caso, relacionado a "stock" e a ação "insert".
        $this->run("spouts","insert");
    }

    // Método insertAction, responsável por lidar com a inserção de dados no estoque
    public function insertAction()
    {
        // Verifica as permissões de sessão, como no método indexAction
        $perm = new Permission();
        $perm->isSessionActive();
        // Chama o método run, semelhante ao indexAction, provavelmente para definir a view/template.
        $this->run("spouts","insert");
        // Cria uma instância do model stockModel, que provavelmente contém as funções para interagir com o banco de dados na tabela de estoque.
        $model = new spoutsModel();
        // Cria uma instância da classe AlertJquery, que provavelmente é usada para exibir alertas (mensagens) ao usuário usando jQuery.
        $AlertJquery = new AlertJquery();

        // Verifica se o formulário foi submetido (se $_POST está vazio).
        if(empty($_POST))
        {
            // Se o formulário estiver vazio (ou seja, não foi submetido), adiciona um alerta de erro.
            $AlertJquery->addAlert("Erro ao gravar Ordem de Manutenção favor Entrar em contato com o Administrador do sistema!");
        }
        else
        {
            $form = new FormValidate();
            // Sanitiza e valida os dados do formulário usando os métodos da classe FormValidate.
            $vet_db["lot_spouts"] = $form->int_db($_REQUEST['lot_spouts']);
            $vet_db["seed_rank_spouts"] = $form->string_db($_REQUEST['seed_rank_spouts']);
            $vet_db["sector_rank_spouts"] = $form->int_db($_REQUEST['sector_rank_spouts']);
            $vet_db["evaluated_quantity_spouts"] = $form->int_db($_REQUEST['evaluated_quantity_spouts']);
            $vet_db["total_weight_spouts"] = $form->float_db($_REQUEST['total_weight_spouts']);
            $vet_db["minor_injury_spouts"] = $form->int_db($_REQUEST['minor_injury_spouts']);
            $vet_db["severe_injury_spouts"] = $form->int_db($_REQUEST['severe_injury_spouts']);
            $vet_db["mid_rotten_quantity_spouts"] = $form->int_db($_REQUEST['mid_rotten_quantity_spouts']);
            $vet_db["serious_rotten_quantity_spouts"] = $form->int_db($_REQUEST['serious_rotten_quantity_spouts']);
            $vet_db["amended_quantity_spouts"] = $form->int_db($_REQUEST['amended_quantity_spouts']);
            $vet_db["monkey_quantity_spouts"] = $form->int_db($_REQUEST['monkey_quantity_spouts']);
            $vet_db["filipado_quantity_spouts"] = $form->int_db($_REQUEST['filipado_quantity_spouts']);
            $vet_db["horned_quantity_spouts"] = $form->int_db($_REQUEST['horned_quantity_spouts']);

            // Define valores padrão caso os campos estejam vazios ou inválidos.
            if (is_numeric($vet_db["total_weight_spouts"]) && $vet_db["total_weight_spouts"] > 0) {
                $vet_db["medium_weight_spouts"] = round(
                    ($vet_db["evaluated_quantity_spouts"] / $vet_db["total_weight_spouts"]) * 100, 2
                );
            
            } else {
                $vet_db["medium_weight_spouts"] = 0;
            }

            if($vet_db["lot_spouts"] == "NULL")
            $AlertJquery->addAlert("O Campo 'Classificação de Lote' é obrigatório!");
            if($vet_db["seed_rank_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Classificação de Semente' é obrigatório!");
            if($vet_db["sector_rank_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Setor' é obrigatório!");
            if($vet_db["evaluated_quantity_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Avaliada' é obrigatório!");
            if($vet_db["total_weight_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Peso Total' é obrigatório!");
            if($vet_db["minor_injury_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Machucado Leve' é obrigatório!");
            if($vet_db["severe_injury_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Machucado Grave' é obrigatório!");
            if($vet_db["mid_rotten_quantity_pouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Podre Leve' é obrigatório!");
            if($vet_db["serious_rotten_quantity_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Podre Grave' é obrigatório!");
            if($vet_db["amended_quantity_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Emendados' é obrigatório!");
            if($vet_db["monkey_quantity_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Macaquinho' é obrigatório!");
            if($vet_db["filipado_quantity_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Filipado' é obrigatório!");
            if($vet_db["horned_quantity_spouts"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Chifrudinho' é obrigatório!");

            // Verifica se há algum alerta a ser exibido.
            if($AlertJquery->hasAlert())
                // Se houver alertas, exibe-os e redireciona para a página "/stock". O número 2 provavelmente indica o tipo de alerta (ex: erro).
                $AlertJquery->printAlert(2, "/spouts");
                // Se não houver alertas (ou seja, os dados são válidos), chama o método stockInsert do model para inserir os dados no banco de dados.
                $model->spoutsInsert($vet_db);
                // Adiciona uma mensagem de sucesso.
                $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
        }

    }

}