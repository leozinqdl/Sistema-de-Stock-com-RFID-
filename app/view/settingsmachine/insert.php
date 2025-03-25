<div class="page-title">Configurações Maquina</div>

<form id="formulario" action="<?=URL_BASE?>/settingsmachine/insert" method="post" class="col s12">
    <div class="form_inputs">

        <div>
            <label for="machine_settings_right_settings_machine">Configurações da maquina(Direita) :</label><br />
            <input name="machine_settings_right_settings_machine" type="text" id="machine_settings_right_settings_machine" require_once>
        </div>

        <div>
            <label for="machine_settings_left_settings_machine">Configurações da maquina(Esquerda) :</label><br />
            <input name="machine_settings_left_settings_machine" type="text" id="machine_settings_left_settings_machine" require_once>
        </div>

        <div>
            <label for="observations_settings_machine">Observações :</label><br />
            <textarea name="observations_settings_machine" id="observations_settings_machine"></textarea>
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