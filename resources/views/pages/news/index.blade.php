@extends('layouts.layoutblade')

@section('blade_content')

    <div class="flex flex-col items-center justify-top -mt-[80px]">
        @include('partials.headers.news.news-header')
    </div>

    @livewire('news-controller')

    @livewire('estate-search-component')

@endsection
