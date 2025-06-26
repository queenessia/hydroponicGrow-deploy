<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hydroponic Grow</title>
    <link rel="stylesheet" href="{{ asset('css/plant-detail.css') }}" />
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
        <a href="{{ route('plants.index') }}" class="back-button">← Back</a>

        <div class="plant-detail">
            <div class="plant-header">
                <div class="plant-image">
                    <img src="{{ asset('image/' . $plant->image) }}" alt="{{ $plant->name }}" />
                </div>
                <div class="plant-info">
                    <h1>{{ $plant->name }}</h1>
                    <p class="description">{{ $plant->description }}</p>
                    <div class="temperature">
                        <span class="temp-label">Ideal Temperature:</span>
                        <span class="temp-value">{{ $plant->suhu }}°C</span>
                    </div>
                </div>
            </div>

            <div class="detail-content">
                {{-- How to Plant --}}
                <div class="section">
                    <h2>How to Plant {{ $plant->name }} Hidroponik</h2>
                    <ol>
                        @foreach(explode("\n", $plant->cara_menanam) as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ol>
                </div>

                {{-- Kebutuhan Lingkungan --}}
                <div class="section">
                    <h2>Environmental Requirements</h2>
                    <div class="requirements">
                        @foreach(explode("\n", $plant->kebutuhan_lingkungan) as $req)
                            <div class="req-item">{!! $req !!}</div>
                        @endforeach
                    </div>
                </div>

                {{-- Waktu Panen --}}
                <div class="section">
                    <h2>Harvest Time</h2>
                    <p>{{ $plant->waktu_panen }}</p>
                </div>

                {{-- Tips Perawatan --}}
                <div class="section">
                    <h2>Care Tips</h2>
                    <ul>
                        @foreach(explode("\n", $plant->tips_perawatan) as $tip)
                            <li>{{ $tip }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
