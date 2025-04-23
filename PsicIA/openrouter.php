<?php
function getResponseFromOpenRouter($userMessage) {
    $apiKey = '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';

    $data = [
        "model" => "mistralai/mistral-7b-instruct",
        "messages" => [
            ["role" => "system", "content" => "Você é o PsicIA, uma IA que só fala xingando."],
            ["role" => "user", "content" => $userMessage]
        ]
    ];

    $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
        'Referer: http://localhost',
        'X-Title: PsicIA Chat'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Erro cURL: ' . curl_error($ch);
    }

    curl_close($ch);

    $result = json_decode($response, true);

    // Exibe o retorno bruto da API (só para debug)
    //echo "<pre>" . print_r($result, true) . "</pre>";

    return $result['choices'][0]['message']['content'] ?? "Desculpe, algo deu errado com a IA.";
}
?>
