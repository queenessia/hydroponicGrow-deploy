<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    
    <style>
        /* Style untuk input email yang disabled */
        .input-group input:disabled {
            background-color: #f5f5f5;
            color: #000000;
            cursor: not-allowed;
            border: 1px solid #ddd;
        }
        
        .email-display {
            background-color: #f8f9fa;
            padding: 14px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            font-weight: 500;
            color: #000000;
            margin-bottom: 10px;
        }
        
        .email-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }
        
        /* Style untuk password toggle */
        .password-input-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 14px;
            transition: color 0.3s ease;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-toggle:hover {
            color: #333;
        }
        
        .input-group input[type="password"],
        .input-group input[type="text"] {
            padding-right: 35px;
        }
    </style>
</head>
<body>
    
    <div class="back-button" onclick="window.location.href='{{ route('sign_in') }}'">
        <i class="fas fa-arrow-left"></i>
    </div>
    
    <div class="logo-section">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" />
        <h2 class="amita-bold" style="font-size: 36px; margin: 10px 0;">HydroponicGrow</h2>
    </div>
    
    <div class="container">
        <div class="box">
            <p class="title">Reset Your Password</p>
            
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success" style="color: green; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                
                <!-- Input token yang disembunyikan -->
                <input type="hidden" name="token" value="{{ $token }}">
                
                <!-- Input email yang disembunyikan untuk dikirim ke server -->
                <input type="hidden" name="email" value="{{ $email }}">
                
                <!-- Input email yang disabled tapi menampilkan email asli -->
                <div class="input-group">
                    <label for="email_display">Email Account</label>
                    <input type="email" id="email_display" value="{{ $email }}" disabled />
                </div>
                
                <!-- Input untuk password baru -->
                <div class="input-group">
                    <label for="password">New Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter new password" required />
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('password')" id="togglePassword"></i>
                    </div>
                </div>
                
                <!-- Input untuk konfirmasi password baru -->
                <div class="input-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required />
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('password_confirmation')" id="togglePasswordConfirmation"></i>
                    </div>
                </div>
                
                <button type="submit" class="signup-button">
                    <i class="fas fa-key" style="margin-right: 8px;"></i>
                    Reset Password
                </button>
            </form>
        </div>
    </div>
    
    <script>
        // Function untuk toggle password visibility
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = inputId === 'password' ? 
                document.getElementById('togglePassword') : 
                document.getElementById('togglePasswordConfirmation');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Refresh CSRF token setiap 30 menit untuk mencegah page expired
        setInterval(function() {
            fetch('/csrf-token')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    let tokenInput = document.querySelector('input[name="_token"]');
                    if (tokenInput) {
                        tokenInput.value = data.csrf_token;
                    }
                })
                .catch(error => {
                    console.log('CSRF refresh failed:', error);
                });
        }, 1800000); // 30 minutes
    </script>
    
</body>
</html>