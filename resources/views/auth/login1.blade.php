@include('auth.header')
  <link href="{{ asset('assets/assets_login1/css/main.css') }}" rel="stylesheet" type="text/css">

<!--===============================================================================================-->
</head>
<body style="background-color: #666666;"> 
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        
        <img src="{{ asset('assets_sistema/images/gallery/complementos_login/'.$banner) }}" alt="" 
        style="width: 100%; max-width: 100%; height: auto;">


         <form action="{{ route('login') }}" class="login100-form validate-form" method="post">

         {{ csrf_field() }} 

          <span class="login100-form-title p-b-43">
            <?= $titulo; ?>
          </span>
          
          
          <div class="wrap-input100 validate-input" data-validate = "Alerta email es requerido: ex@abc.xyz">
            <input class="input100" 
            type="{{ session('acceso') === 1 ? 'email' : 'text' }}" 
            name="{{ session('acceso') === 1 ? 'email' : 'login' }}">
            <span class="focus-input100"></span>
            <span class="label-input100">{{ session('acceso') === 1 ? 'Email' : 'Username' }}</span>
          </div>
          
          
          <div class="wrap-input100 validate-input" data-validate="Alerta password es requerido">
            <input class="input100" type="password" name="password">
            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
          </div>

          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
              Login
            </button>
          </div>
        </form>
        <div class="login100-more" style="background-image: url('{{ asset('assets_sistema/images/gallery/complementos_login/'.$imagen) }}">
        </div>
      </div>
    </div>
  </div>
@include('auth.footer')

  