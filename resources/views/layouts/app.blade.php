<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Becks Apparel - @yield('title')</title>
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                        lime: { 400: '#a3e635', 500: '#84cc16', 600: '#65a30d' },
                        accent: { cyan: '#06b6d4', purple: '#8b5cf6' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Montserrat', 'sans-serif'],
                    },
                    backgroundImage: {
                        'hero-pattern': "url('https://www.transparenttextures.com/patterns/cubes.png')",
                        'gradient': 'linear-gradient(135deg, #a3e635 0%, #06b6d4 100%)',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    },
                    textColor: {
                        'gradient': 'transparent',
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Montserrat:ital,wght@0,700;0,900;1,900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/login-app.js') }}"></script>
    @stack('styles')
</head>
<body x-data="loginApp()" class="bg-navy-950 text-slate-200 antialiased overflow-x-hidden selection:bg-lime-400 selection:text-navy-950">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        lucide.createIcons();
        AOS.init({ duration: 800, once: true, offset: 100 });
    </script>
    
    @include('partials.login-modal')
    @stack('scripts')
</body>
</html>