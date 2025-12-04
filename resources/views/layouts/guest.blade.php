<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Printex')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --printex-primary: #1e40af;
            --printex-secondary: #991b1b;
            --printex-neutral: #6b7280;
            --printex-accent: #f59e0b;
            --printex-ink: #0b1026;
            --printex-surface: #0f172a;
        }

        body {
            font-family: 'Space Grotesk', 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
            background: #f3f4f6;
            color: #0f172a;
            letter-spacing: 0.01em;
        }

        .btn-printex {
            background: linear-gradient(135deg, #1e40af 0%, #0f2b7b 100%);
            color: #f8fafc;
            border: none;
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.4);
            border-radius: 14px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .btn-printex:hover {
            transform: translateY(-1px);
            color: #fff;
            box-shadow: 0 14px 32px rgba(30, 64, 175, 0.45);
        }

        /* Header */
        .printex-navbar {
            background: linear-gradient(120deg, rgba(15, 23, 42, 0.9), rgba(30, 64, 175, 0.9));
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }

        .printex-navbar .navbar-brand,
        .printex-navbar .nav-link {
            color: #f8fafc !important;
        }

        .printex-navbar .nav-link {
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 0.75rem 1rem;
            position: relative;
            transition: color 0.2s ease, opacity 0.2s ease;
            opacity: 0.85;
        }

        .printex-navbar .nav-link:hover,
        .printex-navbar .nav-link:focus,
        .printex-navbar .nav-link.active {
            opacity: 1;
            color: #fff !important;
        }

        .printex-logo-mark {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: linear-gradient(160deg, #f59e0b 0%, #f97316 45%, #1e40af 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 28px rgba(249, 115, 22, 0.35);
            color: #0f172a;
            font-weight: 900;
            font-size: 1.15rem;
        }

        .printex-brand-title {
            font-size: 1.05rem;
            letter-spacing: 0.18em;
        }

        .printex-brand-subtitle {
            font-size: 0.72rem;
            letter-spacing: 0.16em;
            opacity: 0.75;
        }

        .printex-cart-btn {
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.18);
            padding: 0.55rem 0.7rem;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .printex-cart-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            transform: translateY(-1px);
        }

        .printex-login-btn {
            background: linear-gradient(135deg, #f97316 0%, #f59e0b 100%);
            color: #0f172a;
            border: none;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 0.55rem 1rem;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(249, 115, 22, 0.35);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .printex-login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 38px rgba(249, 115, 22, 0.4);
            color: #0f172a;
        }

        .printex-account-btn {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
        }

        .printex-account-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.16);
        }

        .printex-navbar .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.4);
        }

        .printex-navbar .navbar-toggler-icon {
            filter: invert(1);
        }

        /* Asegura que las imágenes de productos no tengan velos u overlays */
        .ratio img,
        .product-img img,
        .card img {
            mix-blend-mode: normal !important;
            filter: none !important;
            opacity: 1 !important;
        }
        .product-img::before,
        .product-img::after {
            background: transparent !important;
            box-shadow: none !important;
        }

<<<<<<< HEAD
        .chat-fab {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1050;
            border-radius: 999px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.18);
            background: linear-gradient(135deg, #102b7b, #0a1f52);
            color: #fff;
            padding: 0.9rem 1.2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-weight: 700;
        }
        .chat-fab:hover {
            color: #fff;
            transform: translateY(-1px);
=======
        .bg-white {
            color: #0f172a;
        }

        .product-card,
        .course-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .product-card:hover,
        .course-card:hover {
            border-color: rgba(30, 64, 175, 0.35);
            box-shadow: 0 14px 36px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
>>>>>>> 2214b5a79454993be41d344c8d6c222f2b698fef
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    @include('components.navbar')

    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @stack('modals')

    @include('components.footer')
    @include('components.chatbot-widget')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    @stack('scripts')

    @include('components.printbot')
</body>
</html>
