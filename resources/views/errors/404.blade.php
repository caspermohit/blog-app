<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $message ?? '404 - Page Not Found' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.6.2/dist/dotlottie-wc.js" type="module"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="mb-8">
            <!-- 404 Animation -->
            <div class="mb-6">
                <dotlottie-wc 
                    src="https://lottie.host/c50308f3-decf-4467-8f72-031c93827b1d/e8XKN2WomY.lottie" 
                    style="width: 300px; height: 300px" 
                    speed="1" 
                    autoplay 
                    loop
                    class="mx-auto">
                </dotlottie-wc>
            </div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                {{ $message ?? 'Page Not Found' }}
            </h2>
            @if(isset($error))
                <p class="text-gray-600 mb-6">{{ $error }}</p>
            @endif
        </div>
        
        <div class="space-x-4">
            <a href="{{ route('dashboard') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Go to Dashboard
            </a>
            <a href="{{ route('posts.index') }}" 
               class="inline-block bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                Go to Posts
            </a>
            <a href="{{ url('/') }}" 
               class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                Go Home
            </a>
        </div>
    </div>


</body>
</html>