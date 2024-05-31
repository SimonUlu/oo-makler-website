{{-- COmmented out side bar --}}
<aside class="p-8 ml-4 bg-white rounded-lg shadow xl:block" aria-labelledby="sidebar-label">
    <div class="">
        <h4 class="mt-1 mb-2 text-sm font-bold text-gray-900 uppercase ">Teilen Sie diese
            Seite
        </h4>
        <h3 id="sidebar-label" class="sr-only">Sidebar</h3>
        <div class="not-format">
            <button data-tooltip-target="tooltip-facebook"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" viewBox="0 0 18 18"
                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_13676_82298)">
                        <path
                            d="M18 9C18 4.02943 13.9706 0 9 0C4.02943 0 0 4.02943 0 9C0 13.4921 3.29115 17.2155 7.59375 17.8907V11.6016H5.30859V9H7.59375V7.01719C7.59375 4.76156 8.93742 3.51562 10.9932 3.51562C11.9776 3.51562 13.0078 3.69141 13.0078 3.69141V5.90625H11.873C10.755 5.90625 10.4062 6.60006 10.4062 7.3125V9H12.9023L12.5033 11.6016H10.4062V17.8907C14.7088 17.2155 18 13.4921 18 9Z" />
                    </g>
                    <defs>
                        <clipPath id="clip0_13676_82298">
                            <rect width="18" height="18" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </button>
            <div id="tooltip-facebook" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Teilen auf Facebook
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <button data-tooltip-target="tooltip-email"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" />
                  </svg>

            </button>
            <div id="tooltip-email" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Teilen per Email
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <button data-tooltip-target="tooltip-link"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
            </button>
            <div id="tooltip-link" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Link teilen
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

        </div>

        <div class="my-12 text-center">
            <img class="w-56 h-auto mx-auto" src="/logo_images/logo.png"
                alt="Verlinken Sie uns!">
            <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">
                {{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_name') }}
            </h3>
            <p class="text-sm leading-6 text-gray-600">{{ Statamic\Facades\GlobalSet::find('business_information')->in('default')->get('company_description') }}</p>
            <ul role="list" class="flex justify-center mt-6 gap-x-6">
                <li>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path
                                d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <div class="my-8">
            <h4 class="mb-2 text-sm font-bold text-gray-900 uppercase ">Wir sind Ihr
                Ansprechpartner in der Region</h4>
            <p class="mb-4 text-sm font-light text-gray-500 dark:text-gray-400">Vertrauen Sie auf unsere
                Expertise vor Ort. Denn wir kennen uns im Immobilienmarkt in Musterstadt und Umgebung bestens
                aus
                und können Ihnen somit die perfekte Grundlage für den Kauf und Verkauf von Immobilien
                bieten.
            </p>
        </div>

        <div class="space-y-4">
            <h4 class="text-sm font-bold text-gray-900 uppercase ">Bleiben Sie auf dem
                Laufenden</h4>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">Erhalten Sie regelmäßige
                Updates zu unserem Unternehmen und unseren neuen Angeboten.</p>
            <button type="button" {{-- data-modal-toggle="newsletter-modal" --}}
                class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 text-center w-full"
                onclick="window.location.href='/newsletter'">
                Zum Newsletter anmelden
            </button>
        </div>
    </div>
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shareEmailButton = document.querySelector('[data-tooltip-target="tooltip-email"]');
        const shareFacebookButton = document.querySelector('[data-tooltip-target="tooltip-facebook"]');
        const copyButton = document.querySelector('[data-tooltip-target="tooltip-link"]');


        // Tooltip-Elemente abrufen
        const emailTooltip = document.getElementById('tooltip-email');
        const facebookTooltip = document.getElementById('tooltip-facebook')
        const tooltip = document.getElementById('tooltip-link');


        // Funktion zum Teilen per E-Mail
        function shareByEmail() {
            // URL der aktuellen Seite abrufen
            const currentURL = window.location.href;

            // E-Mail-Betreff und Nachricht vorbereiten
            const emailSubject = encodeURIComponent('Schau dir diese Seite an');
            const emailBody = encodeURIComponent(`Hallo! Schau dir diese Seite an: ${currentURL}`);

            // E-Mail-Verlinkung erstellen
            const emailLink = `mailto:?subject=${emailSubject}&body=${emailBody}`;

            // E-Mail-Verlinkung öffnen
            window.location.href = emailLink;
        }
        // Funktion zum Teilen auf Facebook
        function shareOnFacebook() {
            // URL der aktuellen Seite abrufen und zur Facebook-Sharer-URL hinzufügen
            const currentURL = window.location.href;
            const facebookShareURL = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentURL)}`;

            // Facebook-Sharer-URL öffnen
            window.open(facebookShareURL, '_blank');
        }
        // Funktion zum Kopieren des Links
        function copyLink() {
            // URL der aktuellen Seite abrufen
            const currentURL = window.location.href;
            // Link in die Zwischenablage kopieren
            navigator.clipboard.writeText(currentURL).then(function () {
                // Erfolg - Tooltip anzeigen
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
                // Tooltip nach 3 Sekunden ausblenden
                setTimeout(function () {
                    tooltip.style.visibility = 'hidden';
                    tooltip.style.opacity = '0';
                }, 3000);
            }).catch(function (err) {
                // Fehler beim Kopieren
                console.error('Fehler beim Kopieren des Links: ', err);
            });
        }

        // Klicken-Ereignisse den Buttons hinzufügen
        shareEmailButton.addEventListener('click', function() {
            // Teilen per E-Mail
            shareByEmail();

            // Tooltip ausblenden (optional, falls gewünscht)
            emailTooltip.style.opacity = '0';
            emailTooltip.style.pointerEvents = 'none';
        });

        shareFacebookButton.addEventListener('click', function() {
            // Teilen auf Facebook
            shareOnFacebook();

            // Tooltip ausblenden (optional, falls gewünscht)
            facebookTooltip.style.opacity = '0';
            facebookTooltip.style.pointerEvents = 'none';
        });
        // Klicken-Ereignis dem Button hinzufügen
        copyButton.addEventListener('click', function () {
            // Link kopieren
            copyLink();
        });
    });
</script>
