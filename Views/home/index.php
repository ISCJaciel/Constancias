<!DOCTYPE html>
<html>
<head>
  <title>Constancias</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <link rel="stylesheet" type="text/css" href="../pruebas.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&family=Lato:wght@300;400;700&display=swap"
    rel="stylesheet">
  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
      margin: 0 auto;
      display: block;
      width: 80%;
      height: 100%;
    }

    .close {
      color: white;
      position: absolute;
      top: 10px;
      right: 25px;
      font-size: 35px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: #999;
      text-decoration: none;
      cursor: pointer;
    }

    .notification {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #4CAF50;
      color: white;
      padding: 15px 20px;
      border-radius: 5px;
      z-index: 1000;
    }

    .course-card img {
      width: 100%;
      height: auto;
    }

    .course-card h5 {
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true"
  tabindex="0">
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
      <title>Search</title>
      <path fill="currentColor"
        d="M19 3C13.488 3 9 7.488 9 13c0 2.395.84 4.59 2.25 6.313L3.281 27.28l1.439 1.44l7.968-7.969A9.922 9.922 0 0 0 19 23c5.512 0 10-4.488 10-10S24.512 3 19 3zm0 2c4.43 0 8 3.57 8 8s-3.57 8-8 8s-8-3.57-8-8s3.57-8 8-8z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 16 16">
      <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 16 16">
      <path
        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="chevron-left" viewBox="0 0 16 16">
      <path fill-rule="evenodd"
        d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="chevron-right" viewBox="0 0 16 16">
      <path fill-rule="evenodd"
        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="cart-outline" viewBox="0 0 16 16">
      <path
        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="quality" viewBox="0 0 16 16">
      <path
        d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z" />
      <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="price-tag" viewBox="0 0 16 16">
      <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
      <path
        d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="shield-plus" viewBox="0 0 16 16">
      <path
        d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
      <path
        d="M8 4.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V9a.5.5 0 0 1-1 0V7.5H6a.5.5 0 0 1 0-1h1.5V5a.5.5 0 0 1 .5-.5z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="star-fill" viewBox="0 0 16 16">
      <path
        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="star-empty" viewBox="0 0 16 16">
      <path
        d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="star-half" viewBox="0 0 16 16">
      <path
        d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="quote" viewBox="0 0 24 24">
      <path fill="currentColor" d="m15 17l2-4h-4V6h7v7l-2 4h-3Zm-9 0l2-4H4V6h7v7l-2 4H6Z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="facebook" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 0 1 1-1h3v-4h-3a5 5 0 0 0-5 5v2.01h-2l-.396 3.98h2.396v8.01Z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="youtube" viewBox="0 0 32 32">
      <path fill="currentColor"
        d="M29.41 9.26a3.5 3.5 0 0 0-2.47-2.47C24.76 6.2 16 6.2 16 6.2s-8.76 0-10.94.59a3.5 3.5 0 0 0-2.47 2.47A36.13 36.13 0 0 0 2 16a36.13 36.13 0 0 0 .59 6.74a3.5 3.5 0 0 0 2.47 2.47c2.18.59 10.94.59 10.94.59s8.76 0 10.94-.59a3.5 3.5 0 0 0 2.47-2.47A36.13 36.13 0 0 0 30 16a36.13 36.13 0 0 0-.59-6.74ZM13.2 20.2v-8.4l7.27 4.2Z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="twitter" viewBox="0 256 256">
      <path fill="currentColor"
        d="m245.66 77.66l-29.9 29.9C209.72 177.58 150.67 232 80 232c-14.52 0-26.49-2.3-35.58-6.84c-7.33-3.67-10.33-7.6-11.08-8.72a8 8 0 0 1 3.85-11.93c.26-.1 24.24-9.31 39.47-26.84a110.93 110.93 0 0 1-21.88-24.2c-12.4-18.41-26.28-50.39-22-98.18a8 8 0 0 1 13.65-4.92c.35.35 33.28 33.1 73.54 43.72V88a47.87 47.87 0 0 1 14.36-34.3A46.87 46.87 0 0 1 168.1 40a48.66 48.66 0 0 1 41.47 24H240a8 8 0 0 1 5.66 13.66Z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="instagram" viewBox="0 0 256 256">
      <path fill="currentColor"
        d="M128 80a48 48 0 1 0 48 48a48.05 48.05 0 0 0-48-48Zm0 80a32 32 0 1 1 32-32a32 32 0 0 1-32 32Zm48-136H80a56.06 56.06 0 0 0-56 56v96a56.06 56.06 0 0 0 56 56h96a56.06 56.06 0 0 0 56-56V80a56.06 56.06 0 0 0-56-56Zm40 152a40 40 0 0 1-40 40H80a40 40 0 0 1-40-40V80a40 40 0 0 1 40-40h96a40 40 0 0 1 40 40ZM192 76a12 12 0 1 1-12-12a12 12 0 0 1 12 12Z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="linkedin" viewBox="0 0 24 24">
      <path fill="currentColor"
        d="M6.94 5a2 2 0 1 1-4-.002a2 2 0 0 1 4 .002zM7 8.48H3V21h4V8.48zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.72-2.91l.04-1.68z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="nav-icon" viewBox="0 0 16 16">
      <path
        d="M14 10.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0 0 1h7a.5.5 0 0 0 .5-.5zm0-3a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0 0 1h11a.5.5 0 0 0 .5-.5z" />
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 16 16">
      <path
        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
    </symbol>
  </svg>

  <div class="search-popup">
    <div class="search-popup-container" style="text-align: center;">
      <h1 style="font-weight: bold; font-size: 36px;">Educación Continua</h1>
      <div style="margin-top: 20px; display: flex; justify-content: center;">
        <form role="search" method="get" class="search-form" onsubmit="searchCourses(); return false;"
          style="display: flex;">
          <input type="search" id="search-form" class="search-field" placeholder="¿Buscas algún curso?" value=""
            name="s" style="flex: 1; padding: 10px; border-radius: 4px 0 0 4px; border: 1px solid #ccc;">
          <button type="button" class="search-submit"
            style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 0 4px 4px 0; cursor: pointer;"
            onclick="searchCourses()">
            Buscar
          </button>
        </form>
      </div>

      <div id="search-results" style="margin-top: 20px; display: none;">
        <h2>Resultados de la búsqueda:</h2>
        <ul id="search-results-list"></ul>
      </div>

      <div style="display: flex; justify-content: center; margin-top: 20px;">
        <img src="images/LOGO_EDUCACION_CONTINUA.jpg" alt="Descripción de la imagen 1" style="max-width: 400px;">
      </div>

      <button onclick="window.location.href = '../home/index.php';"
        style="margin-top: 20px; background-color: #4CAF50; color: white; padding: 14px 20px; border: none; cursor: pointer; border-radius: 4px;">Regresar</button>

      <h5 class="cat-list-title"></h5>
    </div>
  </div>

  <header id="header" class="site-header position-fixed w-100 top-0 text-black bg-light shadow">
    <nav id="header-nav" class="navbar navbar-expand-lg px-3" >
        <div class="container-fluid d-flex align-items-center">
            <!-- Logo alineado a la izquierda -->
            <a class="navbar-brand me-auto" href="https://teschi.edu.mx/">
                <img src="images/teschi_logo.gif" class="logo" width="300" height="100" alt="TESCHI Logo">
            </a>

            <!-- Botón para pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <img src="images/barra_lateral.png" alt="Menu" class="navbar-toggler-image" width="20" height="20">
            </button>

            <!-- Offcanvas para menú en pantallas pequeñas -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
                <div class="offcanvas-header px-4 pb-0">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/teschi_logo.gif" class="logo" width="200" height="100" alt="TESCHI Logo">
                    </a>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Iconos adicionales visibles solo en pantallas pequeñas -->
                    <div class="d-block d-lg-none mb-3">
                        <ul class="list-unstyled d-flex justify-content-end align-items-center">
                            <li class="pe-3" id="userIcon">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <img src="images/preguntas.png" alt="Imagen de usuario" style="width: 30px; height: 30px;">
                                </a>
                            </li>
                            <li class="pe-3" id="wasaIconSmall">
                                <a href="#" id="wasaIconSmallClick">
                                    <img src="images/wasa_icon.png" alt="Icono Wasa" style="width: 30px; height: 30px;">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Menú de navegación -->
                    <ul id="navbar" class="navbar-nav ms-auto text-uppercase">
                        <li class="nav-item">
                            <a class="nav-link me-4 active" href="#billboard">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-4" href="#company-services">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-4" href="#Contacto">Acerca de Educación Continua</a>
                        </li>
                        <li class="nav-item dropdown" id="dropdownMenu">
                            <a class="nav-link me-4 dropdown-toggle link-dark" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Más</a>
                            <ul class="dropdown-menu" id="dropdownMenuContent">
                                <li id="loginItem">
                                    <a href="../dashboard/signin.php" class="dropdown-item">Iniciar Sesión</a>
                                </li>
                                <li id="signupItem">
                                    <a href="../dashboard/signup.php" class="dropdown-item">Registrarme</a>
                                </li>
                                <li id="downloadItem" style="display:none;">
                                    <a href="mis_cursos.php" class="dropdown-item">Mis Cursos</a>
                                </li>
                                <li id="profileItem" style="display:none;">
                                    <a href="perfil.php" class="dropdown-item">Configurar Perfil</a>
                                </li>
                                <li id="logoutItem" style="display:none;">
                                    <a href="#" class="dropdown-item" onclick="logout()">Cerrar Sesión</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Iconos al lado derecho de la opción "Más" -->
                        <li class="nav-item d-none d-lg-block">
                            <div class="d-flex align-items-center">
                                <a href="#" class="nav-link px-2" data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <img src="images/preguntas.png" alt="Imagen de usuario" style="width: 30px; height: 30px;">
                                </a>
                                <a href="#" class="nav-link px-2" id="wasaIconLargeClick">
                                    <img src="images/wasa_icon.png" alt="Icono Wasa" style="width: 30px; height: 30px;">
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

    <script>
    // Obtener parámetros de la URL
    function getQueryParams() {
        const params = {};
        window.location.search.substring(1).split("&").forEach(param => {
            const [key, value] = param.split("=");
            params[decodeURIComponent(key)] = decodeURIComponent(value || "");
        });
        return params;
    }

    // Definir la clase Invitado
    class Invitado {
        constructor(name, tickets) {
            this.name = name;
            this.tickets = tickets;
        }
    }

  // Inicializar la función al cargar la página
    document.addEventListener("DOMContentLoaded", function() {
        const params = getQueryParams();
        const invitado = new Invitado(params.name || "Invitado", params.tickets || 0);

        // Asignar evento click al icono "wasa_icon"
        const wasaIcons = [document.getElementById('wasaIconLargeClick'), document.getElementById('wasaIconSmallClick')];
        wasaIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const message = encodeURIComponent(`${invitado.name} - ${invitado.tickets} BOLETOS`);
                const phoneNumber = '525572281869'; // Reemplaza con el número deseado
                const url = `https://wa.me/${phoneNumber}?text=${message}`;

                // Redirigir a la URL de WhatsApp
                window.location.href = url;
            });
        });
    });
    </script>





