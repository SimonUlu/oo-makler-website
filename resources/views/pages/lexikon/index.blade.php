@extends('layouts.layoutblade')

@section('blade_content')

    <div class="flex flex-col items-center justify-top -mt-[100px]">
        @include('partials.headers.news.news-header')
    </div>

    @livewire('glossar-grid')
@endsection