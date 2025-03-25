<div class="page-title">Debulha Mecanica</div>

<form id="formulario" action="<?= URL_BASE ?>/mechanicalthreshing/insert" method="post" class="col s12">
    <div class="form_inputs">

        <div>
            <label for="quantity_teeth_mechanical_threshing">Quantidade(Dentes) :</label><br />
            <input name="quantity_teeth_mechanical_threshing" type="text" id="quantity_teeth_mechanical_threshing">
        </div>

        <div>
            <label for="severe_mechanical_injury_quantity_mechanical_threshing">Quantidade Machucado Mecânico Grave :</label><br />
            <input name="severe_mechanical_injury_quantity_mechanical_threshing" type="text" id="severe_mechanical_injury_quantity_mechanical_threshing">
        </div>

        <div>
            <label for="minor_injury_quantity_mechanical_threshing">Quantidade Machucado Leve :</label><br />
            <input name="minor_injury_quantity_mechanical_threshing" type="text" id="minor_injury_quantity_mechanical_threshing">
        </div>
        <div>
            <label for="number_of_whole_heads_mechanical_threshing">Quantidade de cabeças inteiras :</label><br />
            <input name="number_of_whole_heads_mechanical_threshing" type="number" id="number_of_whole_heads_mechanical_threshing">
        </div>
        <div>
            <label for="observations_mechanical_threshing">Observações :</label><br />
            <textarea name="observations_mechanical_threshing" id="observations_mechanical_threshing"></textarea>
        </div>


        <div class="container_actions">
            <button class="button-reset" type="reset">Limpar</button>
            <button class="button-save" type="submit">Salvar</button>
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