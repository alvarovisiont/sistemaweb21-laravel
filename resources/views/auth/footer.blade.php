 
  <script src="{{ asset('assets/assets_login1/vendor/jquery/jquery-3.2.1.min.js') }}"></script>

  <script src="{{ asset('assets/assets_login1/vendor/bootstrap/js/popper.js') }}"></script>
    
  <script src="{{ asset('assets/assets_login1/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

  <script src="{{ asset('assets/assets_login1/vendor/animsition/js/animsition.min.js') }}"></script>


  <script src="{{ asset('assets/assets_login1/vendor/countdowntime/countdowntime.js') }}"></script>

    <script src="{{ asset('assets/assets_login1/js/main.js') }}"></script>

    <script src="{{ asset('assets_sistema/js/toastr.min.js') }}"></script>
</body>
</html>

<script>
  $(function(){
    
    let message = '{{ Session::get("message") }}'
    
    if(message)
    {
      toastr.error(message, 'Error!',{
        hideMethod: 'fadeOut',
      })
    }
      
  })
</script>