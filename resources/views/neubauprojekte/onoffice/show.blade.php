@extends('layouts.layoutblade')

@section('blade_content')
<nav
    id="toggleMobileMenu"
    class="sticky z-10 top-20 flex items-center bg-transparent justify-between w-full mx-auto shadow-sm md:block"
    :class="{ 'border-gray-300 bg-opacity- bg-primary': scrolled , 'bg-transparent border-transparent invisible': !scrolled  }"
    x-data="{
        scrolled: false,
        currentSection: '',
        sections: ['#intro', '#units', '#panorama', '#location', '#unit-slider', '#contact'],
        updateCurrentSection() {
            let scrollPosition = window.pageYOffset + 250 ;
            this.currentSection = this.sections.find(section => {
                let el = document.querySelector(section);
                return el && scrollPosition >= el.offsetTop - 250 && scrollPosition < el.offsetTop + el.offsetHeight;
            });
        }
    }"
    @scroll.window="scrolled = (window.pageYOffset > 0); updateCurrentSection()"
    x-init="scrolled = (window.pageYOffset > 0); updateCurrentSection()"
>
    <div class="py-3 px-4 lg:px-6 bg-transparent">
        <div class="flex flex-col justify-center items-center md:flex-row max-w-7xl mx-auto bg-transparent">
            <ul class="grid grid-cols-5 order-2 mt-0 text-sm md:text-base text-center font-medium bg-transparent rounded-lg border border-gray-200 md:flex-row md:order-1 dark:bg-gray-800 dark:border-gray-700 dark:md:bg-gray-900 md:rounded-none md:border-0">
                <li >
                    <a
                        x-bind:class="{ 'bg-gray-100 text-primary': currentSection === '#intro', 'text-white': currentSection !== '#intro' }"
                        href="#intro"
                        class="block py-3 px-4 rounded-lg hover:text-primary-700  hover:bg-gray-50 focus:ring-gray-200 dark:focus:ring-gray-700"
                        aria-current="page"
                    >
                        Intro
                    </a>
                </li>
                <li >
                    <a
                        x-bind:class="{ 'bg-gray-100': currentSection === '#units', 'text-white': currentSection !== '#units'  }"
                        href="#units"
                        class="block py-3 px-4 rounded-lg hover:text-primary-700 dark:text-primary-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover-bg-gray-80 focus:ring-gray-200 dark:focus:ring-gray-700"
                        aria-current="page"
                    >
                        Einheiten
                    </a>
                </li>
                <li >
                    <a
                        x-bind:class="{ 'bg-gray-100': currentSection === '#panorama', 'text-white': currentSection !== '#panorama'  }"
                        href="#panorama"
                        class="block py-3 px-4 rounded-lg hover:text-primary-700 dark:text-primary-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover-bg-gray-80 focus:ring-gray-200 dark:focus:ring-gray-700"
                        aria-current="page"
                    >
                        Panorama
                    </a>
                </li>
                <li >
                    <a
                        x-bind:class="{ 'bg-gray-100': currentSection === '#location', 'text-white': currentSection !== '#location'  }"
                        href="#location"
                        class="block py-3 px-4 rounded-lg hover:text-primary-700 dark:text-primary-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover-bg-gray-80   "
                        aria-current="page"
                    >
                        Lage
                    </a>
                </li>
                <li >
                    <a
                        x-bind:class="{ 'bg-gray-100': currentSection === '#expose', 'text-white': currentSection !== '#expose'  }"
                        href="#expose"
                        class="flex py-3 px-4 rounded-lg hover:text-primary-700 dark:text-primary-500 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover-bg-gray-80 focus:ring-gray-200 "
                        aria-current="page"
                    >
                       Expose
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="w-full -mt-[160px]">
    @include('partials.neubauprojekte.onoffice.detail.header',
        [
            "titleImages" => $titleImages,
        ]
    )
</section>
<section  id="intro">
    <div class="items-center hidden mb-12  bg-white top-28 md:grid md:grid-cols-4">
        @include('partials.neubauprojekte.onoffice.detail.intro',
            [
                "estate" => $estate,
            ]
        )
    </div>
    <div class="pt-16">
        @include('partials.neubauprojekte.onoffice.detail.content-one', [
            "images" => $fotosHuge,
            "estate" => $estate,
        ])
    </div>
</section>

<section class="mx-auto w-full mb-12" id="units">
    <section class="bg-gray-100 w-full">
        @livewire('estate-relation-controller', ['subEstates' => $subEstatesData])
    </section>

    @if(!empty($statamic_project_info))
    <section class="mx-auto w-full mb-12" id="units">
        @include('partials.neubauprojekte.onoffice.detail.content-image-replicator', ['info' => $statamic_project_info])
    </section>
    @endif

    <section class="mx-auto w-full mb-12" id="units">
        @include('partials.neubauprojekte.onoffice.detail.images', ['estate' => $estate])
    </section>
</section>

@if(!empty($statamic_project_info))
<section class="w-full ">
    @include('partials.neubauprojekte.onoffice.detail.lage', ["lage" => $estate["elements"]["lage"], "info" => $statamic_project_info])
</section>
@endif


<section class="w-full  mt-24 lg:mt-32" id="location">
    <section class="bg-gray-100 w-full  mb-12">
        @include('partials.neubauprojekte.onoffice.detail.map', ["lage" => $estate["elements"]["lage"]])
    </section>
</section>



<section class="mx-auto w-full mb-12" id="expose">
    @include('partials.neubauprojekte.onoffice.detail.expose')
</section>


<section class="px-4 mx-auto w-full mb-12" id="unit-slider">
    @livewire('estate-relation-slider-controller', ['subEstatesData' => $subEstatesData])
</section>

<section class="px-4 mx-auto w-full max-w-screen-xl mb-12" id="contact">
    <div class="bg-white pb-6 lg:pb-12">
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">
          <div class="mx-auto max-w-2xl">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Ihr Ansprechpartner</h2>
            <p class="mt-4 text-lg leading-8 text-gray-600">Lorem Ipsum dolor sit amet quamquq.</p>
          </div>
          <ul role="list" class="mx-auto mt-20 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-1">
            <li>
                <img class="mx-auto h-56 w-56 rounded-full" src="data:image/png;base64,{{ $userPhoto }}" alt="">
                <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900">
                    {{$onOfficeUser->vorname}}
                    {{$onOfficeUser->nachname}}
                </h3>
                <ul
                    role="list" class="mt-6 flex justify-center gap-x-6"

                >
                    <li>
                        <a href="mailto:{{$onOfficeUser->email}}" class="text-gray-400 hover:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
                            </svg>

                        </a>
                    </li>
                    {{-- <li>
                        <a href="tel:{{$onOfficeUser["elements"]["Telefon"]}}" class="text-gray-400 hover:text-gray-500">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" />
                            </svg>

                        </a>
                    </li> --}}
              </ul>
            </li>
          </ul>
        </div>
    </div>

    <div class="pt-4 max-w-3xl mx-auto">
        @include('partials.contact-forms.contact-form-standard', [
            'formId' => "2",
            'title' => "Ankauf",
            'defaultMessage' => "Bitte nehmen Sie zum Thema Verkauf Kontakt zu mir auf.",
            'onofficeNote' => "Projektdetail",
        ])
    </div>
</section>

<script>

</script>



@endsection