<section id="billboard" class="position-relative overflow-hidden py-5" style="margin-top: 120px; background-color: #f0f0f0;">
      <div class="swiper main-swiper">
          <div class="swiper-wrapper">
              <div class="swiper-slide">
                  <div class="container">
                      <div class="row align-items-center">
                          <!-- Columna de Texto -->
                          <div class="col-12 col-md-6 text-center text-md-start mb-4 mb-md-0">
                              <h1 class="display-4 text-uppercase text-dark pb-3"><strong>¡BIENVENIDOS!</strong></h1>
                              <a id="ver-cursos-btn" href="#company-services"
                                  class="btn btn-dark text-uppercase btn-rounded-none">Ver Cursos</a>
                          </div>
                          <!-- Columna de Imagen -->
                          <div class="col-12 col-md-6 text-center">
                              <img src="images/LOGO_EDUCACION_CONTINUA.jpg" alt="banner" class="img-fluid" style="max-width: 100%; height: auto;">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>



  <section id="company-services" class="padding-large">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6 pb-3">
          <div class="icon-box d-flex flex-column align-items-center text-center">
            <div class="icon-box-icon pb-3">
              <svg class="certificaciones-calidad">
                <use xlink:href="#quality" />
              </svg>
            </div>
            <div class="icon-box-content">
              <h3 class="card-title text-uppercase text-dark">CERTIFICACIONES DE CALIDAD</h3>
              <p>Impartidas por los mejores</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 pb-3">
          <div class="icon-box d-flex flex-column align-items-center text-center">
            <div class="icon-box-icon pb-3">
              <svg class="quality">
                <use xlink:href="#quality" />
              </svg>
            </div>
            <div class="icon-box-content">
              <h3 class="card-title text-uppercase text-dark">GARANTÍA DE CALIDAD</h3>
              <p>Certificados digitales con alta credibilidad</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 pb-3">
          <div class="icon-box d-flex flex-column align-items-center text-center">
            <div class="icon-box-icon pb-3">
              <svg class="price-tag">
                <use xlink:href="#price-tag" />
              </svg>
            </div>
            <div class="icon-box-content">
              <h3 class="card-title text-uppercase text-dark">DIPLOMADOS</h3>
              <p>Entidad de certificación y evaluación</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 pb-3">
          <div class="icon-box d-flex flex-column align-items-center text-center">
            <div class="icon-box-icon pb-3">
              <svg class="shield-plus">
                <use xlink:href="#shield-plus" />
              </svg>
            </div>
            <div class="icon-box-content">
              <h3 class="card-title text-uppercase text-dark">SEGURIDAD DE DATOS</h3>
              <p>Tu privacidad es nuestra prioridad</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

  <section class="padding-large">
    <div class="container">
      <div class="display-header d-flex justify-content-between pb-3">
        <h2 class="display-7 text-dark text-uppercase">¡¡Nuevos Cursos!!</h2>
      </div>
      <div class="row nuevos-cursos-container">
      </div>
    </div>
  </section>

  <section class="padding-large">
    <div class="container">
      <div class="display-header d-flex justify-content-between pb-3">
        <h2 class="display-7 text-dark text-uppercase">Próximas Ofertas!!</h2>
      </div>
      <div class="row proximas-ofertas-container">
      </div>
    </div>
    <div class="swiper-pagination position-absolute text-center"></div>
  </section>

  <div class="modal fade" id="cursoModal" tabindex="-1" aria-labelledby="cursoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <img id="cursoImagen" src="" class="img-fluid mb-3" alt="Imagen del Curso">
          <h5 id="cursoTitulo"></h5>
          <p id="cursoDescripcion"></p>
          <span id="cursoPrecio" class="text-primary"></span>
        </div>
        <div class="modal-footer">
          <button id="btnInscribirme" type="button" class="btn btn-primary" style="display:none;" onclick="window.location.href='inscripcion.php'">Inscribirme</button>
          <div id="alertIniciarSesion" class="alert alert-warning" role="alert" style="display:none;">
            ¡Para inscribirte inicia sesión!
          </div>
        </div>
      </div>
    </div>
  </div>


  <section id="yearly-sale" class="bg-light-blue overflow-hidden mt-5 padding-xlarge py-5" style="margin-top: 120px;">
  <div class="container">
    <div class="row d-flex flex-wrap align-items-center">
      <!-- Columna para el texto -->
      <div class="col-md-6 col-sm-12">
        <div class="text-content padding-medium">
          <h3>Descubre tu futuro en el TESCHI.</h3>
          <h2 class="display-2 pb-5 text-uppercase text-dark"></h2>
          <a href="https://www.teschi.edu.mx/" class="btn btn-medium btn-dark text-uppercase btn-rounded-none">¡Visita nuestra página principal!</a>
        </div>
      </div>
      <!-- Columna para la imagen -->
      <div class="col-md-6 col-sm-12">
        <img src="images/EDIFICIO_TESCHI.jpg" alt="Edificio TESCHI" class="img-fluid">
      </div>
    </div>
  </div>
