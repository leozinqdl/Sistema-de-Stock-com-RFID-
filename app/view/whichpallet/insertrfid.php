<?php
// Inicia a sessão para armazenar os dados do formulário
session_start();

// Recebe os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form_data'] = [
        'subscribe' => $_POST['subscribe'],
        'seed_rank_spouts' => $_POST['seed_rank_spouts'],
        'pallet_identification_tags' => $_POST['pallet_identification_tags'] // Novo campo
    ];
}
// Verifica se os dados do formulário estão na sessão
if (!isset($_SESSION['form_data'])) {
    die("Dados do formulário não encontrados. Volte ao formulário inicial.");
}
?>

<div class="page-title">Ler Tags</div>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    #output {
        margin-top: 20px;
        padding: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
    }

    .tag-item {
        padding: 10px;
        margin: 5px 0;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .tag-item.success {
        border-left: 5px solid #28a745;
    }

    .tag-item.error {
        border-left: 5px solid #dc3545;
    }
</style>

<body>
    <h1>Registrar RFID</h1>
    <div id="output">Aguardando leituras...</div>
    <br><br>
    <div class="container_actions">
        <button class="button-save" type="button" id="finalizar">Finalizar</button>
    </div>

    <script>
        // Função para atualizar as leituras das tags RFID
        function updateReadings() {
            fetch('register')
                .then(response => {
                    console.log("Resposta do servidor:", response); // Log da resposta
                    if (!response.ok) {
                        throw new Error("Erro na requisição: " + response.statusText);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log("Conteúdo da resposta:", text); // Log do conteúdo bruto
                    try {
                        const data = JSON.parse(text); // Tenta converter para JSON
                        const output = document.getElementById('output');
                        output.innerHTML = '';

                        if (data.length === 0) {
                            output.innerHTML = '<div class="tag-item">Nenhuma tag lida.</div>';
                            return;
                        }

                        data.forEach(tag => {
                            const tagItem = document.createElement('div');
                            tagItem.className = `tag-item ${tag.status === 'success' ? 'success' : 'error'}`;
                            tagItem.innerHTML = `
                        <strong>EPC:</strong> ${tag.epc || 'N/A'}<br>
                        <strong>Status:</strong> ${tag.message}
                    `;
                            output.appendChild(tagItem);
                        });
                    } catch (error) {
                        console.error("Erro ao processar JSON:", error);
                        const output = document.getElementById('output');
                        output.innerHTML = '<div class="tag-item error">Erro ao processar leituras.</div>';
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar tags:', error);
                    const output = document.getElementById('output');
                    output.innerHTML = '<div class="tag-item error">Erro ao carregar leituras.</div>';
                });
        }

        // Atualiza as leituras a cada 2 segundos
        setInterval(updateReadings, 5000);

        // Botão para finalizar o processo
        document.getElementById('finalizar').addEventListener('click', function() {
            alert("Processo finalizado!");
            window.location.href = 'insert';
        });

        // Inicia a primeira leitura imediatamente
        updateReadings();
    </script>
</body>