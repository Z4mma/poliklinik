<h2>Register</h2>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <label>Nama Lengkap:</label><br>
    <input type="text" name="nama" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br>

    <label>Alamat:</label><br>
    <input type="text" name="alamat" required><br>

    <label>No Hp:</label><br>
    <input type="text" name="no_hp" required><br>

    <label>No KTP:</label><br>
    <input type="text" name="no_ktp" required><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br>

    <label>Konfirmasi Password:</label><br>
    <input type="password" name="password_confirmation"required><br><br>

    <button type="submit">Daftar</button>
</form>

<p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>