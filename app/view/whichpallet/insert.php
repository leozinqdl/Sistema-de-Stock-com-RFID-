<div class="page-title">Semente Debulhada</div>

<form id="formulario" enctype="multipart/form-data" action="insertrfid" method="post" class="col s12">
    <div class="form_inputs"><br>
        <h3>Palete está completo? </h3><br>
        <div class="checkbox_div">
            <div class="checkbox_form">
                <input type="radio" id="checkbox_input_sim" name="subscribe" value="sim" required />
                <label for="checkbox_input_sim">SIM! </label>
            </div>
            <div class="checkbox_form">
                <input type="radio" id="checkbox_input_nao" name="subscribe" value="nao" required />
                <label for="checkbox_input_nao">Não! </label>
            </div>
        </div>

        <!-- Novo input que só aparece quando "Não" é selecionado -->
        <div id="new_input" style="display: none;">
            <label for="pallet_identification_tags">Codigo de Identificação do palete :</label><br />
            <input type="text" id="pallet_identification_tags" name="pallet_identification_tags">
        </div>

        <br>
        <div>
            <label for="seed_rank_spouts">Tamanho :</label><br />
            <select name="seed_rank_spouts" id="selectform" required>
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
        <br><br><br>
        <div class="container_actions">
            <button class="button-reset" type="reset">Limpar</button>
            <button class="button-save" type="submit" id="proximo">Próximo</button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxNao = document.getElementById('checkbox_input_nao');
        const checkboxSim = document.getElementById('checkbox_input_sim');
        const novoInput = document.getElementById('new_input');

        checkboxNao.addEventListener('change', function() {
            if (this.checked) {
                novoInput.style.display = 'block';
            }
        });

        checkboxSim.addEventListener('change', function() {
            if (this.checked) {
                novoInput.style.display = 'none';
            }
        });
    });
</script>