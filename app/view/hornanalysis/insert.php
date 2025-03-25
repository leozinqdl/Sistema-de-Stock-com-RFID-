<div class="page-title">Chifrudinho/Desemenda</div>

<form id="formulario" enctype="multipart/form-data" action="<?= URL_BASE ?>/hornanalysis/insert" method="post" class="col s12">
    <div class="form_inputs">
    
        <div>
            <label for="total_quantity_teeth_hornanalysis">Quantidade Total Dentes :</label><br />
            <input name="total_quantity_teeth_hornanalysis" type="number" id="total_quantity_teeth_hornanalysis" required>
        </div>

        <div>
            <label for="total_weight_hornanalysis">Peso Total (g):</label><br />
            <input name="total_weight_hornanalysis" type="number" id="total_weight_hornanalysis" step="0.01" required>
        </div>

        <div>
            <label for="quantity_horn_hornanalysis">Quantidade Chifrudinho :</label><br />
            <input name="quantity_horn_hornanalysis" type="number" id="quantity_horn_hornanalysis" required>
        </div>

        <div>
            <label for="quantity_tick_hornanalysis">Quantidade Carrapatinho :</label><br />
            <input name="quantity_tick_hornanalysis" type="number" id="quantity_tick_hornanalysis" required>
        </div>

        <div>
            <label for="quantity_filipado_hornanalysis">Quantidade Filipado :</label><br />
            <input name="quantity_filipado_hornanalysis" type="number" id="quantity_filipado_hornanalysis" required>
        </div>

        <div>
            <label for="quantity_amended_hornanalysis">Quantidade Emendado :</label><br />
            <input name="quantity_amended_hornanalysis" type="number" id="quantity_amended_hornanalysis" required>
        </div>

        <div>
            <label for="sector_hornanalysis">Setor :</label><br />
            <select name="sector_hornanalysis" id="selectform" required>
                <option value="" selected disabled>Selecione</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
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
