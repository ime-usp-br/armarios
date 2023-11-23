<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificação de Empréstimo de Armário</title>
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

    <p>Seu empréstimo do armário número {{ $armario->numero }} foi realizado com sucesso.</p>

    <p>O uso dos armários é facultativo e se restringe ao período em que o aluno está como ativo junto à Pós-Graduação do IME. Não é permitida a utilização dos armários para guardar alimentos, bebidas e itens molhados (como guarda-chuvas, capas de chuva, etc).</p>

    <p>Os pertences neles depositados são de responsabilidade do usuário. A CPG / CCPs não se responsabilizam pelo extravio, dano ou perda de objetos neles guardados.</p>

    <p>Estou ciente que, ao defender minha tese / dissertação, terei o prazo de 1 (um) mês para desocupá-lo. Após este prazo, os pertences serão retirados e guardados por mais 15 (quinze) dias, sendo doados e destinados da seguinte forma:</p>

    <ul>
        <li>Livros: serão doados para a Biblioteca do Instituto;</li>
        <li>Objetos diversos: serão doados caso haja alguma utilidade.</li>
    </ul>

    <!-- Adicione mais detalhes relevantes aqui -->
</body>
</html>
