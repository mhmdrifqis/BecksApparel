<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Becks Apparel - The Future of Custom Sportswear')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                        lime: { 400: '#a3e635', 500: '#84cc16' },
                        'accent-cyan': '#06b6d4',
                        'accent-purple': '#a855f7'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Montserrat', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fadeIn': 'fadeIn 0.5s ease-out forwards',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        }
                    },
                    backgroundImage: {
                        'hero-pattern': "url('https://www.transparenttextures.com/patterns/carbon-fibre.png')",
                        'linear-to-br': 'linear-gradient(to bottom right, var(--tw-gradient-stops))',
                        'linear-to-r': 'linear-gradient(to right, var(--tw-gradient-stops))',
                        'linear-to-t': 'linear-gradient(to top, var(--tw-gradient-stops))',
                        'linear-to-tr': 'linear-gradient(to top right, var(--tw-gradient-stops))',
                    }
                }
            }
        }
    </script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Project styles -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/login-app.js') }}"></script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({ duration: 800, once: true });
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</head>
<body class="font-sans antialiased bg-navy-950" x-data="loginApp()">
    @include('partials.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    @include('partials.login-modal')
</body>
</html>
