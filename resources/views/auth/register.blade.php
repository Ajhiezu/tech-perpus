@extends('layouts.auth', ['title' => 'Sign Up'])

@section('content')
<div class="space-y-8 animate-in fade-in slide-in-from-right-4 duration-700">
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Mulai Perjalanan Anda.</h1>
        <p class="text-sm text-slate-500 font-medium">Buat akun untuk mulai meminjam koleksi digital kami.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <x-input 
            label="Nama Lengkap" 
            name="name" 
            id="name" 
            :value="old('name')" 
            required 
            autofocus 
            placeholder="John Doe"
            :error="$errors->first('name')"
        />

        <x-input 
            label="Alamat Email" 
            type="email" 
            name="email" 
            id="email" 
            :value="old('email')" 
            required 
            placeholder="john@example.com"
            :error="$errors->first('email')"
        />

        <div class="grid grid-cols-2 gap-4">
            <x-input 
                label="Kata Sandi" 
                type="password" 
                name="password" 
                id="password" 
                required 
                placeholder="••••••••"
                :error="$errors->first('password')"
            />
            <x-input 
                label="Ulangi Sandi" 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                required 
                placeholder="••••••••"
            />
        </div>

        <div class="flex items-start px-1 space-x-3">
            <input id="terms" type="checkbox" required class="mt-1 rounded border-slate-300 text-primary shadow-sm focus:ring-primary/20">
            <label for="terms" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                Saya menyetujui seluruh <a href="#" class="text-primary hover:underline">Syarat & Ketentuan</a> yang berlaku di TechPerpus.
            </label>
        </div>

        <div class="pt-2">
            <x-button class="w-full py-4 uppercase tracking-[0.2em] text-xs shadow-xl shadow-primary/20" type="submit">
                Daftar Sekarang
            </x-button>
        </div>
    </form>

    <div class="text-center pt-4">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-primary hover:underline ml-1">Masuk Saja</a>
        </p>
    </div>
</div>
@endsection
