<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificação de Liberação de Armário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        p {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <p>Olá, {{ $user->name }}.</p>

    <p>Seu empréstimo do armário número {{ $armario->numero }} foi liberado devido ao término do seu vínculo com a Universidade de São Paulo.</p>

    

    
</body>
</html>