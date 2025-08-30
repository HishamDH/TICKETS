<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- csrf -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') {{ LoadConfig()->setup->name ?? null  }} Platform</title>
    <link rel="shortcut icon" href="{{ asset('icon.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2D9CDB',
                        secondary: '#27AE60',
                        accent: '#F2994A',
                        background: '#F9FAFB',
                        card: '#FFFFFF',
                        textdark: '#2C3E50',
                        textlight: '#7F8C8D',
                        error: '#EB5757'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">

    @stack('styles')
</head>
@yield('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonText: 'ok!',
            confirmButtonColor: '#6366F1',
            customClass: {
                popup: 'rounded-lg',
                title: 'text-lg font-bold',
                confirmButton: 'px-6 py-2 text-white bg-indigo-600 rounded-lg text-base font-semibold shadow'
            },
        });
    });
</script>
@endif
@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'error',
            text: '{{ session("error") }}',
            confirmButtonText: 'ok!',
            confirmButtonColor: '#6366F1',
            customClass: {
                popup: 'rounded-lg',
                title: 'text-lg font-bold',
                confirmButton: 'px-6 py-2 text-white bg-indigo-600 rounded-lg text-base font-semibold shadow'
            },
        });
    });
</script>
@endif

</html>
