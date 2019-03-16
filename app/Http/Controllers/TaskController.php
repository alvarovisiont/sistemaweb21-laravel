<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Taskmodel;

class TaskController extends Controller
{

  public function index(Request $request)
  {
    $id_menu = $request->get("menu");

    $array = array(
      "id_menu" => $id_menu,
      "funcion" => "task.index",
      "ruta_imagen" => ""
    );
    
    session($array);

    
    $data["data"] = Taskmodel::all();
    $data["campos"] = [['12,6,6,6','Descripción','7','1','description','','',''],['12,6,6,6','Estado','4','1','state','','No Atendido',[["id" => "No Atendido", "nombre" => "No Atendido"],["id" => "En desarrollo", "nombre" => "En desarrollo"],["id" => "Completado", "nombre" => "Completado"]],'nombre',''],['12,6,6,6','Activo','4','1','activo','',true,[["id" => true, "nombre" => "Activo"],["id" => false, "nombre" => "Desactivado"]],'nombre','']];
    return view("task.index")->with($data);
  }

  
        
      public function store(Request $request){
        
        $store = new Taskmodel;
        $store->fill($request->all());
        $store->updated_at = date("Y-m-d H:i:s");
        $store->created_at = date("Y-m-d H:i:s");

        $function = session("funcion");
        $id_menu  = session("id_menu");

        foreach ($_FILES as $key => $row) {

          if(!empty($row["name"])){
            
            $ruta = "";

            $file = $request->{$key};

        
            $imageName = time().".".$file->getClientOriginalExtension();

            $file->move(public_path(""), $imageName);
            
            $store->{$key} = $imageName;
          }
        }

        $store->save();

        return redirect()->route($function,["menu" => $id_menu])->with([
          "type" => "success",
          "message" => "registro almacenado con éxito"
        ]);
      }

      //Update one item
      public function update(Request $request,$id){
        
        $store = Taskmodel::findOrFail($id);

        $store->fill($request->all());
        $store->updated_at = date("Y-m-d H:i:s");

        $function = session("funcion");
        $id_menu  = session("id_menu");

        foreach ($_FILES as $key => $row) 
        {
          if(!empty($row["name"]))
          {
            
            $ruta = "";

            $file = $request->{$key};

        
            $imageName = time().".".$file->getClientOriginalExtension();

            $file->move(public_path(""), $imageName);
            
            $store->{$key} = $imageName;
          }
        }

        $store->update();

        return redirect()->route($function,["menu" => $id_menu])->with([
          "type" => "success",
          "message" => "registro modificado con éxito"
        ]);
      }

      //Delete one item
      public function destroy($id)
      {
        $function = session("funcion");
        $id_menu  = session("id_menu");
        
        try{
        
          Taskmodel::destroy($id);
          return redirect()->route($function,["menu" => $id_menu])->with(["type" => "success", "message" => "Registro eliminado con Éxito"]);
        
        }catch(\Illuminate\Database\QueryException $e){
          
          $message = "No se puede eliminar el registro porque tiene registros asociados";
          return redirect()->route($function,["menu" => $id_menu])->with(["type" => "success", "message" => $message]);
        }

      }

      public function pdf_general()
      {

      }

      public function pdf_singular($id)
      {

      }

       
}

?>
  