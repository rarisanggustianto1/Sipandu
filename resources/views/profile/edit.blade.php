<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('peserta.dashboard') }}" 
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-teal-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
            <div class="h-5 w-px bg-gray-200"></div>
            <h2 class="font-bold text-xl text-teal-800 leading-tight">
                {{ __('Pengaturan Profil & Akun') }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
