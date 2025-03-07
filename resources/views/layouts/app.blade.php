<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Railan Zalali">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            /* Color System - Warna utama yang lebih modern */
            --color-primary: #4f46e5;
            /* Indigo yang lebih cerah */
            --color-primary-hover: #4338ca;
            --color-secondary: #0ea5e9;
            /* Sky blue */
            --color-success: #10b981;
            /* Emerald */
            --color-warning: #f59e0b;
            /* Amber */
            --color-danger: #ef4444;
            /* Red */
            --color-info: #6366f1;
            /* Indigo */

            /* Background & Text */
            --color-bg-light: #f9fafb;
            --color-text-primary: #111827;
            --color-text-secondary: #4b5563;
            --color-text-muted: #6b7280;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--color-text-primary);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 0.5em;
        }

        /* Peningkatan typography untuk tabel */
        table {
            font-size: 0.875rem;
        }

        th {
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        /* Card styling */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            background-color: white;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Button styling yang lebih modern */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--color-primary-hover);
        }

        /* Form styling */
        input,
        select,
        textarea {
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            padding: 0.5rem 0.75rem;
            width: 100%;
            transition: all 0.2s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Badge styling untuk status */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.125rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>

</html>
