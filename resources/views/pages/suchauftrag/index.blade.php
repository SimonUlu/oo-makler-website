@extends('layouts.layoutblade')

@section('blade_content')
    <style>
        .choices {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .choices__inner {
            border: 1px solid rgb(229 231 235 / var(--tw-border-opacity));
            display: flex;
        }
        .choices__input {
            margin-bottom: 0;
        }
        .choices__list--multiple .choices__item {
            @apply text-sm text-white border-none bg-primary-600;
        }

        .choices__list--multiple .choices__item.is-highlighted {
            @apply px-3 py-1 text-sm text-white bg-gray-400 border-none;
        }

        /**
         * Hide help text for selection on hover
         */
        .choices__list--dropdown .choices__item--selectable::after,
        .choices__list[aria-expanded] .choices__item--selectable::after {
            display: none;
        }
        .choices__list--dropdown .choices__item--selectable,
        .choices__list[aria-expanded] .choices__item--selectable {
            padding-right: 0;
        }
    </style>
    <section class="relative w-full mt-16 bg-white lg:mt-0 dark:bg-gray-900" x-data="{ showSlide: 1 }">
        <div class="lg:flex">
            <div class="hidden w-full h-screen max-w-md p-12 lg:block bg-primary-600 ">

                <div class="block p-8 text-white rounded-lg bg-primary-500">
                    <h3 class="mb-1 text-2xl font-semibold">Ihre exklusiver Zugang zu unseren neuesten Immobilien</h3>
                    <p class="mb-4 font-light text-primary-100 sm:text-lg">Melden Sie sich jetzt unverbindlich und kostenfrei
                        zu unserem Suchauftrag an!</p>
                    <!-- List -->
                    <ul role="list" class="space-y-4 text-left">
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span>Stetig über neue Immobilien informiert</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span>Passende Immobilien, individuell auf Sie zugeschnitten</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span>Proaktive Informationen direkt in Ihr Postfach</span></span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span>Keine Immobilien-Highlights mehr verpassen</span></span>
                        </li>
                    </ul>
                </div>
            </div>
            @if (session('success'))
                <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="flex items-center mx-auto md:w-[42rem] px-4 md:px-8 xl:px-0">
                <div class="w-full ">
                    <livewire:search-criteria-controller vermarktungsart="kauf" :plz_disable="true" :region_enabled="true"/>
                </div>
            </div>
        </div>
    </section>
@endsection
