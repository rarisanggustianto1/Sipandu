<x-app-layout>
    <x-health-card
        :peserta="$peserta"
        :riwayat="$riwayat"
        :back-url="route('kader.peserta.index')"
        back-label="Kembali ke peserta"
        :record-url="route('kader.pemeriksaan.create', ['peserta_id' => $peserta->id])"
    />
</x-app-layout>
