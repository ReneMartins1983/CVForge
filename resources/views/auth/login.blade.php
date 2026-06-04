<x-guest-layout>
    @php
        $inputCls = 'mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:ring-brand-900/60';
        $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300';
    @endphp

    <h1 class="text-xl font-bold">Entrar</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Acesse sua conta para gerenciar seus currículos.</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="email" class="{{ $labelCls }}">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="{{ $inputCls }}">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="{{ $labelCls }}">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="{{ $inputCls }}">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 shadow-sm focus:ring-brand-500 dark:border-slate-600 dark:bg-slate-800">
                <span class="ms-2 text-sm text-slate-600 dark:text-slate-400">Lembrar de mim</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-brand-600 hover:underline dark:text-brand-400" href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            Entrar
        </button>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Não tem conta?
            <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400">Criar conta</a>
        </p>
    </form>
</x-guest-layout>
