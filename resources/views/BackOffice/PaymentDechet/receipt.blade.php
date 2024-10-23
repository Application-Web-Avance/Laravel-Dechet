<!DOCTYPE html>
<html>
<head>
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 50px;
        }
        .details {
            width: 100%;
            margin-bottom: 30px;
        }
        .details td {
            padding: 5px 10px;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Reçu de Paiement</h2>
</div>

<table class="details" border="1" width="100%">
    <tr>
        <td><strong>ID du Paiement</strong></td>
        <td>{{ $payment->id }}</td>
    </tr>
    <tr>
        <td><strong>Utilisateur</strong></td>
        <td>{{ $payment->user->name ?? 'Utilisateur non trouvé' }}</td>
    </tr>
    <tr>
        <td><strong>Annonce de Déchet</strong></td>
        <td>{{ $payment->annonceDechet->titre ?? 'Annonce non trouvée' }}</td>
    </tr>
    <tr>
        <td><strong>Montant</strong></td>
        <td>{{ $payment->price }} TND</td>
    </tr>
    <tr>
        <td><strong>Quantité</strong></td>
        <td>{{ $payment->quantité }}</td>
    </tr>
    <tr>
        <td><strong>Status de Paiement</strong></td>
        <td>{{ ucfirst($payment->payment_status) }}</td>
    </tr>
    <tr>
        <td><strong>Date de Paiement</strong></td>
        <td>{{ $payment->payment_date }}</td>
    </tr>
</table>

<div class="footer">
    <p>Merci pour votre paiement !</p>
</div>

</body>
</html>
