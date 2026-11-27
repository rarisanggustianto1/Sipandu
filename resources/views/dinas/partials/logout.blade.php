<form method="POST" action="{{ route('logout') }}" class="m-0" onsubmit="return confirm('Yakin ingin keluar dari akun?')">
    @csrf
    <button type="submit" class="dinas-sidebar-logout">
        Keluar
    </button>
</form>
