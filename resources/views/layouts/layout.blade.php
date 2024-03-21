<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Callify')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('additional-css')
</head>
<body>
    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Global JavaScript files -->
  <!-- jQuery 3.7.0 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <!-- lottie-player -->
   <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
   <!-- main js -->
   <script src="js/app.js"></script>
   <script src="js/audioplayer.js"></script>
   <!-- aos animation -->
   <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
   <script src="js/slick-setting.js"></script>
   <!-- slick slider -->
   <script type="text/javascript" src="slick/slick.min.js"></script>
   <script type="text/javascript" src="slick/slick-slider.js"></script>
   <!-- bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('additional-js')
</body>
</html>
