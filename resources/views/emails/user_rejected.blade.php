<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande Rejetée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        img {
            width: 140px; /* Ajustez la largeur selon vos besoins */
            height: 80px; /* Ajustez la hauteur selon vos besoins */
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ $message->embed(public_path('recycling-FEAT.png')) }}" alt="Application Logo" />
        <h1>Bonjour {{ $user->name }}</h1>
        <p>Nous sommes désolés de vous informer que votre demande a été rejetée.</p>
        <p>Si vous avez des questions ou si vous souhaitez obtenir plus d'informations, n'hésitez pas à nous contacter.</p>
        <p>Cordialement,</p>
        <p>L’équipe de ArtisanCoders</p>
    </div>
</body>
</html>
