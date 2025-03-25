<?php
class TagsrfidController extends ControllerView
{
    // Método indexAction, provavelmente a ação padrão do controlador
    public function indexAction()
    {
        // Cria uma instância da classe Permission, provavelmente para gerenciar permissões de acesso
        $perm = new Permission();
        // Verifica se há uma sessão ativa. Se não houver, provavelmente redireciona para a página de login ou exibe uma mensagem de erro.
        $perm->isSessionActive();
        // Chama o método run, passando "stock" e "insert" como argumentos.  Isso pode ser usado para definir qual view/template será renderizado, neste caso, relacionado a "stock" e a ação "insert".
        $this->run("tagsrfid","insert");
    }

    // Método insertAction, responsável por lidar com a inserção de dados no estoque
    public function insertAction()
    {
        // Verifica as permissões de sessão, como no método indexAction
        $perm = new Permission();
        $perm->isSessionActive();
        // Chama o método run, semelhante ao indexAction, provavelmente para definir a view/template.
        $this->run("tagsrfid","insert");
        // Cria uma instância , que provavelmente contém as funções para interagir com o banco de dados na tabela de estoque.
        $model = new tagsrfidModel();
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
            //  tags_id_tags_rfid, name_tags_rfid, product_name_tags_rfid    
            $vet_db['tags_id_tags_rfid'] = $form->string_db($_POST['tags_id_tags_rfid']);
            // $vet_db['product_name_tags_rfid'] =  $form->string_db($_POST['product_name_tags_rfid']);         
            $vet_db['registrations_tags_rfid'] =  $form->string_db($_POST['registrations_tags_rfid']);         
            $vet_db['classifications_tags_rfid'] =  $form->string_db($_POST['classifications_tags_rfid']);         
            $vet_db['type_pallet_tags_rfid'] =  $form->string_db($_POST['type_pallet_tags_rfid']);         


            if($vet_db['tags_id_tags_rfid'] == "NULL") {
                $AlertJquery->addAlert("O Campo 'Qual é a tag' é obrigatório!");
            }
            // if($vet_db['product_name_tags_rfid'] == "NULL") {
            //     $AlertJquery->addAlert("O Campo 'Nome do produto' é obrigatório!");
            // }
            if($vet_db['registrations_tags_rfid'] == "NULL") {
                $AlertJquery->addAlert("O Campo 'classificação' é obrigatório!");
            }
            if($vet_db['classifications_tags_rfid'] == "NULL") {
                $AlertJquery->addAlert("O Campo 'Nome do produto' é obrigatório!");
            }
            if($vet_db['type_pallet_tags_rfid'] == "NULL") {
                $AlertJquery->addAlert("O Campo 'O tipo de palete' é obrigatório!");
            }

            // Verifica se há algum alerta a ser exibido.
            if($AlertJquery->hasAlert())
                // Se houver alertas, exibe-os e redireciona para a página "/stock". O número 2 provavelmente indica o tipo de alerta (ex: erro).
                $AlertJquery->printAlert(2, "/tagsrfid");
                // Se não houver alertas (ou seja, os dados são válidos), chama o método stockInsert do model para inserir os dados no banco de dados.
                $model->tagsrfidInsert($vet_db);
                // Adiciona uma mensagem de sucesso.
                $AlertJquery->addAlert("Troca de lote lançada com sucesso!");
        }

    }

}