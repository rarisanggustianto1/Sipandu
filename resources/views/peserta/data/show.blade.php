<x-app-layout>
    <x-health-card
        :peserta="$peserta"
        :riwayat="$peserta->pemeriksaan"
        :back-url="route('peserta.data.index')"
        back-label="Kembali ke rekam medis"
    />
</x-app-layout>
