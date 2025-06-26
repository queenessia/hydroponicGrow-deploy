<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hydroponic Grow</title>
    <link rel="stylesheet" href="{{ asset('css/tanaman.css') }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon dan Icons -->
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('image/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
</head>
<body>
<div class="container">
    <a href="{{ url('/') }}" class="back-button">←</a> 
    
    <h1 class="title">What's You Want To Know</h1>
        <a href="https://drive.google.com/file/d/1OAR0lwxmfyCmSzK8m-W0x5eMmXdNIB3S/view?usp=sharing" 
   target="_blank" 
   class="app-download-section" 
   style="margin-top: 0px; padding: 30px; text-align: center;">
    <p class="download-text" style="margin: 0; font-size: 16px; line-height: 1.5;">
        <strong>Download the app for daily planting guidance complete with daily plant growth monitoring.</strong>
    </p>
</a>
    <div class="grid-container">
         
        {{-- Loop semua tanaman --}}
        @foreach ($plants as $plant)
    <a href="{{ route('plants.show', $plant->id) }}" class="grid-link">
        <div class="grid-item landscape">
            <img src="{{ asset('image/' . $plant->image) }}" alt="{{ $plant->name }}" />
            <div class="text">
                <h3>{{ $plant->name }}</h3>
                <p>{{ $plant->description }}</p>
                <p><strong>Suhu Ideal:</strong> {{ $plant->suhu }}°C</p>
                <div class="click-indicator">
                    <span>Klik untuk detail →</span>
                </div>
            </div>
        </div>
    </a>
@endforeach
     
    </div>
    

</div>

<script src="{{ asset('tanaman.js') }}"></script>
</body>
</html>