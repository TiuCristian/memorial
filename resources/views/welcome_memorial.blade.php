@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Section with picture/slider --}}
    <div class="text-center mb-5">
        <h1 class="display-4">În memoria Danei</h1>
        <p class="lead">O pagină dedicată amintirii și poveștilor celor dragi.</p>
    </div>

    <div id="memorialCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/dana1.jpg') }}" class="d-block w-100 rounded shadow" alt="Dana">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/dana2.jpg') }}" class="d-block w-100 rounded shadow" alt="Dana">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/dana3.jpg') }}" class="d-block w-100 rounded shadow" alt="Dana">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#memorialCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#memorialCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- Button to go to form --}}
    <div class="text-center">
        <a href="{{ route('memories.form') }}" class="btn btn-primary btn-lg">
            Adaugă o amintire
        </a>
    </div>
</div>
@endsection
