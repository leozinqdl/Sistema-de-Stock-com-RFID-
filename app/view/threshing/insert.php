<div class="page-title">Debulha Manual</div>

<form id="formulario" enctype="multipart/form-data" action="<?= URL_BASE ?>/threshing/insert" method="post" class="col s12">
  <div class="form_inputs">
    <div>
      <label for="quantity_teeth_threshing">Quantidade de Dentes :</label><br />
      <input name="quantity_teeth_threshing" type="number" id="quantity_teeth_threshing">
    </div>

    <div>
      <label for="amended_quantity_threshing">Quantidade de Emendados :</label><br />
      <input name="amended_quantity_threshing" type="number" id="amended_quantity_threshing">
    </div>

    <div>
      <label for="severe_injury_quantity_threshing">Quantidade Machucado Grave :</label><br />
      <input name="severe_injury_quantity_threshing" type="number" id="severe_injury_quantity_threshing">
    </div>

    <div>
      <label for="minor_injury_quantity_threshing">Quantidade Machucado Leve :</label><br />
      <input name="minor_injury_quantity_threshing" type="number" id="minor_injury_quantity_threshing">
    </div>

    <div>
      <label for="observations_threshing">Observações :</label><br />
      <textarea name="observations_threshing" id="observations_threshing"></textarea>
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