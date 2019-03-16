<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Signaturemodel;

class SignatureController extends Controller
{
    //
  public function index(){
    return view('signature');
  }

  public function store(Request $request){
    /*$sig = new Signaturemodel;
    $sig->signature_json = $request->output;
    $sig->save();
    return redirect()->route('signature');*/

    $img = sigJsonToImage($request->output);
    // Save to file
    imagepng($img, public_path('assets_sistema/signature/signature.png'));

    // Output to browser
    
    imagedestroy($img);
  }
}
