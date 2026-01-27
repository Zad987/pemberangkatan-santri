@extends('layouts.app')

@section('title', 'Login')
@section('body_class', 'login-page')
@section('show_greeting', 'none')

@section('content')
<div class="login-body fade-in">
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
            </div>
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Sistem Manajemen Peserta PPMHA</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            
            <x-input 
                id="username" 
                name="username" 
                type="text"
                label="Username"
                placeholder="Masukkan username"
                :required="true"
                autofocus>
            </x-input>

            <x-input 
                id="password" 
                name="password" 
                type="password"
                label="Password"
                placeholder="••••••••"
                :required="true">
            </x-input>

            <x-button buttonType="submit" block size="lg">
                Masuk Sekarang
            </x-button>
        </form>

        <div class="divider">
            <span>Atau</span>
        </div>

        <a href="{{ route('jadi.pengunjung') }}" class="visitor-link">
            👁️ Lihat sebagai Pengunjung
        </a>
        
        <div class="login-footer">
            &copy; 2026 PPMHA. Terintegrasi & Aman.
        </div>
    </div>
</div>
