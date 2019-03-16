@extends('layout.app')

@section('signature_css')
  <link rel="stylesheet" href="{{ asset('assets_sistema/signature/jquery.signaturepad.css') }}">
@endsection

@section('content')
  <form method="post" action="{{ route('signature') }}" class="sigPad">
    
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <label for="name">Print your name</label>
    <input type="text" name="name" id="name" class="name">
    <p class="drawItDesc">Draw your signature</p>
    <ul class="sigNav">
      <li class="drawIt"><a href="#draw-it" >Draw It</a></li>
      <li class="clearButton"><a href="#clear">Clear</a></li>
    </ul>
    <div class="sig sigWrapper">
      <div class="typed"></div>
      <canvas class="pad" width="250" height="80"></canvas>
      <input type="hidden" name="output" class="output">
    </div>
    <button type="submit">I accept the terms of this agreement.</button>
  </form>
@endsection

@section('signature_js')
  <script src="{{ asset('assets_sistema/signature/jquery.signaturepad.js') }}"></script>
@endsection

@section('scripts')
  <script>
    $(function(){
      $('.sigPad').signaturePad({drawOnly:true});
    })
  </script>
@endsection