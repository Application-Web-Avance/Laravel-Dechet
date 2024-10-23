
<x-guest-layout >
    <style>

        .custom-input {
            margin-right: 10px;
            margin-left: 10px;
        }

        .custom-input-r {
            margin-right: 10px;
        }

        /* Styles for better alignment and spacing */
        .role-input {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .flex {
                flex-direction: column;
                /* Stack elements vertically on smaller screens */
            }

            .flex.space-x-4 {
                flex-direction: column;
                /* Stack the input rows */
            }

            .flex-1 {
                width: 100%;
                /* Full width for smaller screens */
                margin-right: 0;
                /* Remove margin-right */
                margin-left: 0;
                /* Remove margin-left */
            }

            .custom-input,
            .custom-input-r {
                margin-right: 0;
                /* Remove right margin for responsiveness */
                margin-left: 0;
                /* Remove left margin for responsiveness */
                margin-bottom: 10px;
                /* Add bottom margin for spacing */
            }
        }
    </style>

<x-authentication-card class="max-w-4xl w-full mx-auto p-12 bg-white shadow-lg rounded-lg">
    <x-slot name="logo">
        <x-authentication-card-logo />
    </x-slot>

    <x-validation-errors class="mb-4" />

    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
        novalidate>
        @csrf

        <!-- Première ligne: Nom, Email, Mot de passe -->
        <div class="flex space-x-4 mb-3">
            <div class="w-full">
                <x-label for="name" :value="__('Nom')" />
                <x-input id="name" type="text" name="name" class="block mt-1 w-full" required autofocus
                    autocomplete="name" />
            </div>

            <div class="w-full custom-input">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" type="email" name="email" class="block mt-1 w-full" required
                    autocomplete="email" />
            </div>

            <div class="w-full">
                <x-label for="password" :value="__('Mot de passe')" />
                <x-input id="password" type="password" name="password" class="block mt-1 w-full" required
                    autocomplete="new-password" />
            </div>
        </div>

        <!-- Deuxième ligne: Adresse, Téléphone, CIN, Date de naissance -->
        <div class="flex space-x-4 mb-3">
            <div class="w-full custom-input-r">
                <x-label for="adresse" :value="__('Adresse')" />
                <x-input id="adresse" type="text" name="adresse" class="block mt-1 w-full"
                    autocomplete="adresse" />
            </div>

            <div class="w-full custom-input-r">
                <x-label for="telephone" :value="__('Téléphone')" />
                <x-input id="telephone" type="text" name="telephone" class="block mt-1 w-full"
                    autocomplete="telephone" />
            </div>

            <div class="w-full custom-input-r">
                <x-label for="cin" :value="__('CIN')" />
                <x-input id="cin" type="text" name="cin" class="block mt-1 w-full"
                    autocomplete="cin" />
            </div>

            <div class="w-full">
                <x-label for="date_naissance" :value="__('Date de naissance')" />
                <x-input id="date_naissance" type="date" name="date_naissance" class="block mt-1 w-full"
                    autocomplete="date_naissance" />
            </div>
        </div>

        <fieldset class="mb-3">
            <legend>Rôle:</legend>
            <div class="flex flex-col space-y-2">
                <div class="flex items-center role-input">
                    <x-input id="role1" type="radio" name="role" value="Responsable_Centre" required
                        class="mr-2" />
                    <x-label for="role1" :value="__('Responsable Centre')" />
                </div>

                <div class="flex items-center role-input">
                    <x-input id="role2" type="radio" name="role" value="Responsable_Entreprise"
                        class="mr-2" />
                    <x-label for="role2" :value="__('Responsable Entreprise')" />
                </div>

                <div class="flex items-center role-input">
                    <x-input id="role3" type="radio" name="role" value="user" class="mr-2" />
                    <x-label for="role3" :value="__('Utilisateur Simple')" />
                </div>
            </div>
        </fieldset>

        <!-- Champs d'input dynamiques -->
        <div id="additionalFields" style="display: none; margin-bottom: 20px;">
            <div class="flex space-x-4 mb-4">
                <div id="nomPrincipalDiv" class="flex-1 custom-input">
                    <x-label id="nomPrincipalLabel" for="nomPrincipale" :value="__('Nom Principal de l\'Entreprise')" />
                    <x-input id="nomPrincipale" type="text" name="nomPrincipale" class="block mt-1 w-full "
                        style="max-width: 380px;" />
                </div>
                <div id="pdfUpload" class="flex-1 custom-input">
                    <x-label for="proof_pdf" :value="__('Téléchargez un PDF')" class="mb-2" />
                    <x-input id="proof_pdf" type="file" name="proof_pdf" class="block mt-1 w-full "
                        accept="application/pdf" style="max-width: 300px;" />
                </div>
            </div>
        </div>

        <!-- Bouton de soumission -->
        <div class="flex justify-end">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 me-3 mt-2" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>
            <x-button>
                {{ __('S’inscrire') }}
            </x-button>
        </div>
    </form>

    <script>
        document.querySelectorAll('input[name="role"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                const additionalFieldsDiv = document.getElementById("additionalFields");
                const pdfUploadDiv = document.getElementById("pdfUpload");
                const nomPrincipalDiv = document.getElementById("nomPrincipalDiv");
                const nomPrincipalLabel = document.getElementById("nomPrincipalLabel");

                additionalFieldsDiv.style.display =
                    "block"; // Toujours afficher les champs supplémentaires lorsqu'un rôle est sélectionné

                if (event.target.value === "Responsable_Centre") {
                    pdfUploadDiv.style.display = "block";
                    nomPrincipalDiv.style.display = "block";
                    nomPrincipalLabel.innerText = "Nom Principal de Centre"; // Changer le texte de l'étiquette
                } else if (event.target.value === "Responsable_Entreprise") {
                    pdfUploadDiv.style.display = "block";
                    nomPrincipalDiv.style.display = "block";
                    nomPrincipalLabel.innerText = "Nom Principal de l'Entreprise"; // Changer le texte de l'étiquette
                } else {
                    pdfUploadDiv.style.display = "none"; // Masquer le téléchargement du PDF pour 'Utilisateur Simple'
                    nomPrincipalDiv.style.display = "none"; // Masquer Nom Principal pour 'Utilisateur Simple'
                }
            });
        });
    </script>
</x-authentication-card>

</x-guest-layout>


