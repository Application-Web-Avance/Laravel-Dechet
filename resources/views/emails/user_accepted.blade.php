<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande Acceptée</title>
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
            width: 140px; /* Correspond à w-35 (taille en pixels) */
            height: 80px; /* Correspond à h-20 (taille en pixels) */
        }
    </style>
</head>                  

<body>
    <div class="container">
        <img src="{{ $message->embed(public_path('recycling-FEAT.png')) }}" alt="Application Logo" />
        <h1>Bonjour {{ $user->name }}</h1>
        <p>Nous sommes heureux de vous informer que votre demande a été acceptée.</p>
        <p>Vous avez été assigné au rôle de <strong>{{ $role }}</strong>.</p>
        <p>Merci de votre confiance et bienvenue parmi nous !</p>
        <p>Cordialement,</p>
        <p>L’équipe de ArtisanCoders</p>
    </div>
</body>
</html>
