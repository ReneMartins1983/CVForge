@extends('layouts.app')

@section('title', $resume->title)

@section('content')
<div class="mx-auto max-w-5xl px-4 py-8">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
         x-data="{ copied: false, copy() { navigator.clipboard.writeText(window.location.href).then(() => { this.copied = true; setTimeout(() => this.copied = false, 2000); }); } }">
        <div>
            <h1 class="text-2xl font-bold">{{ $resume->title }}</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Link público · atualizado {{ $resume->updated_at->diffForHumans() }}
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" @click="copy()"
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                <span x-show="!copied">Copiar link</span>
                <span x-show="copied" x-cloak class="text-emerald-600 dark:text-emerald-400">Copiado!</span>
            </button>
            <a href="{{ route('resumes.edit', $resume) }}"
               class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                Editar
            </a>
            <a href="{{ route('resumes.print', $resume) }}"
               class="rounded-lg bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                Imprimir / PDF
            </a>
        </div>
    </div>

    <div class="cv-paper">
        @include('partials.cv')
    </div>
</div>
@endsection
