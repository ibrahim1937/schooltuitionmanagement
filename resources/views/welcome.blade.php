<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Services de scolarité</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">


</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.html">Services de scolarite </a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">À propos</a></li>
          <li><a class="nav-link scrollto" href="#team">Équipe</a></li>
          @guest
           <li><a class="getstarted scrollto" href="{{ route('loginpage') }}">S'identifier</a></li>
          @endguest
          @auth
            <li><a class="getstarted scrollto" href="{{ route('route') }}">Dahboard</a></li>
          @endauth
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url({{ asset('storage/images/slide/1.jpg') }})">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Bienvenue dans <span>Services de scolarité</span></h2>
              <p class="animate__animated animate__fadeInUp">Les services de scolarité sont des lieux de contacts privilégiés entre les étudiant·e·s et l’université. Si vous étudiez dans un IUT, certaines des missions suivantes sont assurées par les secrétariats des départements.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url({{ asset('storage/images/slide/2.jpg') }})">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Accueillir et informer</h2>
              <p class="animate__animated animate__fadeInUp">Les services de scolarité vous informent sur les formations et les procédures relatives à l’inscription, quel que soit votre profil : nouveau·elle bachelier·ère, candidat·e à un diplôme à accès sélectif… Grâce aux scolarités, vous faites les bons choix d’orientation et comprenez quels enseignements sont obligatoires, facultatifs ou optionnels. L’annuaire de formation vous permet également de consulter toute l’offre de formation de l’Université de Rennes 1.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url({{ asset('storage/images/slide/3.jpg') }})">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Aider les étudiantes</h2>
              <p class="animate__animated animate__fadeInUp">Les scolarités accompagnent les étudiantes de l’université dans leurs démarches pour trouver leurs stages et les orientent vers les services compétents en matières de bourses, d’orientation, d’études à l’étranger, de difficultés sociales ou médicales ou de handicap.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Featured Services Section ======= -->


    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>À propos de nous</h2>
          <p>Le service scolarité de votre faculté, de votre école ou de votre institut vous accueille et répond à toutes vos questions. Inscriptions, aménagement d’études, examens, certificats de scolarité, transferts de dossier…, n’hésitez pas à vous rendre à votre scolarité pour obtenir les conseils dont vous avez besoin. Le service scolarité doit être informé en cas de changement de la situation administrative de l’étudiant·e (mariage, changement d’adresse, n° de téléphone), de demande d’annulation de l’inscription, d’abandon des études, ou de modification de l’inscription pédagogique aux examens.</p>
        </div>

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2">
            <img src="{{ asset('storage/images/about.jpg')}}" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <h3>DIRECTION DE LA SCOLARITÉ ET DES EXAMENS</h3>
          </p>
          <ul>
            <li><i class="bi bi-check-circled"></i> </li>
          </ul>
          <p>
            <p class="fst-italic">
              La direction de la scolarité et des examens a la responsabilité de l’inscription des étudiants, de l'organisation des examens, du pilotage opérationnel des scolarités pédagogiques, de la gestion des salles et de l’édition de l’ensemble des diplômes délivrés par l’Université. Pour mener à bien ses missions, la direction de la scolarité s’appuie sur une équipe composée de 50 agents.


            </p>
            <ul>
              <li><i class="bi bi-check-circled"></i> </li>
            </ul>
            <p>
              Pour vous inscrire à la session d’été 2021, vous devez obligatoirement avoir payé le solde de vos sessions antérieures ainsi qu'au moins 50 % des frais de scolarité de la session d'hiver 2021. Rappelons que l’émission du diplôme est conditionnelle à l’acquittement de l’entièreté des droits de scolarité.Si vous payez vos frais de scolarité dans une institution bancaire, un délai de 3 à 4 jours doit être pris en compte pour la réception du paiement par l’ÉTS. En conséquence, prévoyez faire votre paiement quelques jours avant la date limite.Les étudiants qui éprouvent des difficultés financières peuvent consulter la liste des bourses disponibles et contacter les Services aux étudiants pour obtenir des conseils en planification budgétaire.​
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Équipe</h2>
          <p></p>
        </div>

        <div class="row">
          <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="" alt="">
              <h4>chantir wadie</h4>
              <span>Etudiant Ensaj</span>
              <p>
                occupe de cote designer et des managements des pages de site service de scolarite              </p>
              <div class="social">
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-github"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="" alt="">
              <h4>Ibrahim chahboun</h4>
              <span>Etudiant Ensaj</span>
              <p>
                occupe de cote designer et des managements des pages de site service de scolarite
              </p>
              <div class="social">
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-github"></i></a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Team Section -->
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>Service se scolarite</h3>
      <div class="social-links">
      </div>
      <div class="copyright">
      </div>
      <div class="credits">
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
  <script src="{{ asset("js/bootstrap.bundle.js") }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="{{ asset('js/home.js') }}"></script>

</body>

</html>
