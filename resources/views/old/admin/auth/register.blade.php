{{-- @extends('layouts.app')
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
        <div class="flex items-center">
            <h1 class="text-3xl font-['Pacifico'] text-primary">{{ LoadConfig()->setup->name ?? null  }}</h1>
        </div>
    </nav>
    <div class="max-w-4xl w-full mx-auto">

        <!-- Register Form -->
        <div class="glassmorphism p-10 rounded-3xl">
            <h2 class="text-3xl font-bold text-indigo-900 mb-6">Create Account</h2>

            <form class="space-y-5" method="post" action="{{ route('admin.register_logic') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 placeholder-indigo-400 text-indigo-900 outline-none border border-blue-200" />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Email</label>
                        <input type="email" id="email" name="email" placeholder="example@email.com" class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 placeholder-indigo-400 text-indigo-900 outline-none border border-blue-200" />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Password</label>
                        <input type="password" id="password" name="password" placeholder="********" class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 placeholder-indigo-400 text-indigo-900 outline-none border border-blue-200" />
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Password Confirmation</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********" class="w-full px-4 py-3 rounded-lg bg-white bg-opacity-20 placeholder-indigo-400 text-indigo-900 outline-none border border-blue-200" />
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg text-lg font-semibold">Sign Up</button>
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-indigo-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span style="background-color: #EEF2FC;" class="bg-opacity-50 px-4 text-indigo-500 font-semibold">OR</span>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <a href="#" class="w-full flex items-center justify-center bg-white bg-opacity-80 border border-indigo-200 text-indigo-900 font-medium py-3 rounded-lg hover:bg-opacity-100 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6 mr-3" alt="Google Logo">
                    Continue with Google
                </a>

                <p class="text-center text-indigo-700 mt-4">Already have an account?
                    <a href="{{ route('admin.login') }}" class="text-primary font-semibold">Sign In</a>
                </p>
            </form>
        </div>

    </div>

</body>
@endsection --}}
