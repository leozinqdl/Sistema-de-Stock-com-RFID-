<div class="page-title">Final De Lote </div>

<form id="formulario" enctype="multipart/form-data" action="<?= URL_BASE ?>/endbatch/insert" method="post" class="col s12">
    <div class="form_inputs">

        <div id="new_input">
            <label for="pallet_identification_tags">Codigo de Identificação do palete :</label><br />
            <input type="text" id="pallet_identification_tags" name="pallet_identification_tags">
        </div>

        <div>
            <label for="evaluated_quantity_disposal">Peso por quantidade (kg) :</label><br />
            <input name="evaluated_quantity_disposal" type="number" id="evaluated_quantity_disposal" required>
        </div>

        <div class="container_actions">
            <button class="button-reset" type="reset">Limpar</button>
            <button class="button-save" type="submit">Finalizar</button>
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