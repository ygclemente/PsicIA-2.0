<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

include('includes/db.php');
include('includes/header.php');

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mensagem'])) {
    $mensagem = trim($_POST['mensagem']);
    if (!empty($mensagem)) {
        // Resposta automática (simples)
        $resposta = "Sinto muito por isso. Quer conversar sobre isso?";

        // Inserir no banco
        $sql = "INSERT INTO mensagens (id_usuario, mensagem, resposta) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $usuario_id, $mensagem, $resposta);
        $stmt->execute();
    }
}

// Buscar mensagens do usuário
$sql = "SELECT mensagem, resposta, enviada_em FROM mensagens WHERE id_usuario = ? ORDER BY enviada_em ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<main>
    <div class="chat-box">
        <p>Bem-vindo, <strong><?php echo $_SESSION['usuario_nome']; ?></strong>!</p>

        <div class="mensagens">
            <?php while ($linha = $resultado->fetch_assoc()): ?>
                <div class="mensagem"><strong>Você:</strong> <?php echo htmlspecialchars($linha['mensagem']); ?></div>
                <div class="resposta"><strong>PsicIA:</strong> <?php echo htmlspecialchars($linha['resposta']); ?></div>
            <?php endwhile; ?>
        </div>

        <form method="post">
            <input type="text" name="mensagem" placeholder="Digite sua mensagem..." required>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <p><a href="logout.php">Sair</a></p>
</main>
