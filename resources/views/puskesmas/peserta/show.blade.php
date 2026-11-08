@extends('layouts.app')

@section('title', '— Kartu Kesehatan Peserta')

@section('content')
<x-health-card
    :peserta="$peserta"
    :riwayat="$riwayat"
    :back-url="route('puskesmas.peserta.index')"
    back-label="Kembali ke data peserta"
/>
@endsection