</section>

  <section id="testimonials" class="position-relative">
    <div class="container">
      <div class="row">
        <div class="review-content position-relative">
          <div class="swiper testimonial-swiper">
            <div class="quotation text-center">
              <svg class="quote">
                <use xlink:href="#quote" />
              </svg>
            </div>
            <div class="swiper-wrapper">
              <div class="swiper-slide text-center d-flex justify-content-center">
                <div class="review-item col-md-10">
                  <i class="icon icon-review"></i>
                  <blockquote>“El aprendizaje es el arma más poderosa que puedes usar para cambiar el mundo.”
                  </blockquote>
                  <div class="rating">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                  <div class="author-detail">
                    <div class="name text-dark text-uppercase pt-2">Nelson Mandela</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
  </section>

  <section id="Contacto" class="padding-large overflow-hidden no-padding-top">
    <div class="container">
      <div class="row">
        <div class="display-header text-uppercase text-dark text-center pb-3">
          <h2 class="display-7">¡No pierdas la oportunidad de capacitarte y/o actualizarte!</h2>
        </div>
        <div class="d-flex flex-wrap">
        </div>
      </div>
    </div>
  </section>

  <footer id="footer" class="overflow-hidden">
    <div class="container">
      <div class="row">
        <div class="footer-top-area">
          <div class="row d-flex flex-wrap justify-content-between">
            <div class="col-lg-3 col-sm-6 pb-3">
              <div class="footer-menu">
                <img src="images/teschi_logo.gif" alt="logo" width="250" height="80">
                <p>Acción educativa cuyo propósito es la adquisición de conocimientos nuevos o la actualización de los
                  ya existentes sobre un área o temática específica. </p>
              </div>
            </div>
            <div class="col-lg-2 col-sm-6 pb-3">
            </div>
            <div class="col-lg-3 col-sm-6 pb-3">
              <div class="footer-menu contact-item">
                <h5 class="widget-title text-uppercase pb-2">Contacto</h5>
                <p>Necesitas ayuda? <a href="mailto:">educacioncontinua@teschi.edu.mx</a><br>Te dejamos nuestros datos!!<br><a>facebook: Educación Continua TESCHI<br>55-58-52-74-26<br>Ext 407</a>
                </p>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>

  </footer>
  <div class="cart-concern position-absolute" style="z-index: 999;"></div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/chart/chart.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/tempusdominus/js/moment.min.js"></script>
  <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
  <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

  <script>
    function searchCourses() {
      var searchTerm = document.getElementById('search-form').value.toLowerCase();
      var courses = [
        { title: 'Curso de Matemáticas', description: 'Aprende matemáticas desde cero.' },
        { title: 'Curso de Historia', description: 'Explora la historia antigua y moderna.' },
        { title: 'Curso de Programación', description: 'Domina los fundamentos de la programación.' },
      ];

      var matchingCourses = courses.filter(function (course) {
        return course.title.toLowerCase().includes(searchTerm) || course.description.toLowerCase().includes(searchTerm);
      });

      var searchResultsList = document.getElementById('search-results-list');
      searchResultsList.innerHTML = '';

      matchingCourses.forEach(function (course) {
        var li = document.createElement('li');
        li.textContent = course.title + ': ' + course.description;
        searchResultsList.appendChild(li);
      });

      var searchResultsSection = document.getElementById('search-results');
      searchResultsSection.style.display = 'block';
    }

    function logout() {
      document.cookie = "isLoggedIn=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      document.getElementById("loginItem").style.display = "block";
      document.getElementById("signupItem").style.display = "block";
      document.getElementById("downloadItem").style.display = "none";
      document.getElementById("profileItem").style.display = "none";
      document.getElementById("logoutItem").style.display = "none";
      document.getElementById("userIcon").style.display = "none";
      document.getElementById("btnInscribirme").style.display = "none";
      document.getElementById("alertIniciarSesion").style.display = "block";
      showGoodbyeNotification();
    }

    function showGoodbyeNotification() {
      var notification = document.createElement("div");
      notification.className = "notification";
      notification.textContent = "¡Adiós! Has cerrado sesión exitosamente.";
      document.body.appendChild(notification);
      setTimeout(function () {
        notification.remove();
      }, 3000);
    }

    function checkLoginStatus() {
      var isLoggedIn = getCookie("isLoggedIn");
      if (isLoggedIn === "true") {
        document.getElementById("loginItem").style.display = "none";
        document.getElementById("signupItem").style.display = "none";
        document.getElementById("downloadItem").style.display = "block";
        document.getElementById("profileItem").style.display = "block";
        document.getElementById("logoutItem").style.display = "block";
        document.getElementById("userIcon").style.display = "block";
        document.getElementById("btnInscribirme").style.display = "block";
        document.getElementById("alertIniciarSesion").style.display = "none";
        var username = getCookie("username");
        showWelcomeNotification(username);
      } else {
        document.getElementById("loginItem").style.display = "block";
        document.getElementById("signupItem").style.display = "block";
        document.getElementById("downloadItem").style.display = "none";
        document.getElementById("profileItem").style.display = "none";
        document.getElementById("logoutItem").style.display = "none";
        document.getElementById("userIcon").style.display = "block"; <!-- Cambiar esto a "block" para que siempre se muestre -->
        document.getElementById("btnInscribirme").style.display = "none";
        document.getElementById("alertIniciarSesion").style.display = "block";
      }
    }

    function showWelcomeNotification(username) {
      var notification = document.createElement("div");
      notification.className = "notification";
      notification.textContent = "¡Bienvenido, " + username + "! Has iniciado sesión exitosamente.";
      document.body.appendChild(notification);
      setTimeout(function () {
        notification.remove();
      }, 3000);
    }

    function setCookie(cname, cvalue, exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      var expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

    window.onload = function () {
      checkLoginStatus();
    };

    document.addEventListener('DOMContentLoaded', function () {
      cargarCursos();
    });

    function cargarCursos() {
      const nuevosCursosContainers = document.querySelectorAll('.nuevos-cursos-container');
      const proximasOfertasContainers = document.querySelectorAll('.proximas-ofertas-container');

      console.log('Cargando cursos...');

      fetch('../../Models/tomar_cursos.php')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(cursos => {
          console.log('Cursos obtenidos:', cursos);

          const nuevosCursos = cursos.filter(curso => curso.id_grupo == '1');
          const proximasOfertas = cursos.filter(curso => curso.id_grupo == '2');

          console.log('Nuevos Cursos:', nuevosCursos);
          console.log('Próximas Ofertas:', proximasOfertas);

          nuevosCursosContainers.forEach(container => container.innerHTML = '');
          proximasOfertasContainers.forEach(container => container.innerHTML = '');

          nuevosCursos.forEach((curso, index) => {
            console.log(`Añadiendo nuevo curso ${index + 1}:`, curso);
            const cursoHTML = `
                <div class="col-md-3 col-sm-12">
                  <div class="course-card" onclick="mostrarModal('${curso.ruta}', '${curso.nombre_curso}', '${curso.descripcion}', '${curso.costo}')">
                    <img src="../../Models/cursos/${curso.ruta}" alt="${curso.nombre_curso}" class="img-fluid">
                    <h5>${curso.nombre_curso}</h5>
                  </div>
                </div>`;
            nuevosCursosContainers.forEach(container => container.innerHTML += cursoHTML);
          });

          proximasOfertas.forEach((curso, index) => {
            console.log(`Añadiendo próxima oferta ${index + 1}:`, curso);
            const cursoHTML = `
                <div class="col-md-3 col-sm-12">
                  <div class="course-card" onclick="mostrarModal('${curso.ruta}', '${curso.nombre_curso}', '${curso.descripcion}', '${curso.costo}')">
                    <img src="../../Models/cursos/${curso.ruta}" alt="${curso.nombre_curso}" class="img-fluid">
                    <h5>${curso.nombre_curso}</h5>
                  </div>
                </div>`;
            proximasOfertasContainers.forEach(container => container.innerHTML += cursoHTML);
          });
        })
        .catch(error => {
          console.error('Error al cargar los cursos:', error);
        });
    }

    function mostrarModal(ruta, nombre, descripcion, precio) {
      document.getElementById('cursoImagen').src = '../../Models/cursos/' + ruta;
      document.getElementById('cursoTitulo').innerText = nombre;
      document.getElementById('cursoDescripcion').innerText = descripcion;
      document.getElementById('cursoPrecio').innerText = precio;
      var modal = new bootstrap.Modal(document.getElementById('cursoModal'));
      modal.show();
    }

    function inscribirme(cursoTitulo) {
      const curso = encodeURIComponent(cursoTitulo);
      window.location.href = `inscripcion.php?curso=${curso}`;
    }

    function mostrarInformacion() {
      alert('Mostrando más información del curso');
    }

    function quitarImagen(celda, grupo) {
      $.ajax({
        url: '../../Models/obtener_imagenes.php?action=eliminar',
        type: 'POST',
        data: { celda: celda, grupo: grupo },
        success: function (response) {
          if (response.trim() === 'success') {
            alert('Imagen eliminada exitosamente');
            cargarCursos(); // Recargar los cursos después de eliminar una imagen
          } else {
            alert('Error al eliminar la imagen');
          }
        }
      });
    }
  </script>

  <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="infoModalLabel">"LEE CON ATENCIÓN"</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>1.- Inicia sesión/Registrate</p>
          <p>2.- Inscríbete a tu curso de tu interés y sube tu pago (puedes realizar tu pago desde la siguiente página: <a href="https://sfpya.edomexico.gob.mx/recaudacion/" target="_blank">https://sfpya.edomexico.gob.mx/recaudacion/</a>)</p>
          <p>3.- Si no subiste tu pago puedes hacerlo en un plazo de 3 días máximo en el apartado de "Más" y selecciona la opción "Mis Cursos"</p>
          <p>4.- Cuando tu instructor diga que puedes descargar tu constancia, ve a "Mis Cursos", revisa que el estado del curso diga "terminado", contesta tu encuesta y listo podrás descargar tu constancia.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
