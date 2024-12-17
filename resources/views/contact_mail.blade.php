<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $objet }}</title>
</head>

<body>
    <h1>Message de Contact</h1>

    <p><strong>Nom :</strong> {{ $nom }}</p>
    <p><strong>Email :</strong> {{ $email }}</p>

    <h3>Message :</h3>
    <p>{{ $message }}</p>

    <p>Merci de nous avoir contacté !</p>
</body>

</html>
