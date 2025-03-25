<?php
// Retorna JSON
header("Content-Type: application/json");

//* Inicia a sessão para acessar os dados do formulário *//
session_start();

//* Verifica se os dados do formulário estão na sessão *//
if (!isset($_SESSION['form_data'])) {
    echo json_encode([["status" => "error", "message" => "Dados do formulário não encontrados.", "epc" => null]]);
    exit;
}

$formData = $_SESSION['form_data'];

class Register
{
    private $formData;

    public function __construct($formData)
    {
        $this->formData = $formData;
    }

    //* Função para obter os dados do leitor RFID *// 
    function getDataFromSDCard()
    {
        $url = "http://192.168.0.10:8080/getTagSDCard";

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout de 5 segundos

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                $errorMessage = 'Erro cURL: ' . curl_error($ch);
                error_log($errorMessage); // Log do erro
                curl_close($ch);
                return null;
            }

            curl_close($ch);

            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $errorMessage = "Erro ao decodificar JSON: " . json_last_error_msg();
                error_log($errorMessage); // Log do erro
                return null;
            }

            return $data;
        } catch (Exception $e) {
            error_log("Erro ao obter dados do RFID: " . $e->getMessage()); // Log do erro
            return null;
        }
    }

    //* Função para salvar ou atualizar os dados no banco de dados remoto *// 
    function saveOrUpdateRemoteDatabase($tags_epx, $tags_date)
    {
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'db_forms';
    
        try {
            $conn = new mysqli($host, $user, $password, $database);
    
            if ($conn->connect_error) {
                error_log("Erro ao conectar ao banco de dados Remoto: " . $conn->connect_error);
                return false;
            }
    
            // Verifica se $this->formData está definido e contém os dados esperados
            if (!isset($this->formData)) {
                error_log("Erro: \$this->formData não está definido.");
                $conn->close();
                return false;
            }
    
            $size_tags = isset($this->formData['seed_rank_spouts']) ? $this->formData['seed_rank_spouts'] : ''; // Tamanho do formulário
            $is_complete_tags = isset($this->formData['subscribe']) ? $this->formData['subscribe'] : 'não'; // Status do palete (sim/não)
            $pallet_identification_tags = isset($this->formData['pallet_identification_tags']) ? $this->formData['pallet_identification_tags'] : ''; // Novo campo
    
            // Inicializa o peso com 450 como padrão
            $weight_tags = 450;
    
            // Verifica se o tamanho é 10r, 11r ou 12r e ajusta o peso para 600
            if (in_array($size_tags, ['10', '11r', '12r'])) {
                $weight_tags = 600;
            }
    
            // Verifica se o palete está completo, se não, o peso é 0
            if ($is_complete_tags != "sim") {
                $weight_tags = 0;
            }
    
            // Verifica se a tag já existe no banco de dados
            $stmtCheck = $conn->prepare("SELECT date_tags FROM tb_tags WHERE epx_tags = ?");
            $stmtCheck->bind_param("s", $tags_epx);
            $stmtCheck->execute();
            $stmtCheck->store_result();
    
            if ($stmtCheck->num_rows > 0) {
                // A tag já existe, verifica o tempo decorrido
                $stmtCheck->bind_result($existing_date);
                $stmtCheck->fetch();
    
                $existing_time = strtotime($existing_date);
                $new_time = strtotime($tags_date);
    
                if (($new_time - $existing_time) < 30) {
                    // Não pode salvar, ainda não passou o tempo mínimo de 30 segundos
                    $stmtCheck->close();
                    $conn->close();
                    return false;
                }
    
                // Atualiza a tag existente
                $stmtUpdate = $conn->prepare("UPDATE tb_tags SET date_tags = ?, size_tags = ?, is_complete_tags = ?, weight_tags = ?, pallet_identification_tags = ? WHERE epx_tags = ?");
                $stmtUpdate->bind_param("sssiss", $tags_date, $size_tags, $is_complete_tags, $weight_tags, $pallet_identification_tags, $tags_epx);
                $stmtUpdate->execute();
                $stmtUpdate->close();
            } else {
                // Insere uma nova tag
                $stmtInsert = $conn->prepare("INSERT INTO tb_tags (epx_tags, date_tags, size_tags, is_complete_tags, weight_tags, pallet_identification_tags) VALUES (?, ?, ?, ?, ?, ?)");
                $stmtInsert->bind_param("ssssis", $tags_epx, $tags_date, $size_tags, $is_complete_tags, $weight_tags, $pallet_identification_tags);
                $stmtInsert->execute();
                $stmtInsert->close();
            }
    
            $stmtCheck->close();
            $conn->close();
            return true;
        } catch (Exception $e) {
            error_log("Erro ao salvar no banco de dados: " . $e->getMessage());
            return false;
        }
    }

    //* Função para processar as tags recebidas *// 
    function processTags($tags)
    {
        if (empty($tags)) {
            return [["status" => "error", "message" => "Nenhuma tag lida.", "epc" => null]];
        }

        $results = [];
        foreach ($tags as $tag) {
            if (isset($tag['reading_epc_hex'], $tag['reading_created_at'])) {
                $tags_epx = $tag['reading_epc_hex'];
                $tags_date = $tag['reading_created_at'];

                // Tenta salvar ou atualizar no banco remoto
                $result = $this->saveOrUpdateRemoteDatabase($tags_epx, $tags_date);
                if ($result) {
                    $results[] = [
                        "status" => "success",
                        "message" => "Tag salva ou atualizada com sucesso.",
                        "epc" => $tags_epx // Inclui o EPC da tag no retorno
                    ];
                } else {
                    $results[] = [
                        "status" => "error",
                        "message" => "Erro ao salvar ou atualizar tag.",
                        "epc" => $tags_epx // Inclui o EPC da tag no retorno
                    ];
                }
            }
        }

        return $results;
    }

    //* Função principal para processar e retornar os dados *// 
    function rfidData()
    {
        $data = $this->getDataFromSDCard();

        if ($data && isset($data['data'])) {
            $results = $this->processTags($data['data']);
        } else {
            $results = [["status" => "error", "message" => "Nenhuma leitura encontrada.", "epc" => null]];
        }

        // Retorna a resposta em JSON
        echo json_encode($results);
    }
}

//*** Executa o processo ***// 
$register = new Register($formData);
$register->rfidData();