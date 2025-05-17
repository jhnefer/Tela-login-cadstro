<?php
try {
    // Conectar ao MySQL via XAMPP
    $pdo = new PDO("mysql:host=localhost;dbname=nerdhub", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pegar dados do formulário com trim para evitar espaços extras
    $nome = trim($_POST['nome_completo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';

    // Validação simples
    if ($senha !== $confirmar) {
        header("Location: ../../cadastro.php?erro=senhas_nao_coincidem");
        exit;
    }

    if (!$nome || !$email || !$senha) {
        header("Location: ../../cadastro.php?erro=campos_vazios");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../../cadastro.php?erro=email_invalido");
        exit;
    }

    // Verificar se email já existe (evitar duplicidade)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        header("Location: ../../cadastro.php?erro=email_ja_cadastrado");
        exit;
    }

    // Inserir no banco (armazenar senha com hash)
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome_completo, email, senha_hash) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);

    header("Location: ../../cadastro.php?sucesso=cadastro_realizado");
    exit;

} catch (PDOException $e) {
    // Logar erro real no servidor (não mostrar para usuário)
    // error_log($e->getMessage());
    header("Location: ../../cadastro.php?erro=erro_ao_cadastrar");
    exit;
}
