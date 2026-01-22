<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        use App\Models\Content;
        
        // Get settings
        $namaDesa = Content::getContent('settings', 'general', 'nama_desa') ?: Content::getContent('beranda', 'header_website', 'nama_desa', 'Pemerintah Desa');
        
        // Find logo
        $logoPath = null;
        foreach (glob(public_path('images/logo-*')) as $file) {
            $logoPath = basename($file);
            break;
        }
        if (!$logoPath) {
            foreach (glob(public_path('images/logo.*')) as $file) {
                $logoPath = basename($file);
                break;
            }
        }
        
        // Find favicon
        $faviconPath = null;
        foreach (glob(public_path('images/favicon-*')) as $file) {
            $faviconPath = 'images/' . basename($file);
            break;
        }
        if (!$faviconPath) {
            foreach (glob(public_path('images/favicon.*')) as $file) {
                $faviconPath = 'images/' . basename($file);
                break;
            }
        }
    @endphp
    <meta name="description" content="Login Admin - Website Resmi {{ $namaDesa }}">
    <title>Login Admin - Website Resmi {{ $namaDesa }}</title>
    
    <!-- Favicon -->
    @if($faviconPath)
    <link rel="icon" type="image/x-icon" href="{{ asset($faviconPath) }}?v={{ time() }}">
    <link rel="shortcut icon" href="{{ asset($faviconPath) }}?v={{ time() }}">
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    @php
        $manifestPath = public_path('build/manifest.json');
        $cssFile = 'build/assets/app.css';
        $jsFile = 'build/assets/app.js';
        
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            if (isset($manifest['resources/css/app.css']['file'])) {
                $cssFile = 'build/' . $manifest['resources/css/app.css']['file'];
            }
            if (isset($manifest['resources/js/app.js']['file'])) {
                $jsFile = 'build/' . $manifest['resources/js/app.js']['file'];
            }
        }
    @endphp
    <link rel="stylesheet" href="{{ asset($cssFile) }}">
    <script src="{{ asset($jsFile) }}" defer></script>
    
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e5e7eb;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }
        .login-header {
            background: #1e3a8a;
            border-radius: 1rem 1rem 0 0;
        }
    </style>
</head>
<body>
    <div class="w-full max-w-[420px] mx-auto">
        <div class="login-container overflow-hidden">
            <!-- Header -->
            <div class="login-header text-white px-6 py-5 md:px-8 md:py-6 text-center">
                <div class="bg-white text-[#1e3a8a] w-14 h-14 md:w-16 md:h-16 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-3 shadow-lg overflow-hidden">
                    @if($logoPath)
                    <img src="{{ asset('images/' . $logoPath) }}?v={{ time() }}" alt="{{ $namaDesa }}" class="w-10 h-10 md:w-12 md:h-12 object-contain">
                    @else
                    <svg class="w-8 h-8 md:w-9 md:h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    @endif
                </div>
                <h1 class="text-xl md:text-2xl font-bold mb-1">Login Admin</h1>
                <p class="text-xs md:text-sm text-blue-100">Website Resmi {{ $namaDesa }}</p>
            </div>
            
            <!-- Form -->
            <div class="px-6 py-6 md:px-8 md:py-7">
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-5 rounded" role="alert">
                        <p class="font-bold">{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-5 rounded" role="alert">
                        <p class="font-bold mb-2">Login Gagal</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] transition-colors text-base"
                                placeholder="Masukkan email"
                            >
                        </div>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] transition-colors text-base"
                                placeholder="Masukkan password"
                            >
                        </div>
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="w-4 h-4 text-[#1e3a8a] border-gray-300 rounded focus:ring-[#1e3a8a] cursor-pointer"
                            >
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-[#1e3a8a] text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 active:scale-[0.98] text-base"
                    >
                        Masuk
                    </button>
                </form>
                
                <!-- Back to Home -->
                <div class="mt-5 pt-4 border-t border-gray-200 text-center">
                    <a href="{{ route('beranda') }}" class="text-sm text-gray-600 hover:text-[#1e3a8a] transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
