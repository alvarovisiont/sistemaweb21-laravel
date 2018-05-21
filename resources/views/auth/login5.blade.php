@include('auth.header')
  <link href="{{ asset('assets/assets_login1/css/main5.css') }}" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
</head>
<body>
  <img src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$banner) }}" alt="" 
        style="width: 100%; max-width: 100%; height: auto;">
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        

        <div class="login100-form-title" style="background-image: url({{ asset('assets_sistema/images/gallery/complementos_login/'.$imagen) }}">
          <span class="login100-form-title-1">
            <?= $titulo; ?>
          </span>
        </div>

         <form action="{{ route('login') }}" class="login100-form validate-form" method="post"> 
          {{ csrf_field() }} 
          <div class="wrap-input100 validate-input m-b-26" data-validate="Alerta Usuario es requerido">
            <span class="label-input100">{{ session('acceso') === 1 ? 'Email' : 'Username' }}</span>
            <input class="input100" 
            type="{{ session('acceso') === 1 ? 'email' : 'text' }}" 
            name="{{ session('acceso') === 1 ? 'email' : 'login' }}" 
            placeholder="{{ session('acceso') === 1 ? 'Email' : 'Username' }}">
            <span class="focus-input100"></span>
          </div>

          <div class="wrap-input100 validate-input m-b-18" data-validate = "Alerta password es requerido">
            <span class="label-input100">Password</span>
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100"></span>
          </div>
          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@include('auth.footer')
