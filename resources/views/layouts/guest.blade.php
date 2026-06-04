<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CVForge') }}</title>

        <script>
            if (localStorage.getItem('theme') === 'dark' ||
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-slate-50 px-4 py-10 text-slate-800 dark:bg-slate-950 dark:text-slate-200">
            <div class="pointer-events-none absolute -top-32 left-1/2 -z-10 h-72 w-[40rem] -translate-x-1/2 rounded-full bg-brand-300/30 blur-3xl dark:bg-brand-700/20"></div>

            <a href="{{ route('home') }}" class="mb-6 flex items-center gap-2 text-2xl font-extrabold tracking-tight">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-600 text-white">C</span>
                <span>CV<span class="text-brand-600 dark:text-brand-400">Forge</span></span>
            </a>

            <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                {{ $slot }}
            </div>

            <a href="{{ route('home') }}" class="mt-6 text-sm text-slate-500 transition hover:text-brand-600 dark:text-slate-400">← Voltar para o início</a>
        </div>
    </body>
</html>
