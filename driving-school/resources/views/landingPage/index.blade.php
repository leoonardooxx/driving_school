@extends('layouts.landing-page')

@section('content') <div>
    {{-- Hero --}} <section class="min-h-screen flex items-center justify-center px-6">
        <div class="max-w-5xl text-center">
            <p class="text-5xl md:text-7xl font-medium tracking-tight">
                Everything you need to learn, practice, and drive in one place. </p>
        </div>
    </section>


    {{-- Testimonials --}}
    <section class="min-h-screen flex flex-col items-center justify-center px-6 py-20">
        <div class="text-center mb-12">
            <p class="text-3xl md:text-4xl font-medium"> People that loved what we do. </p>
        </div>
        <x-carousel :images="[ '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', ]" />
    </section>
</div>

@endsection
