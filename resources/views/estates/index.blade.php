@extends('layouts.layoutblade')

@section('blade_content')

    @include('partials.headers.immobilien.immobilien-header')

    @livewire('filter-component-var', ['collectionName' => 'estate_entries'])

    @include('partials.newsletter.newsletter-broad-full-width')

@endsection
