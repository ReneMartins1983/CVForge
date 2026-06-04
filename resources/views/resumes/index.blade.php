@extends('layouts.app')

@section('title', 'Currículos')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Seus currículos</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $resumes->count() }} {{ Str::plural('currículo', $resumes->count()) }} salvo(s)</p>
        </div>
        <a href="{{ route('resumes.create') }}"
           class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            + Criar currículo
        </a>
    </div>

    @if ($resumes->isEmpty())
        <div class="rounded-2xl border-2 border-dashed border-slate-300 px-6 py-16 text-center dark:border-slate-700">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-100 text-2xl dark:bg-brand-900/40">📄</div>
            <h2 class="text-lg font-semibold">Nenhum currículo ainda</h2>
            <p class="mx-auto mt-1 max-w-md text-sm text-slate-500 dark:text-slate-400">
                Crie seu primeiro currículo em minutos: preencha os campos e veja a prévia montando em tempo real.
            </p>
            <a href="{{ route('resumes.create') }}"
               class="mt-6 inline-block rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                Começar agora
            </a>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($resumes as $resume)
                @php $p = $resume->data['personal'] ?? []; @endphp
                <div class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
                    <div class="mb-3 flex items-start justify-between">
                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium capitalize text-brand-700 dark:bg-brand-900/40 dark:text-brand-300">
                            {{ $resume->template }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $resume->updated_at->format('d/m/Y') }}</span>
                    </div>

                    <h2 class="text-lg font-semibold leading-tight">{{ $resume->title }}</h2>
                    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                        {{ $p['name'] ?? '—' }}@if (!empty($p['title'])) · {{ $p['title'] }}@endif
                    </p>

                    <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4 dark:border-slate-800">
                        <a href="{{ route('resumes.show', $resume) }}"
                           class="flex-1 rounded-lg bg-slate-100 px-3 py-2 text-center text-sm font-medium text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                            Ver
                        </a>
                        <a href="{{ route('resumes.edit', $resume) }}"
                           class="flex-1 rounded-lg bg-slate-100 px-3 py-2 text-center text-sm font-medium text-slate-700 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('resumes.destroy', $resume) }}"
                              onsubmit="return confirm('Remover este currículo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30"
                                    aria-label="Remover">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
