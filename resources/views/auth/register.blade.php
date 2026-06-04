<x-guest-layout>
    @php
        $inputCls = 'mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:ring-brand-900/60';
        $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300';
    @endphp

    <h1 class="text-xl font-bold">Criar conta</h1>
    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Leva menos de um minuto. É grátis.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="name" class="{{ $labelCls }}">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="{{ $inputCls }}">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="{{ $labelCls }}">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="{{ $inputCls }}">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="{{ $labelCls }}">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="{{ $inputCls }}">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="{{ $labelCls }}">Confirmar senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="{{ $inputCls }}">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            Criar conta
        </button>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Já tem conta?
            <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400">Entrar</a>
        </p>
    </form>
</x-guest-layout>
