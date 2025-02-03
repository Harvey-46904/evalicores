<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Eva Licores</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">
    <link href="css/templatemo-festava-live.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .scroll-container {
  overflow-x: auto; /* Habilita el desplazamiento horizontal */
  white-space: nowrap; /* Evita que los elementos se envuelvan en una nueva línea */
}

.btn-group {
  display: inline-flex; /* Muestra los botones en una fila */
}
    </style>
         <style>
        .loading-circle {
            width: 3rem;
            height: 3rem;
            border: 0.3rem solid rgba(255, 255, 255, 0.5);
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Centrar vertical y horizontalmente */
        .fullscreen {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30vh;
            background-color: #f8f9fa; /* Color de fondo */
        }
    </style>
    <!--

TemplateMo 583 Festava Live

https://templatemo.com/tm-583-festava-live

-->
</head>

<body>

    <main>

      


        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                   Eva Licores
                </a>

               
                <a  class="btn custom-btn d-lg-none ms-auto me-4" onclick="abrir_carrito()">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count carrito_count" >3</span> <!-- Cambia "3" por el número de artículos -->
                    </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_1">Inicio</a>
                        </li>

                        

                       
                    </ul>

                    <a  class="btn custom-btn d-lg-block d-none" onclick="abrir_carrito()">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count carrito_count">3</span> <!-- Cambia "3" por el número de artículos -->
                    </a>
                </div>
            </div>
        </nav>


        <section class="hero-section" id="section_1">
            <div class="section-overlay"></div>

            <div class="container d-flex justify-content-center align-items-center">
                <div class="row">

                    <div class="col-12 mt-auto mb-5 text-center">
                        <small> 30 años de experiencia en Barranquilla</small>

                        <h1 class="text-white mb-5">Tienda de licores EVA</h1>

                        <a class="btn custom-btn smoothscroll" href="#section_2">Comprar</a>
                    </div>

                    <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
                        <div class="date-wrap">
                            <h5 class="text-white">
                                <i class="custom-icon bi-clock me-2"></i>
                               24/7
                            </h5>
                        </div>

                        <div class="location-wrap mx-auto py-3 py-lg-0">
                            <h5 class="text-white">
                                <i class="custom-icon bi-geo-alt me-2"></i>
                                Cll 82 No 43 - 32 📍CC El Río Lc 79
                            </h5>
                        </div>

                        <div class="social-share">
                            <ul class="social-icon d-flex align-items-center justify-content-center">
                                <span class="text-white me-3">Siguenos:</span>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link">
                                        <span class="bi-facebook"></span>
                                    </a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link">
                                        <span class="bi-twitter"></span>
                                    </a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="#" class="social-icon-link">
                                        <span class="bi-instagram"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="video-wrap">
                <video autoplay="" loop="" muted="" class="custom-video" poster="">
                    <source src="video/pexels-2022395.mp4" type="video/mp4">

                    Your browser does not support the video tag.
                </video>
            </div>
        </section>


        

        <section class="artists-section section-padding" id="section_3">
            <div class="container">
                <div class="row justify-content-center" >
                    <div class="col-12 text-center">
                        <h2 class="mb-4">Nuestra Carta</h1>
                    </div>
                    @csrf
                    <div class="container mt-3 pb-5">
                        <div class="scroll-container">
                            <div class="btn-group" role="group" aria-label="Basic example">
                            @foreach ($productos as $key => $producto)
                                <button type="button" class="btn fondo_naranja select_product" onclick="producto({{ $key }})">{{ $producto[0]->categoria_nombre }}</button>
                                @endforeach
                            
                            
                            </div>
                        </div>
                    </div>
                    
                    <div id="productos-container" class="row">

                    </div>

                   

                </div>
            </div>
        </section>


    </main>


    <footer class="site-footer">
        <div class="site-footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12">
                        <h2 class="text-white mb-lg-0">Tu mejor opción en licores</h2>
                    </div>

                    <div class="col-lg-6 col-12 d-flex justify-content-lg-end align-items-center">
                        <ul class="social-icon d-flex justify-content-lg-end">
                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link">
                                    <span class="bi-twitter"></span>
                                </a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link">
                                    <span class="bi-apple"></span>
                                </a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link">
                                    <span class="bi-instagram"></span>
                                </a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link">
                                    <span class="bi-youtube"></span>
                                </a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link">
                                    <span class="bi-pinterest"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mb-4 pb-2">
                    <h5 class="site-footer-title mb-3">Links</h5>

                    <ul class="site-footer-links">
                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">Inicio</a>
                        </li>

                      
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <h5 class="site-footer-title mb-3">Preguntas?</h5>

                    <p class="text-white d-flex mb-1">
                        <a href="tel: 090-080-0760" class="site-footer-link">
                            3005050282
                        </a>
                    </p>

                </div>

                <div class="col-lg-3 col-md-6 col-11 mb-4 mb-lg-0 mb-md-0">
                    <h5 class="site-footer-title mb-3">Estamos ubicados en </h5>

                    <p class="text-white d-flex mt-3 mb-2">
                    Cll 82 No 43 - 32 📍CC El Río Lc 79
                    </p>

                    <a class="link-fx-1 color-contrast-higher mt-3" href="#">
                        <span>Mira mapa</span>
                        <svg class="icon" viewBox="0 0 32 32" aria-hidden="true">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="16" cy="16" r="15.5"></circle>
                                <line x1="10" y1="18" x2="16" y2="12"></line>
                                <line x1="16" y1="12" x2="22" y2="18"></line>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="site-footer-bottom">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mt-5">
                        <p class="copyright-text">Copyright © 2024 Hache</p>
                        
                    </div>

                    <div class="col-lg-8 col-12 mt-lg-5">
                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Terminos &amp; Condiciones</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Politicas de privacidad</a>
                            </li>

                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--

T e m p l a t e M o

-->

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/custom.js"></script>
    <script>
        var productos = @json($productos);
    </script>
     <script src="js/Products.js"></script>
     <script src="js/carrito.js"></script>
     <script src="{!! asset('js/app.js') !!}"></script>
     <script>
     window.Echo.channel('domis')
    .listen('NewOrder', (e) => {
        console.log(e.message);
    });
       
     </script>
</body>

</html>