@extends('layouts.app')

@section('title', 'CVForge')

@section('content')
{{-- Hero --}}
<section class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-24 left-1/2 h-72 w-[40rem] -translate-x-1/2 rounded-full bg-brand-300/30 blur-3xl dark:bg-brand-700/20"></div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-20 text-center sm:py-28">
        <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-600 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
            🚀 Laravel 12 · Tailwind · Alpine.js
        </span>
        <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-extrabold tracking-tight sm:text-5xl">
            Crie um currículo de dev <span class="text-brand-600 dark:text-brand-400">profissional</span> em minutos
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg text-slate-600 dark:text-slate-400">
            Preencha seus dados, veja a prévia montando em tempo real, escolha um tema
            e compartilhe por link ou exporte em PDF. Simples assim.
        </p>
        <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <a href="{{ route('resumes.create') }}"
               class="rounded-xl bg-brand-600 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-brand-600/20 transition hover:bg-brand-700">
                Criar meu currículo
            </a>
            <a href="{{ route('resumes.index') }}"
               class="rounded-xl border border-slate-300 bg-white px-6 py-3 text-base font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                Ver currículos
            </a>
        </div>
    </div>
</section>

{{-- Features --}}
<section class="mx-auto max-w-6xl px-4 pb-24">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @php
            $features = [
                ['⚡', 'Prévia ao vivo', 'Veja o currículo sendo montado enquanto você digita, sem recarregar a página.'],
                ['🎨', '3 temas', 'Moderno, clássico e compacto — troque o visual com um clique.'],
                ['🌙', 'Modo escuro', 'Interface confortável de dia ou de noite, do seu jeito.'],
                ['🔗', 'Link compartilhável', 'Cada currículo ganha um link público para enviar a recrutadores.'],
                ['📄', 'Export em PDF', 'Gere um PDF pronto para imprimir, com layout A4 caprichado.'],
                ['🧩', 'Seções completas', 'Experiência, formação, projetos, habilidades e idiomas.'],
            ];
        @endphp
        @foreach ($features as [$icon, $titulo, $desc])
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-xl dark:bg-slate-800">{{ $icon }}</div>
                <h3 class="text-lg font-semibold">{{ $titulo }}</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</section>
@endsection
