@extends('layouts.app')
@section('title','register - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(106, 90, 205, 0.1);
    }
</style>
@endpush

@section('content')
<body class="min-h-screen flex items-center justify-center px-4 py-10">
    <nav class="fixed top-0 left-0 w-full z-50 px-8 py-6 flex justify-between items-center">
        <h1 class="text-3xl font-['Pacifico'] text-primary">{{ LoadConfig()->setup->name ?? null  }}</h1>
    </nav>

    <div class="max-w-4xl w-full mx-auto">
        <div class="glassmorphism p-10 rounded-3xl">
            <h2 class="text-3xl font-bold text-indigo-900 mb-6">Create Account</h2>

            <form class="space-y-5" method="POST" action="{{ route('seller.register_logic') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Full Name</label>
                        <input type="text" name="name" class="w-full px-4 py-3 rounded-lg border border-blue-200" required />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-3 rounded-lg border border-blue-200" required />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-blue-200" required />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Password Confirmation</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-lg border border-blue-200" required />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Role</label>
                        <select id="role" name="role" class="w-full px-4 py-3 rounded-lg border border-blue-200" required>
                            <option value="seller">events</option>
                            <option value="restaurant">restaurant </option>
                        </select>
                    </div>
                </div>

                <!-- Restaurant Only Fields -->
                <div id="restaurant-fields" style="display: none;" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Phone (opitional now)</label>
                        <input type="text" name="phone" class="w-full px-4 py-3 rounded-lg border border-blue-200" />
                    </div>
                    {{-- <div>
                        <label class="block mb-1 text-indigo-700 font-medium">table</label>
                        <input type="text" name="table" class="w-full px-4 py-3 rounded-lg border border-blue-200" />
                    </div> --}}
                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">location (opitional now)</label>
                        <input type="text" name="location" class="w-full px-4 py-3 rounded-lg border border-blue-200" />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">hourly price (opitional now)</label>
                        <input type="text" name="hour_price" class="w-full px-4 py-3 rounded-lg border border-blue-200" />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Description (opitional now)</label>
                        <textarea name="description" class="w-full px-4 py-3 rounded-lg border border-blue-200"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Open At (opitional now)</label>
                        <input type="time" name="open_at" class="w-full px-4 py-3 rounded-lg border border-blue-200" />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Close At (opitional now)</label>
                        <input type="time" name="close_at" class="w-full px-4 py-3 rounded-lg border border-blue-200" />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Image (opitional now)</label>
                        <input type="file" name="image" class="w-full px-4 py-3 rounded-lg border border-blue-200" />
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg text-lg font-semibold mt-6">Sign Up</button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-indigo-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span style="background-color: #EEF2FC;" class="bg-opacity-50 px-4 text-indigo-500 font-semibold">OR</span>
                    </div>
                </div>

                <a href="#" class="w-full flex items-center justify-center bg-white bg-opacity-80 border border-indigo-200 text-indigo-900 font-medium py-3 rounded-lg hover:bg-opacity-100 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6 mr-3" alt="Google Logo">
                    Continue with Google
                </a>

                <p class="text-center text-indigo-700 mt-4">Already have an account?
                    <a href="{{ route('seller.login') }}" class="text-primary font-semibold">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const restaurantFields = document.getElementById('restaurant-fields');

        roleSelect.addEventListener('change', function () {
            if (roleSelect.value === 'restaurant') {
                restaurantFields.style.display = 'block';
            } else {
                restaurantFields.style.display = 'none';
            }
        });
    });
</script>
@endsection


