<div class="page-title">Descarte </div>

<form id="formulario" enctype="multipart/form-data" action="<?= URL_BASE ?>/disposal/insert" method="post" class="col s12">
    <div class="form_inputs">

        <div>
            <label for="lot_disposal">Qual é o lote? </label><br />
            <select name="lot_disposal" id="selectform" required>
                <option value="" selected disabled>Selecione</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="7">7</option>
            </select>
        </div>

        <div>
            <label for="seed_class_disposal">Classificação de Semente :</label><br />
            <select name="seed_class_disposal" id="selectform">
                <option value="" selected disabled>Selecione</option>
                <option value="10">10</option>
                <option value="11">11 Oval</option>
                <option value="11r">11 Redondo</option>
                <option value="12">12 Oval</option>
                <option value="12r">12 Redondo</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="18+">18+</option>
            </select>
        </div>


        <div>
            <label for="sector_disposal">Setor :</label><br />
            <select name="sector_disposal" id="selectform" required>
                <option value="" selected disabled>Selecione</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>

        <div>
            <label for="evaluated_quantity_disposal">Quantidade Avaliada :</label><br />
            <input name="evaluated_quantity_disposal" type="number" id="evaluated_quantity_disposal" required>
        </div>
        <div>
            <label for="quantity_good_garlic_disposal">Quantidade Alho Bom :</label><br />
            <input name="quantity_good_garlic_disposal" type="number" id="quantity_good_garlic_disposal" step="0.01" required>
        </div>
        <div>
            <label for="amount_chopped_garlic_disposal">Quantidade Alho Emendado :</label><br />
            <input name="amount_chopped_garlic_disposal" type="number" id="amount_chopped_garlic_disposal" step="0.01" required>
        </div>
        <div>
            <label for="amount_monkey_disposal">Quantidade Macaquinho :</label><br />
            <input name="amount_monkey_disposal" type="number" id="amount_monkey_disposal" step="0.01" required>
        </div>
        <div>
            <label for="amount_membership_disposal">Quantidade Filipado :</label><br />
            <input name="amount_membership_disposal" type="number" id="amount_membership_disposal" step="0.01" required>
        </div>
        <div>
            <label for="total_weight_disposal">Peso Total (g):</label><br />
            <input name="total_weight_disposal" type="number" id="total_weight_disposal" step="0.01" required>
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