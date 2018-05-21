@include('auth.header')
  <link href="{{ asset('assets/assets_login1/css/main2.css') }}" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
</head>
<body>
  <header>
    <img src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$banner) }}" alt="" 
        style="width: 100%; max-width: 100%; height: auto;">
  </header>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">

        <div class="login100-pic js-tilt" data-tilt>
          <img src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$imagen) }}" alt="" 
        style="width: 100%; max-width: 100%; height: auto;">
        </div>

         <form action="{{ route('login') }}" class="login100-form validate-form" method="POST"> 
          
          {{ csrf_field() }} 

          <span class="login100-form-title">
            <?= $titulo; ?>
          </span>

          <div class="wrap-input100 validate-input" data-validate = "Alerta email es requerido: ex@abc.xyz">
            <input class="input100" 
            type="{{ session('acceso') === 1 ? 'email' : 'text' }}" 
            name="{{ session('acceso') === 1 ? 'email' : 'login' }}" 
            placeholder="{{ session('acceso') === 1 ? 'email' : 'Username' }}">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="{{ session('acceso') === 1 ? 'fa fa-envelope' : 'fa fa-user' }}" aria-hidden="true"></i>
            </span>
          </div>
  
            <div class="wrap-input100 validate-input" data-validate="Alerta password es requerido">

            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>
          
          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
              Entrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@include('auth.footer')
