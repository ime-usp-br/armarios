<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificação de Empréstimo de Armário para aluno</title>
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

    <p> Empréstimo do armário número {{ $armario->numero }} foi realizado para o aluno {{$user->name}}.</p>

    

    
</body>
</html>