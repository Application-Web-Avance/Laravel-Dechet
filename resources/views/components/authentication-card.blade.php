<div class="min-h-screen flex flex-col sm:justify-center items-center pt-50 sm:pt-0 custom-bg">
    <div>
        {{ $logo }}
    </div>

    <div class="w-auto sm:max-w-4xl mt-6 px-8 py-8 bg-white shadow-lg rounded-lg overflow-hidden">
        {{ $slot }}
    </div>
</div>

<style>
    .custom-bg {
        /* Couleur de fond par défaut pendant le chargement */
        background-image: url('{{ asset('storage/images/collectes/backgroundAUTH.jpg') }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    input {
        color: black;
        /* Change the text of inputs to black */
    }

    input::placeholder {
        color: rgba(0, 0, 0, 0.7);
        /* Change the placeholder text color (optional) */
    }

    .py-8 {
        padding-top: 2rem;
        /* Top padding */
        padding-bottom: 2rem;
        /* Bottom padding */
        padding-right: 100px;
        /* Right padding */
        padding-left: 100px;
        /* Left padding */
    }

    /* Adjusting the width of the card to a more fluid size */
    .w-auto {
        width: auto;
        /* Allowing automatic width */
    }
</style>
