<div class="min-h-screen flex flex-col sm:justify-center items-center pt-72 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-auto sm:max-w-4xl mt-6 px-8 py-8 bg-white shadow-lg rounded-lg overflow-hidden">
        {{ $slot }}
    </div>
</div>


<style>
    .py-8 {
        padding-top: 2rem;        /* Top padding */
        padding-bottom: 2rem;     /* Bottom padding */
        padding-right: 70px;      /* Right padding */
        padding-left: 70px;       /* Left padding */
    }

    /* Adjusting the width of the card to a more fluid size */
    .w-auto {
        width: auto;               /* Allowing automatic width */
    }
</style>