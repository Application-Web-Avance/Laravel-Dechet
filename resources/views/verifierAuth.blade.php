<x-guest-layout class="bg-aquamarine">

    <x-authentication-card class="max-w-4xl w-full mx-auto p-12 bg-white shadow-lg rounded-lg">
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <title>Vérification</title>

        <style>
            /* Styles CSS pour le texte */
            .text-black {
                color: black;
            }

            /* Styles pour le bouton */
            .btn-home {
                display: inline-block;
                padding: 10px 20px;
                margin-top: 20px;
                background-color: #4CAF50; /* Couleur de fond verte */
                color: white; /* Couleur du texte */
                border: none;
                border-radius: 5px;
                text-decoration: none; /* Supprimer le soulignement */
                font-size: 1rem;
                transition: background-color 0.3s; /* Animation pour le hover */
            }

            .btn-home:hover {
                background-color: #45a049; /* Couleur de fond au hover */
            }

            /* Ajoutez des styles pour le design professionnel */
            .icon {
                margin-right: 10px; /* Espace entre l'icône et le texte */
            }

            .message {
                font-size: 1.1rem;
                line-height: 1.5;
                margin-top: 20px;
                padding: 10px;
                background-color: #f9f9f9; /* Couleur de fond pour le message */
                border-left: 4px solid #4CAF50; /* Bordure verte */
            }
        </style>

        <body>
            <h1 class="text-black">Vérification de l'authentification</h1>
            <p class="text-black">Veuillez vérifier les informations fournies pour le CIN : <strong>{{ $cin }}</strong></p>
            
            <div class="message text-black">
                <span class="icon">📩</span> <!-- Icône de message -->
                Votre demande d'inscription a été effectuée avec succès. Nous allons vérifier vos documents, et un email vous sera envoyé en cas d'acceptation ou de refus.
            </div>

            <!-- Lien vers la page d'accueil -->
            <a href="{{ route('FrontHome') }}" class="btn-home">Retour à l'accueil</a>
        </body>
    </x-authentication-card>
</x-guest-layout>
