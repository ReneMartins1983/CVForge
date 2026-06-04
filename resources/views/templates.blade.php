@extends('layouts.app')

@section('title', 'Modelos')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12">
    <div class="text-center">
        <h1 class="text-3xl font-extrabold tracking-tight">Modelos de currículo</h1>
        <p class="mx-auto mt-3 max-w-2xl text-slate-600 dark:text-slate-400">
            10 modelos prontos — 5 sem foto e 5 com foto. Veja como o seu currículo pode ficar,
            sem precisar criar conta.
        </p>
    </div>

    <div class="mt-12 grid justify-items-center gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($samples as $r)
            <div class="flex flex-col items-center">
                <div class="cv-thumb">
                    <div class="cv-thumb__page">
                        <div class="cv-paper">
                            @include('partials.cv', ['resume' => $r, 'photoOverride' => $r->usesPhoto() ? asset('img/avatar-sample.svg') : null])
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-2">
                    <span class="font-semibold">{{ $r->title }}</span>
                    @if ($r->usesPhoto())
                        <span class="rounded-full bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-700 dark:bg-brand-900/40 dark:text-brand-300">📷 com foto</span>
                    @endif
                </div>

                <a href="{{ auth()->check() ? route('resumes.create') : route('register') }}"
                   class="mt-3 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    Usar este modelo
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-14 text-center">
        <a href="{{ auth()->check() ? route('resumes.create') : route('register') }}"
           class="rounded-xl bg-brand-600 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-brand-600/20 transition hover:bg-brand-700">
            Criar meu currículo
        </a>
    </div>
</div>
@endsection
