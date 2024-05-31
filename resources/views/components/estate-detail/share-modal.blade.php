<div
    class="relative z-50"
    x-show="shareOpen"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
    x-cloak
>
    <div
        class="relative z-50"
        x-show="shareOpen"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
        ></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div
                class="flex items-center justify-center min-h-full p-4 text-center sm:p-0"
            >
                <div
                    @click.outside="shareOpen = false"
                    class="relative px-4 pt-5 pb-4 mx-6 min-w-[18rem] lg:mx-12 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:p-6 sm:my-8 sm:w-full sm:max-w-2xl"
                >
                    <button
                        @click="shareOpen= !shareOpen"
                        class="absolute cursor-pointer top-2 right-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                    <h3 class="mb-8 text-xl font-medium text-center">Teilen</h3>
                    <ul role="list" class="divide-y divide-gray-200">
                        <li class="flex justify-center py-4">
                            <div class="ml-3">
                                <p
                                    id="copy-link"
                                    class="text-sm font-medium text-gray-900 cursor-pointer hover:text-gray-500"
                                >
                                    Link kopieren
                                </p>
                            </div>
                        </li>

                        <li class="flex justify-center py-4">
                            <div class="ml-3">
                                <p
                                    id="copy-email"
                                    class="text-sm font-medium text-gray-900 cursor-pointer hover:text-gray-500"
                                >
                                    Email
                                </p>
                            </div>
                        </li>
                        <li class="flex justify-center py-4">
                            <div class="ml-3">
                                <p
                                    id="copy-whatsapp"
                                    class="text-sm font-medium text-gray-900 cursor-pointer hover:text-gray-500"
                                >
                                    Whatsapp
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- {{-- Javascript Code für die Logik des Teilen Modals --}} -->
<script>
    // Simple Copy
    const copyLink = document.querySelector("#copy-link");
    copyLink.addEventListener("click", function () {
        // Kopieren Sie den aktuellen Link in die Zwischenablage
        navigator.clipboard
            .writeText(window.location.href)
            .then(() => {
                console.log("Link kopiert!");
            })
            .catch((err) => {
                console.error("Fehler beim Kopieren des Links: ", err);
            });
    });

    // Email Copy
    const copyEmail = document.querySelector("#copy-email");
    copyEmail.addEventListener("click", function () {
        const emailLink =
            "mailto:?body=Hier%20ist%20der%20Link%20zu%20meiner%20Seite:%20%0D%0A%0D%0A" +
            encodeURIComponent(window.location.href);
        // Öffnen Sie eine neue E-Mail mit dem aktuellen Link als Inhalt
        window.location.href = emailLink;
    });

    // Whatsapp Copy
    const copyWhatsapp = document.querySelector("#copy-whatsapp");
    copyWhatsapp.addEventListener("click", function () {
        const whatsappLink =
            "https://api.whatsapp.com/send?text=" +
            encodeURIComponent(window.location.href);
        window.open(whatsappLink);
    });
</script>
