<?php
class HornanalysisController extends ControllerView
{
    // Método indexAction, provavelmente a ação padrão do controlador
    public function indexAction()
    {
        // Cria uma instância da classe Permission, provavelmente para gerenciar permissões de acesso
        $perm = new Permission();
        // Verifica se há uma sessão ativa. Se não houver, provavelmente redireciona para a página de login ou exibe uma mensagem de erro.
        $perm->isSessionActive();
        // Chama o método run, passando "stock" e "insert" como argumentos.  Isso pode ser usado para definir qual view/template será renderizado, neste caso, relacionado a "stock" e a ação "insert".
        $this->run("hornanalysis","insert");
    }

    // Método insertAction, responsável por lidar com a inserção de dados no estoque
    public function insertAction()
    {
        // Verifica as permissões de sessão, como no método indexAction
        $perm = new Permission();
        $perm->isSessionActive();
        // Chama o método run, semelhante ao indexAction, provavelmente para definir a view/template.
        $this->run("hornanalysis","insert");
        // Cria uma instância do model stockModel, que provavelmente contém as funções para interagir com o banco de dados na tabela de estoque.
        $model = new hornanalysisModel();
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
            $vet_db["total_quantity_teeth_hornanalysis"] = $form->int_db($_REQUEST['total_quantity_teeth_hornanalysis']);
            $vet_db["total_weight_hornanalysis"] = $form->float_db($_REQUEST['total_weight_hornanalysis']);
            $vet_db["quantity_horn_hornanalysis"] = $form->int_db($_REQUEST['quantity_horn_hornanalysis']);
            $vet_db["quantity_tick_hornanalysis"] = $form->int_db($_REQUEST['quantity_tick_hornanalysis']);
            $vet_db["quantity_filipado_hornanalysis"] = $form->float_db($_REQUEST['quantity_filipado_hornanalysis']);
            $vet_db["quantity_amended_hornanalysis"] = $form->int_db($_REQUEST['quantity_amended_hornanalysis']);
            $vet_db["sector_hornanalysis"] = $form->int_db($_REQUEST['sector_hornanalysis']);

            if($vet_db["total_quantity_teeth_hornanalysis"] == "NULL")
            $AlertJquery->addAlert("O Campo 'Classificação de Lote' é obrigatório!");
            if($vet_db["total_weight_hornanalysis"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Classificação de Semente' é obrigatório!");
            if($vet_db["quantity_horn_hornanalysis"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Setor' é obrigatório!");
            if($vet_db["quantity_tick_hornanalysis"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Quantidade Avaliada' é obrigatório!");
            if($vet_db["quantity_filipado_hornanalysis"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Peso Total' é obrigatório!");
            if($vet_db["quantity_amended_hornanalysis"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Peso Médio' é obrigatório!");
            if($vet_db["sector_hornanalysis"] == "NULL")
                $AlertJquery->addAlert("O Campo 'Peso Médio' é obrigatório!");
            // Verifica se há algum alerta a ser exibido.
            if($AlertJquery->hasAlert())
                // Se houver alertas, exibe-os e redireciona para a página "/stock". O número 2 provavelmente indica o tipo de alerta (ex: erro).
                $AlertJquery->printAlert(2, "/hornanalysis");
                // Se não houver alertas (ou seja, os dados são válidos), chama o método stockInsert do model para inserir os dados no banco de dados.
                $model->hornanalysisInsert($vet_db);
                // Adiciona uma mensagem de sucesso.
                $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
        }

    }

}