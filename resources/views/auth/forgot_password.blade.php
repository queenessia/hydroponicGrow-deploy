<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Amita:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/sign_in.css') }}" />
</head>
<body>
    
    <div class="back-button" onclick="window.location.href='{{ route('sign_in') }}';">
        <i class="fas fa-arrow-left"></i>
    </div>
    
    <div class="logo-section">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" />
        <h2 class="amita-bold" style="font-size: 36px; margin: 10px 0;">HydroponicGrow</h2>
    </div>
    
    <div class="container">
        <div class="box">
            <p class="title">Forgot Password</p>
            
            <div style="text-align: center; margin-bottom: 20px; color: #666;">
                <i class="fas fa-key" style="font-size: 48px; margin-bottom: 15px; color: #667eea;"></i>
                <p>Enter your email address and we'll send you a reset token</p>
            </div>
            
            {{-- Tampilkan pesan sukses jika ada --}}
            @if (session('success'))
                <div class="alert alert-success" style="color: green; margin-bottom: 15px; padding: 10px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px;">
                    {{ session('success') }}
                </div>
            @endif
            
            {{-- Tampilkan pesan status jika ada --}}
            @if (session('status'))
                <div class="alert alert-success" style="color: green; margin-bottom: 15px; padding: 10px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px;">
                    {{ session('status') }}
                </div>
            @endif
            
            {{-- Tampilkan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- Form untuk request reset password --}}
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your registered email" required value="{{ old('email') }}" />
                    <small style="color: #666; font-size: 12px; margin-top: 5px; display: block;">
                        We'll send a reset token to this email address
                    </small>
                </div>
                
                <button type="submit" class="signup-button">
                    <i class="fas fa-paper-plane"></i> Send Reset Token
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('sign_in') }}" style="color: #667eea; text-decoration: none; font-size: 14px;">
                    <i class="fas fa-arrow-left"></i> Back to Sign In
                </a>
            </div>
            
        </div>
    </div>
    
</body>
</html>