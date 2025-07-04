<?php
// Inicializar variáveis
$nome = $email = $sugestao = "";
$erro_nome = $erro_email = $erro_sugestao = "";
$sucesso = false;

// Validar e processar o formulário quando ele for submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar nome
    if (empty($_POST["nome"])) {
        $erro_nome = "O nome é obrigatório.";
    } else {
        $nome = htmlspecialchars(trim($_POST["nome"]));
    }

    // Validar e sanitizar e-mail
    if (empty($_POST["email"])) {
        $erro_email = "O e-mail é obrigatório.";
    } else {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Por favor, insira um e-mail válido.";
        }
    }

    // Validar sugestão
    if (empty($_POST["sugestao"])) {
        $erro_sugestao = "A sugestão não pode ser vazia.";
    } else {
        $sugestao = htmlspecialchars(trim($_POST["sugestao"]));
    }

    // Se não houver erros, enviar o e-mail
    if (empty($erro_nome) && empty($erro_email) && empty($erro_sugestao)) {
        // Definir o destinatário e o assunto do e-mail
        $destinatario = "seuemail@dominio.com";  // Substitua com seu e-mail
        $assunto = "Sugestão de " . $nome;

        // Corpo do e-mail
        $mensagem = "Nome: " . $nome . "\n";
        $mensagem .= "Email: " . $email . "\n\n";
        $mensagem .= "Sugestão: \n" . $sugestao;

        // Cabeçalhos do e-mail
        $headers = "From: " . $email;

        // Enviar e-mail
        if (mail($destinatario, $assunto, $mensagem, $headers)) {
            $sucesso = true;
        } else {
            $erro_email = "Erro ao enviar a sugestão. Tente novamente mais tarde.";
        }
    }
}

        <!-- Exibindo mensagem de sucesso ou erro -->
        <?php if ($sucesso): ?>
            <p class="sucesso">Obrigado pela sua sugestão, <?= htmlspecialchars($nome) ?>! Nós vamos avaliar e, se necessário, entraremos em contato.</p>
        <?php endif; ?>

        <?php if (!empty($erro_nome)): ?>
            <p class="erro"><?= $erro_nome ?></p>
        <?php endif; ?>

        <?php if (!empty($erro_email)): ?>
            <p class="erro"><?= $erro_email ?></p>
        <?php endif; ?>

        <?php if (!empty($erro_sugestao)): ?>
            <p class="erro"><?= $erro_sugestao ?></p>
        <?php endif; ?>

        <!-- Formulário de Sugestões -->
