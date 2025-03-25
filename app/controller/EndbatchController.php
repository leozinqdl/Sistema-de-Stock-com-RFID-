<?php
class EndbatchController extends ControllerView
{
    public function insertAction()
    {
        $perm = new Permission();
        $perm->isSessionActive();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recebe os valores do formulário
            $pallet_identification_tags = $_POST['pallet_identification_tags'];
            $evaluated_quantity_disposal = $_POST['evaluated_quantity_disposal'];

            // Chama o método para atualizar o peso com base no código do palete
            $endbatchModel = new EndbatchModel();
            if ($endbatchModel->updateWeightTag($pallet_identification_tags, $evaluated_quantity_disposal)) {
                echo "Peso atualizado com sucesso!";
            } else {
                echo "Não foi possível atualizar. Verifique se o código do palete está correto ou se há registros na tabela.";
            }
        } else {
            // Se não for POST, exibe o formulário
            $this->run("endbatch", "insert");
        }
    }
}