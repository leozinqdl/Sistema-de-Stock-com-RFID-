<div class="page-title">Bicas</div>

<form id="formulario" enctype="multipart/form-data" action="<?= URL_BASE ?>/spouts/insert" method="post" class="col s12">
    <div class="form_inputs">

        <div>
            <label for="lot_spouts">Qual é o lote?</label><br />
            <select name="lot_spouts" id="selectform" required>
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
            <label for="seed_rank_spouts">Classificação de Semente :</label><br />
            <select name="seed_rank_spouts" id="selectform">
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
            <label for="sector_rank_spouts">Setor :</label><br />
            <select name="sector_rank_spouts" id="selectform" required>
                <option value="" selected disabled>Selecione</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>

        <div>
            <label for="evaluated_quantity_spouts">Quantidade Avaliada :</label><br />
            <input name="evaluated_quantity_spouts" type="number" id="evaluated_quantity_spouts" required>
        </div>

        <div>
            <label for="total_weight_spouts">Peso Total (g):</label><br />
            <input name="total_weight_spouts" type="number" id="total_weight_spouts" step="0.01" required>
        </div>

        <div>
            <label for="minor_injury_spouts">Quantidade Machucado Leve :</label><br />
            <input name="minor_injury_spouts" type="number" id="minor_injury_spouts" required>
        </div>

        <div>
            <label for="severe_injury_spouts">Quantidade Machucado Grave :</label><br />
            <input name="severe_injury_spouts" type="number" id="severe_injury_spouts" required>
        </div>

        <div>
            <label for="mid_rotten_quantity_spouts">Quantidade Podre Leve :</label><br />
            <input name="mid_rotten_quantity_spouts" type="number" id="mid_rotten_quantity_spouts" required>
        </div>

        <div>
            <label for="serious_rotten_quantity_spouts">Quantidade Podre Grave :</label><br />
            <input name="serious_rotten_quantity_spouts" type="number" id="serious_rotten_quantity_spouts" required>
        </div>

        <div>
            <label for="amended_quantity_spouts">Quantidade Emendados :</label><br />
            <input name="amended_quantity_spouts" type="number" id="amended_quantity_spouts" required>
        </div>

        <div>
            <label for="monkey_quantity_spouts">Quantidade Macaquinho :</label><br />
            <input name="monkey_quantity_spouts" type="number" id="monkey_quantity_spouts" required>
        </div>
        <div>
            <label for="filipado_quantity_spouts">Quantidade Filipado :</label><br />
            <input name="filipado_quantity_spouts" type="number" id="filipado_quantity_spouts" required>
        </div>
        <div>
            <label for="horned_quantity_spouts">Quantidade Chifrudinho :</label><br />
            <input name="horned_quantity_spouts" type="number" id="horned_quantity_spouts" required>
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
                window.location.href = '<?=URL_BASE?>/shed/insert';
            } else {
                console.error('Erro ao enviar o formulário');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });

</script>
