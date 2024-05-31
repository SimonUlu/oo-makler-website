@extends('layouts.layoutblade')

@section('blade_content')
    @include('partials.headers.immobilien.immobilien-header')

    @if ($estateSource == 'database')
        @livewire('filter-component-var', ['params' => Request::all(), 'listAppearance' => $listAppearance ?? 'list', 'estateLocations' => $estateLocations ?? null])
    @else
        @livewire('filter-component', ['params' => Request::all(), 'listAppearance' => $listAppearance ?? 'list', 'estateLocations' => $estateLocations ?? null])
    @endif
    @include('partials.newsletter.newsletter-broad-full-width')

    <div id="newsletter-modal" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl p-4 rounded-lg md:h-auto">
            <!-- Modal content -->
            <div class="relative flex items-center bg-white rounded-lg shadow ">
                <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/newsletter/people-at-office.png"
                    class="hidden h-64 rounded-l-lg md:flex" alt="office">
                <div>
                    <button type="button" data-modal-toggle="newsletter-modal"
                        class="text-gray-400 absolute top-3 right-3 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- Modal body -->
                    <div class="p-6 pt-4">
                        <h3 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 ">
                            Melden Sie sich jetzt zu unserem Newsletter an!
                        </h3>
                        <p class="mb-4 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                            Erhalten Sie regelm&auml;&szlig;ig Informationen zu neuen Immobilienangeboten und aktuellen
                            Themen rund um die Immobilie.
                        </p>
                        <form action="#">
                            <div class="items-center max-w-screen-sm mx-auto space-y-4 sm:flex sm:space-y-0">
                                <div class="relative w-full mr-3">
                                    <label for="email"
                                        class="hidden mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Email
                                        address</label>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                            </path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Your email" type="email" id="email" required="">
                                </div>
                                <div>
                                    <button type="submit"
                                        class="w-full px-5 py-3 text-sm font-medium text-center text-white rounded-lg cursor-pointer bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
