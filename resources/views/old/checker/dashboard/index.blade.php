@extends('checker.layouts.app')
@section('title', 'Dashboard - ')



@push('styles')
<style>
    .imgsContainer {
        scrollbar-width: thin;
        /* للفايرفوكس */
        scrollbar-color: #61B2E5 transparent;
        /* لون المقبض والمسار */

        /* كروم و سفاري و ايدج */
    }

    .imgsContainer::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }

    .imgsContainer::-webkit-scrollbar-track {
        background: transparent;
    }

    .imgsContainer::-webkit-scrollbar-thumb {
        background-color: rgba(100, 100, 100, 0.5);
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: content-box;
    }

    .imgsContainer::-webkit-scrollbar-thumb:hover {
        background-color: rgba(100, 100, 100, 0.8);
    }

    .gallery-img {
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .gallery-img:hover {
        transform: scale(1.05);
    }

    .gallery-img:active {
        transform: scale(0.95);
    }

    .gallery-img:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(87, 181, 231, 0.5);
    }

    .gallery-img:focus-visible {
        outline: none;
        box-shadow: 0 0 0 2px rgba(87, 181, 231, 0.5);
    }

    .gallery-img:focus:not(:focus-visible) {
        box-shadow: none;
    }

    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }

    .gallery-img {
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .gallery-img:hover {
        transform: scale(1.05);
    }
</style>
@endpush