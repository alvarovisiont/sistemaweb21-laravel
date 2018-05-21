@include('auth.header')
<!--===============================================================================================-->
  <link href="{{ asset('assets/assets_login1/css/main3.css') }}" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
</head>
<body>
  <div class="limiter">
    <img src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$banner) }}" alt="" 
        style="width: 100%; max-width: 100%; height: auto;">
    <div class="container-login100">
      <div class="wrap-login100">
         <form action="{{ route('login') }}" class="login100-form validate-form" method="POST"> 
          
          {{ csrf_field() }} 
          
          <span class="login100-form-title p-b-26">
            <?= $titulo; ?>
          </span>

          <div class="wrap-input100 validate-input" data-validate = "Alerta email es requerido: ex@abc.xyz">
            <input class="input100" 
            type="{{ session('acceso') === 1 ? 'email' : 'text' }}" 
            name="{{ session('acceso') === 1 ? 'email' : 'login' }}">
            <span class="focus-input100" data-placeholder="{{ session('acceso') === 1 ? 'Email' : 'Username' }}"></span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Alerta password es requerido">
            <span class="btn-show-pass">
              <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" name="password">
            <span class="focus-input100" data-placeholder="Password"></span>
          </div>

          <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
              <div class="login100-form-bgbtn"></div>
              <button class="login100-form-btn">
                Entrar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="dropDownSelect1"></div>
@include('auth.footer')