<form method="POST" action="{{ route('logout') }}" style="margin: 0;">
    @csrf
    <button type="submit"
            style="padding: 10px 14px; border: 1px solid #ccc; border-radius: 6px; background: #fff; color: #333; font: inherit; cursor: pointer;">
        Keluar
    </button>
</form>
