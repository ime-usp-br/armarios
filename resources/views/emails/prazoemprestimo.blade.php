<!DOCTYPE html>
<html>
<head>
    <title>Fim de Empréstimo de Armário</title>
</head>
<body>
    <h1>Olá, {{ $user->name }}.</h1>
    <p>Seu empréstimo do armário número {{ $emprestimo->armario_id }} vence dia {{ $emprestimo->datafinal}}.</p>
    <!-- Adicione mais detalhes relevantes aqui -->
</body>
</html>