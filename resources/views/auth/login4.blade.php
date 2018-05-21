@include('auth.header')
  <link href="{{ asset('assets/assets_login1/css/main4.css') }}" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
</head>
<body>
  <header>
    <img src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$banner) }}" alt="" 
        style="width: 100%; max-width: 100%; height: auto;">
  </header>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100 p-t-190 p-b-30">
         <form action="{{ route('login') }}" class="login100-form validate-form" method="post"> 
          
          {{ csrf_field() }} 
          
          <div class="login100-form-avatar">
            <img src="{{ asset('assets/assets_login1/images/usuario.jpg') }}" alt="AVATAR">
          </div>

          <span class="login100-form-title p-t-20 p-b-45">
            <?= $titulo; ?>
          </span>

          <div class="wrap-input100 validate-input m-b-10" data-validate = "Alerta Usuario es requerido">
            <input class="input100" 
            type="{{ session('acceso') === 1 ? 'email' : 'text' }}" 
            name="{{ session('acceso') === 1 ? 'email' : 'login' }}" 
            placeholder="{{ session('acceso') === 1 ? 'Email' : 'Username' }}">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input m-b-10" data-validate = "Alerta password es requerido">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock"></i>
            </span>
          </div>

          <div class="container-login100-form-btn p-t-10">
            <button class="login100-form-btn">
              Entrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@include('auth.footer')