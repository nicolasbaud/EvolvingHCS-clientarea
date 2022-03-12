<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/logo.png">
  <title>
    {{ config('app.name') }} - Inscription
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="/assets/css/argon-dashboard.css?v=2.0.0" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="">
              {{ config('app.name') }}
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link me-2" href="{{ route('login') }}">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Connexion
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="{{ route('register') }}">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Inscription
                  </a>
                </li>
              </ul>
              <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                  <a href="{{ config('app.base_url') }}" class="btn btn-sm mb-0 me-1 btn-primary">Retour à l'accueil</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <!-- End Navbar -->
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Bienvenue</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-10 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Inscription</h5>
            </div>
            <div class="card-body">
              <form role="form" method="post" action="{{ route('register') }}">
                <div class="row">
                  <div class="mb-3 col-lg-6">
                    <input type="text" value="{{ old('firstname') }}" class="form-control @error('firstname') is-invalid @enderror" placeholder="Prénom" aria-label="Prénom" name="firstname">
                    @error('firstname')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-6">
                    <input type="text" value="{{ old('lastname') }}" class="form-control @error('lastname') is-invalid @enderror" placeholder="Nom" aria-label="Nom" name="lastname">
                    @error('lastname')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-lg-6">
                    <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" aria-label="Email" name="email">
                    @error('email')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-6">
                    <input type="text" value="{{ old('tel') }}" class="form-control @error('tel') is-invalid @enderror" placeholder="Téléphone" aria-label="Téléphone" name="tel">
                    @error('tel')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <p class="text-center text-secondary tex-sm">Facturation</p>
                <div class="row">
                  <div class="mb-3 col-lg-6">
                    <input type="text" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" placeholder="Adresse" aria-label="Adresse" name="address">
                    @error('address')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-3">
                    <input type="text" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" placeholder="Ville" aria-label="Ville" name="city">
                    @error('city')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-3">
                    <input type="text" value="{{ old('postalcode') }}" class="form-control @error('postalcode') is-invalid @enderror" placeholder="Code Postal" aria-label="Code Postal" name="postalcode">
                    @error('postalcode')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-lg-6">
                    <input type="text" value="{{ old('region') }}" class="form-control @error('region') is-invalid @enderror" placeholder="Région" aria-label="Région" name="region">
                    @error('region')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-6">
                    <input type="text" value="{{ old('country') }}" class="form-control @error('country') is-invalid @enderror" placeholder="Pays" aria-label="Pays" name="country">
                    @error('country')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="mb-3 col-lg-6">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe" aria-label="Mot de passe">
                    @error('password')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="mb-3 col-lg-6">
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmation du mot de passe" aria-label="Mot de passe">
                    @error('password_confirmation')
                      <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Inscription</button>
                  @csrf
                </div>
                <p class="text-sm mt-3 mb-0">Vous avez déjà un compte ? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Connexion</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> Soft by <a href="https://evolving-hcs.com" target="_blank">Evolving-HCS</a> and theme by Creative Tim.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.0"></script>
</body>

</html>