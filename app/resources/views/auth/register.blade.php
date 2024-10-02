<x-guest-layout>   
    
    
    <style>
            .custom-input {
                margin-right: 10px ,
                margin-left 10px
            }
    </style>


    <x-authentication-card class="max-w-4xl w-full mx-auto p-12 bg-white shadow-lg rounded-lg">
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            <!-- First Row: Nom, Email, Mot de passe -->
            <div class="flex space-x-4 mb-3  ">
                <div class="w-full">
                    <x-label for="name" :value="__('Nom')" />
                    <x-input id="name" type="text" name="name" class="block mt-1 w-full" required autofocus autocomplete="name" />
                    <div class="invalid-feedback">Veuillez entrer votre nom.</div>
                </div>

                <div class="w-full custom-input">
                    <x-label for="email" :value="__('Email')" />
                    <x-input id="email" type="email" name="email" class="block mt-1 w-full custom-input" required autocomplete="email" />
                    <div class="invalid-feedback">Veuillez entrer un email valide.</div>
                </div>

                <div class="w-full">
                    <x-label for="password" :value="__('Mot de passe')" />
                    <x-input id="password" type="password" name="password" class="block mt-1 w-full custom-input" required autocomplete="new-password" />
                    <div class="invalid-feedback">Veuillez entrer un mot de passe.</div>
                </div>
            </div>

            <!-- Second Row: Adresse, Téléphone, CIN, Date de naissance -->
            <div class="flex space-x-4 mb-3">
                <div class="w-full">
                    <x-label for="adresse" :value="__('Adresse')" />
                    <x-input id="adresse" type="text" name="adresse" class="block mt-1 w-full custom-input" autocomplete="adresse" />
                </div>

                <div class="w-full">
                    <x-label for="telephone" :value="__('Téléphone')" />
                    <x-input id="telephone" type="text" name="telephone" class="block mt-1 w-full custom-input" autocomplete="telephone" />
                </div>

                <div class="w-full">
                    <x-label for="cin" :value="__('CIN')" />
                    <x-input id="cin" type="text" name="cin" class="block mt-1 w-full custom-input" autocomplete="cin" />
                </div>

                <div class="w-full">
                    <x-label for="date_naissance" :value="__('Date de naissance')" />
                    <x-input id="date_naissance" type="date" name="date_naissance" class="block mt-1 w-full custom-input" autocomplete="date_naissance" />
                </div>
            </div>

            <!-- Third Row: Rôle -->
            <fieldset class="mb-3">
                <legend>Rôle:</legend>
                <div class="flex space-x-4">
                    <div>
                        <x-input id="role1" type="radio" name="role" value="Responsable_Centre" required />
                        <x-label for="role1" :value="__('Responsable Centre')" />
                    </div>

                    <div>
                        <x-input id="role2" type="radio" name="role" value="Responsable_Entreprise" />
                        <x-label for="role2" :value="__('Responsable Entreprise')" />
                    </div>

                    <div>
                        <x-input id="role3" type="radio" name="role" value="user" />
                        <x-label for="role3" :value="__('Utilisateur Simple')" />
                    </div>
                </div>
            </fieldset>

            <!-- PDF Upload Field -->
            <div id="pdfUpload" class="mb-3" style="display: none;">
                <x-label for="proof_pdf" :value="__('Téléchargez un PDF')" />
                <x-input id="proof_pdf" type="file" name="proof_pdf" class="block mt-1 w-full custom-input" accept="application/pdf" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 me-3" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-button>
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        <script>
            document.querySelectorAll('input[name="role"]').forEach((elem) => {
                elem.addEventListener("change", function(event) {
                    const pdfUploadDiv = document.getElementById("pdfUpload");
                    if (event.target.value === "Responsable_Centre" || event.target.value === "Responsable_Entreprise") {
                        pdfUploadDiv.style.display = "block";
                    } else {
                        pdfUploadDiv.style.display = "none";
                    }
                });
            });
        </script>

    </x-authentication-card>
</x-guest-layout>
