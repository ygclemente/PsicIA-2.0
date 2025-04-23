<?php
include 'openrouter.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mensagemUsuario = $_POST['mensagem'];

    // Chama a IA
    $respostaIA = getResponseFromOpenRouter($mensagemUsuario);

    // Exibe a conversa (você pode estilizar depois)
    echo "<p><strong>Você:</strong> " . htmlspecialchars($mensagemUsuario) . "</p>";
    echo "<p><strong>PsicIA:</strong> " . htmlspecialchars($respostaIA) . "</p>";

    echo '<br><a href="index.php">Voltar</a>';
}
?>
