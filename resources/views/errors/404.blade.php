<main class="flex items-center justify-center min-h-[80vh] outer-grid" id="content">
    <div class="flex flex-col items-center justify-center w-full max-w-2xl px-4 mx-auto space-y-8">
        @include('statamic-peak-seo::errors.entry_content')

        @if (!empty($title))
            <h2 class="text-4xl font-bold text-center text-gray-900">{{ $title }}</h2>
        @endif
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-center text-gray-900">
                Lassen Sie uns sehen, was wir tun können. Wie wäre es mit einer
                der folgenden Seiten?
            </h3>
        </div>
        <div class="flow-root max-w-lg mx-auto mt-16 sm:mt-20">
            <ul role="list" class="-mt-6 border-b divide-y divide-gray-900/5 border-gray-900/5">
                <li class="relative flex py-6 gap-x-6">
                    <div
                        class="flex items-center justify-center flex-none w-10 h-10 rounded-lg shadow-sm ring-1 ring-gray-900/10">
                        <svg class="w-6 h-6 text-primary-200" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M6 3a3 3 0 00-3 3v12a3 3 0 003 3h12a3 3 0 003-3V6a3 3 0 00-3-3H6zm1.5 1.5a.75.75 0 00-.75.75V16.5a.75.75 0 001.085.67L12 15.089l4.165 2.083a.75.75 0 001.085-.671V5.25a.75.75 0 00-.75-.75h-9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-auto">
                        <h3 class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="/immobilien">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Immobilien
                            </a>
                        </h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Sehen Sie sich unsere Immobilien an.
                        </p>
                    </div>
                    <div class="self-center flex-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </li>

                <li class="relative flex py-6 gap-x-6">
                    <div
                        class="flex items-center justify-center flex-none w-10 h-10 rounded-lg shadow-sm ring-1 ring-gray-900/10">
                        <svg class="w-6 h-6 text-primary-200" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M5.625 3.75a2.625 2.625 0 100 5.25h12.75a2.625 2.625 0 000-5.25H5.625zM3.75 11.25a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5H3.75zM3 15.75a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75zM3.75 18.75a.75.75 0 000 1.5h16.5a.75.75 0 000-1.5H3.75z" />
                        </svg>
                    </div>
                    <div class="flex-auto">
                        <h3 class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="eigentuemer">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Eigentuemer
                            </a>
                        </h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Alle Informationen für Eigentümer von Immobilien.
                        </p>
                    </div>
                    <div class="self-center flex-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </li>

                <li class="relative flex py-6 gap-x-6">
                    <div
                        class="flex items-center justify-center flex-none w-10 h-10 rounded-lg shadow-sm ring-1 ring-gray-900/10">
                        <svg class="w-6 h-6 text-primary-200" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.966 0 1.89.166 2.75.47a.75.75 0 001-.708V4.262a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3a9.707 9.707 0 00-5.25 1.533v16.103z" />
                        </svg>
                    </div>
                    <div class="flex-auto">
                        <h3 class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="/blog">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Immobilienblog
                            </a>
                        </h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Informieren Sie sich über aktuelle Themen.
                        </p>
                    </div>
                    <div class="self-center flex-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </li>
            </ul>
            <div class="flex justify-center mt-10">
                <a href="/" class="text-sm font-semibold leading-6 text-primary-200">
                    <span aria-hidden="true">&larr;</span>
                    Zurück zur Startseite
                </a>
            </div>
        </div>
    </div>
</main>
