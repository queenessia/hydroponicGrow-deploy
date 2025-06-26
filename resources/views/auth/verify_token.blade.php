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
    
    <div class="back-button" onclick="window.location.href='{{ route('forgot') }}'">
        <i class="fas fa-arrow-left"></i>
    </div>
    
    <div class="logo-section">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" />
        <h2 class="amita-bold" style="font-size: 36px; margin: 10px 0;">HydroponicGrow</h2>
    </div>
    
    <div class="container">
        <div class="box">
            <p class="title">Verify Reset Token</p>
            
            <div style="text-align: center; margin-bottom: 20px; color: #666;">
                <i class="fas fa-key" style="font-size: 48px; margin-bottom: 15px; color: #667eea;"></i>
                <p>Please enter the reset token that was sent to your email address</p>
            </div>
            
            {{-- Tampilkan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- Form untuk verify token --}}
            <form method="POST" action="{{ route('verify.token') }}">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required value="{{ session('email') ?? old('email') }}" />
                </div>
                
                <div class="input-group">
                    <label for="token">Reset Token</label>
                    <input type="text" id="token" name="token" placeholder="Enter the token from your email" required value="{{ old('token') }}" />
                    <small style="color: #666; font-size: 12px; margin-top: 5px; display: block;">
                        Check your email inbox and spam folder for the reset token
                    </small>
                </div>
                
                <button type="submit" class="signup-button">Verify Token</button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('forgot') }}" style="color: #667eea; text-decoration: none; font-size: 14px;">
                    <i class="fas fa-arrow-left"></i> Request new token
                </a>
            </div>
            
        </div>
    </div>
    
</body>
</html>