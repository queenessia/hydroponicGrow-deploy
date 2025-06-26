<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydroponic Grow</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon dan Icons -->
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
    
    <!-- Font dan CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Amita:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sign_up.css') }}">
</head>
<style>
 /* Media Queries untuk Responsiveness */

/* Tablet (768px dan ke bawah) */
@media screen and (max-width: 768px) {
    .container {
        max-width: 90%;
        padding: 0 10px;
    }
    
    .box {
        padding: 18px;
    }
    
    .title {
        font-size: 22px;
    }
    
    .logo-section h2 {
        font-size: 22px;
    }
    
    .logo-section img {
        height: 36px;
    }
}

/* Mobile (480px dan ke bawah) */
@media screen and (max-width: 480px) {
    body {
        padding: 15px;
    }
    
    .container {
        max-width: 100%;
        padding: 0 5px;
    }
    
    .box {
        padding: 15px;
        margin: 0 5px;
    }
    
    .title {
        font-size: 20px;
        margin-bottom: 12px;
    }
    
    .logo-section {
        margin-bottom: 15px;
        flex-direction: column;
        gap: 10px;
    }
    
    .logo-section img {
        height: 32px;
        margin-right: 0;
        margin-bottom: 5px;
    }
    
    .logo-section h2 {
        font-size: 20px;
    }
    
    input {
        padding: 12px;
        font-size: 16px; /* Mencegah zoom pada iOS */
    }
    
    .password-toggle {
        right: 12px;
        top: 38px;
    }
    
    .signup-button {
        padding: 12px;
        font-size: 16px;
    }
    
    .input-group {
        margin: 12px 0;
    }
}

/* Mobile kecil (320px dan ke bawah) */
@media screen and (max-width: 320px) {
    body {
        padding: 10px;
    }
    
    .box {
        padding: 12px;
        margin: 0 2px;
    }
    
    .title {
        font-size: 18px;
    }
    
    .logo-section h2 {
        font-size: 18px;
    }
    
    .logo-section img {
        height: 28px;
    }
    
    input {
        padding: 10px;
    }
    
    .password-toggle {
        right: 10px;
        top: 35px;
    }
}

/* Landscape orientation untuk mobile */
@media screen and (max-height: 600px) and (orientation: landscape) {
    body {
        min-height: auto;
        padding: 10px;
    }
    
    .logo-section {
        margin-bottom: 10px;
    }
    
    .box {
        padding: 15px;
    }
    
    .title {
        font-size: 20px;
        margin-bottom: 10px;
    }
    
    .input-group {
        margin: 8px 0;
    }
}
  </style>
<body>
    
    <!-- Logo dan Tulisan -->
    <div class="logo-section">
        <img src="{{ asset('image/logo.png') }}" alt="Logo">
        <h2 class="amita-bold" style="font-size: 36px; margin: 10px 0;">HydroponicGrow</h2>
    </div>
    
    <!-- Kotak Sign Up -->
    <div class="container">
        <div class="box">
            <p class="title">Sign Up</p>
            
            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- Form Sign Up --}}
            <form action="{{ route('register') }}" method="POST">
             @csrf
                
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                </div>
                
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}" required>
                </div>
                
                <div class="input-group">
                    <label for="namadepan">Nama Depan</label>
                    <input type="text" name="first_name" id="namadepan" placeholder="Nama Depan" value="{{ old('first_name') }}" required>
                </div>
                
                <div class="input-group">
                    <label for="namabelakang">Nama Belakang</label>
                    <input type="text" name="last_name" id="namabelakang" placeholder="Nama Belakang" value="{{ old('last_name') }}" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fas fa-eye-slash password-toggle" id="togglePassword"></i>
                </div>
                
                <div class="input-group">
                    <label for="repassword">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="repassword" placeholder="Konfirmasi Password" required>
                    <i class="fas fa-eye-slash password-toggle" id="toggleRepassword"></i>
                </div>
                
                <button type="submit" class="signup-button">Sign Up</button>
            </form>
            
            <p class="link">
                Sudah punya akun? 
                <a href="{{ route('sign_in') }}" style="color: #2A4E17; text-decoration: underline;">Sign In</a>
            </p>
        </div>
    </div>
    
    <script src="{{ asset('js/sign_up.js') }}"></script>
</body>
</html>
