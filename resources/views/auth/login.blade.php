@extends('layouts.auth', ['title' => 'Sign In'])

@section('content')
<div class="space-y-8">
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Selamat Datang Kembali.</h1>
        <p class="text-sm text-slate-500 font-medium">Masuk untuk mengelola koleksi dan layanan perpustakaan.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <x-input 
            label="Alamat Email Resmi" 
            type="email" 
            name="email" 
            id="email" 
            :value="old('email')" 
            required 
            autofocus 
            placeholder="nama@techperpus.id"
            :error="$errors->first('email')"
        />

        <div class="space-y-1">
            <x-input 
                label="Kata Sandi" 
                type="password" 
                name="password" 
                id="password" 
                required 
                placeholder="••••••••"
                :error="$errors->first('password')"
            />
            @if (Route::has('password.request'))
                <div class="flex justify-end px-1">
                    <a class="text-xs font-bold text-primary hover:underline" href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                </div>
            @endif
        </div>

        <div class="flex items-center px-1">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-primary shadow-sm focus:ring-primary/20" name="remember">
            <label for="remember_me" class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-3 cursor-pointer">
                Tetap Masuk
            </label>
        </div>

        <div class="pt-2">
            <x-button class="w-full py-4 uppercase tracking-[0.2em] text-xs shadow-xl shadow-primary/20" type="submit">
                Masuk ke Sistem
            </x-button>
        </div>
    </form>

    <div class="text-center pt-4">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
            Belum memiliki akses? 
            <a href="{{ route('register') }}" class="text-primary hover:underline ml-1">Mendaftar</a>
        </p>
    </div>
</div>
@endsection
