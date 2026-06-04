<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->title }} — CVForge</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-200 py-8">
    <div class="no-print mx-auto mb-6 flex max-w-[210mm] items-center justify-between px-2">
        <a href="{{ route('resumes.show', $resume) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">← Voltar</a>
        <button type="button" onclick="window.print()"
                class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            Imprimir / Salvar PDF
        </button>
    </div>

    <div class="cv-paper mx-auto max-w-[210mm]">
        @include('partials.cv')
    </div>
</body>
</html>
