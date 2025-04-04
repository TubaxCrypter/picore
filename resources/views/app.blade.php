<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- 
            NOT: DaisyUI'nin tema kontrolü için önemli:
            1. Özellikle sayfa yüklendiğinde tema değiştirmek için inline olarak çalışan script
            2. CSS tema denetimleri için doğru sınıf kullanımı (theme-controller) 
            3. data-theme özniteliğini <html> etiketine uygulamak
        -->
        <script>
            (function() {
                try {
                    const savedTheme = localStorage.getItem('theme') || 'light';
                    document.documentElement.setAttribute('data-theme', savedTheme);
                    console.log('Başlangıç teması:', savedTheme);
                } catch (e) {
                    console.error('Tema yüklenirken hata:', e);
                }
            })();
        </script>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
