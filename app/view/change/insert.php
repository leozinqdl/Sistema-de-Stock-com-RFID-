<?php
// Recuperar o valor passado pela controladora
$lastNewLotChange = $lastNewLotChange ?? null; // Verifica se a variável foi passada para a visão

// Conectar ao banco de dados para obter os lotes já existentes
$dbcon = new DbConnection();
$query = "SELECT new_lot_change FROM tb_change";
$result = $dbcon->Query($query);

$existingLots = [];
while ($row = $dbcon->Fetch()) {
    $existingLots[] = $row['new_lot_change'];
}
?>

<div class="page-title">Troca de Lotes</div>

<form id="formulario" enctype="multipart/form-data" action="<?= URL_BASE ?>/change/insert" method="post" class="col s12">
    <div class="form_inputs">
        <div>
            <label for="new_lot_change">Qual é o lote?</label><br />
            <select name="new_lot_change" id="new_lot_change" required>
                <option value="" selected disabled>Selecione</option>
                <?php
                $lots = [1, 2, 3, 4, 5, 7]; // Lista de lotes disponíveis
                foreach ($lots as $lot) {
                    if (!in_array($lot, $existingLots)) {
                        echo "<option value='$lot'>Lote $lot</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="container_actions">
            <button class="button-reset" type="reset">Limpar</button>
            <button class="button-save" type="submit" id="saveButton">Salvar</button>
        </div>
    </div>
</form>
<script>
    document.getElementById('formulario').addEventListener('submit', function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        // Cria um FormData com os dados do formulário
        const formData = new FormData(this);

        // Envia os dados do formulário via Fetch API
        fetch(this.action, {
                method: this.method,
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // Redireciona após o envio bem-sucedido
                    window.location.href = '<?= URL_BASE ?>/shed/insert';
                } else {
                    console.error('Erro ao enviar o formulário');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
    });
</script>