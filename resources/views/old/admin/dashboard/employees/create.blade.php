@extends('admin.layouts.app')
@section('title', 'Create Employee')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Space Grotesk', sans-serif;
        color: #2c3e50;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 15px 40px rgba(106, 90, 205, 0.12);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }

    /* Container wider and centered */
    .container {
        max-width: 900px;
        margin: 3rem auto 5rem auto;
        padding: 2.5rem 3rem;
        border-radius: 12px;
    }

    label {
        font-weight: 600;
        color: #34495e;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.8px solid #d1d5db;
        border-radius: 10px;
        font-size: 1rem;
        color: #2d3748;
        outline-offset: 2px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    select:focus {
        border-color: #7f9cf5;
        box-shadow: 0 0 0 3px rgba(127, 156, 245, 0.4);
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
    }

    .form-footer button {
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(86, 92, 214, 0.25);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .container {
            padding: 2rem 1.5rem;
            margin: 2rem 1rem 3rem 1rem;
        }
    }
</style>
@endpush

@section('sub_content')
<div class="container glassmorphism">
    <h1 class="text-4xl font-bold mb-8 text-center">Add New Employee</h1>

    <form action="{{ route('admin.employees.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-6">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required autocomplete="off" />
        </div>

        <div class="mb-6">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required autocomplete="off" />
        </div>

        <div class="mb-6">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required />
        </div>

        <div class="mb-8">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                @foreach($usedRoles as $role)
                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
            @endforeach
            </select>
        </div>

        <div class="form-footer">
            <button type="submit" class="gradient-button text-white shadow-md">
                <i class="ri-user-add-line"></i> Create
            </button>
        </div>
    </form>
</div>
@endsection
