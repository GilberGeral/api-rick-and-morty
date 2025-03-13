<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Character;
use Carbon\Carbon;

class CharacterController extends Controller{

  public $ORIGIN_MYSQL;
  public $ORIGIN_API;

  public function __construct() {
   
    $this->data_view=[];
    $this->response["data"] = [];
    $this->response["done"] = true;
    $this->response["msg"] = "DEFAULT";
    $this->response["code"] = 200;
    $this->ORIGIN_MYSQL = 2;//se que debieron ir en otro lado, por ahira el tiempo apremia
    $this->ORIGIN_API = 1;
  }

  public function listFromApi(){
    //traer los personajes de la api
    
    $page = 1;
    if( isset( $_GET['page'] ) ){
      if( is_numeric( $_GET['page'] ) ){
        $page=intval( $_GET['page'] );
        if( !in_array($page,[1,2,3,4,5]) ){
          $page=1;
        }
      }
          
    }

    $_url='https://rickandmortyapi.com/api/character/?page='.$page;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $this->data_view['alert']='';
    $this->data_view['personajes']=[];//obtenidos mediante el API
        
    $ids = DB::table('characters')->select('id_externo')->get()->toArray();
    $old_ids=[];

    foreach ( $ids as $row ){
      array_push($old_ids, intval( $row->id_externo ) );
    }

    $characters_api=[];
    if (curl_errno($ch)){
      $this->data_view['alert']="Error al conectar con la API";
    } else {      
      $characters_api = json_decode($response, true);
    }

    // var_dump($characters_api);return;

    if( count($characters_api["results"]) > 0 ){

      foreach ( $characters_api["results"] as $character ){
        $new_char = [];
        $new_char['saved']=0;
        $new_char['id'] = $character["id"];
        $new_char['name'] = $character["name"];
        $new_char['status'] = $character["status"];
        $new_char['species'] = $character["species"];

        if( in_array( intval( $character["id"] ), $old_ids ) ){
          $new_char['saved'] = 1;
        }
        array_push($this->data_view['personajes'],$new_char);
      }
    
    }

    $this->data_view["page"] = $page;
    
    curl_close($ch);

    return view('rick_api',$this->data_view);
  }

  public function listFromLocal(){
    //traer los personajes de mysql
    $this->data_view["personajes"] = [];

    $this->data_view["personajes"] = Character::all();

    return view('characters_saved',$this->data_view);
  }

  public function getSingle(Request $req){

    $data_front = $req->all();

    foreach ( $data_front as $k => $v ){
      error_log($k.' => '.$v);
    }

    $validator = Validator::make($data_front, [
      'id' => 'required|integer',
      'origin' => 'required|integer'
    ]);
    
    if ($validator->fails()) {
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = "Error en los datos (0x004)";
      $this->response["code"] = 400;            
      return response()->json($this->response, 500);
    }
    
    $_url="https://rickandmortyapi.com/api/character/". $data_front['id'];

    if( $data_front["origin"] ==  $this->ORIGIN_API ){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
      $response = curl_exec($ch);
      curl_close($ch);

      $_data = json_decode($response, true);
      $this->response["data"] = [];
    
      $this->response["data"]["Nombre"] = $_data["name"];
      $this->response["data"]["Genero"] = $_data["gender"];
      $this->response["data"]["Especie"] = $_data["species"];
      $this->response["data"]["Ubicación"] = $_data["location"]["name"];
      $this->response["data"]["Origen"] = $_data["origin"]["name"];
      $this->response["data"]["Tipo"] = $_data["type"] | "Desconocido";
      $this->response["data"]["Img"] = $_data["image"];

    }else if( $data_front["origin"] ==  $this->ORIGIN_MYSQL ){

      $_data = Character::where(["id" => $data_front["id"]])->first();

      $this->response["data"]["Nombre"] = $_data["name"];
      $this->response["data"]["Genero"] = $_data["gender"];
      $this->response["data"]["Especie"] = $_data["species"];
      // $this->response["data"]["Ubicación"] = $_data["location"]["name"];
      $this->response["data"]["Origen"] = $_data["origin"];
      $this->response["data"]["Tipo"] = $_data["type"];
      $this->response["data"]["Img"] = "https://rickandmortyapi.com/api/".$_data["image"];
    }

    return response()->json($this->response, 201);
  }

  public function saveSingle(Request $req){

    $data = $req->all();
    $validator = Validator::make($data, [
      'id' => 'required|integer'
    ]);
    
    if ($validator->fails()) {
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = "Error en los datos (0x005)";
      $this->response["code"] = 400;            
      return response()->json($this->response, 500);
    }
    
    $_url="https://rickandmortyapi.com/api/character/". $data['id'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
    $response = curl_exec($ch);
    curl_close($ch);

    $_data = json_decode($response, true);
    $this->response["data"] = [];
    
    //averiguar que NO este ya guardado 
    $newChar = Character::where(["id_externo" => $_data["id"]])->first();
    if( !is_null($newChar) ){
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = "El personaje ya fué guardado anteriormente (0x006)";
      $this->response["code"] = 400;
      return response()->json($this->response, 500);
    }

    $newChar = new Character();
    $newChar->id_externo = $_data["id"];
    $newChar->name = $_data["name"];
    $newChar->status = $_data["status"];
    $newChar->species = $_data["species"];
    $newChar->type = $_data["type"];    
    $newChar->gender = $_data["gender"];
    $newChar->origin = $_data["origin"]["name"];

    $dt = explode("api/", $_data["image"]);
    $newChar->image = $dt[1];

    $newChar->created_by = "user";
    $newChar->updated_by = "user";
    $newChar->created_at = Carbon::now();
    $newChar->updated_at = Carbon::now();

    try {
      $newChar->save();
      $this->response["data"] = [];
      $this->response["done"] = true;
      $this->response["msg"] = "Personaje guardado correctamente ";
      $this->response["code"] = 200;
    } catch (\Throwable $th) {
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = $th->getMessage();
      $this->response["code"] = 500;
    }
    
    return response()->json($this->response, 201);
  }

  public function updateSingle(Request $req){
    
    $_data = $req->all();

    $validator = Validator::make($_data, [
      'id' => 'required|integer',
      'name' => 'required|string|max:64',
      'status' => 'required|string|max:64',
    ]);
    
    if ($validator->fails()) {
      $this->response["data"] = $validator->errors();
      $this->response["done"] = false;
      $this->response["msg"] = "Error en los datos (0x009)";
      $this->response["code"] = 400;            
      return response()->json($this->response, 500);
    }

    error_log('aaaaa');
    
    $old_character = Character::where(["id" => $_data["id"] ])->first();
    error_log('vvvvv');
    if( is_null($old_character) ){
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = "El personaje que esta intentando editar no existe (0x008)";
      $this->response["code"] = 400;
      return response()->json($this->response, 500);
    }

    $old_character->name = $_data["name"];
    $old_character->status = $_data["status"];
    $old_character->species = $_data["species"];
    $old_character->type = $_data["type"];    
    $old_character->gender = $_data["gender"];
    $old_character->origin = $_data["origin"];
    $old_character->updated_by = "user";   
    $old_character->updated_at = Carbon::now();
    
    try {
      $old_character->save();
      $this->response["data"] = [];
      $this->response["done"] = true;
      $this->response["msg"] = "Personaje actualizado correctamente ";
      $this->response["code"] = 200;
    } catch (\Throwable $th) {
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = $th->getMessage();
      $this->response["code"] = 500;
    }
    
    return response()->json($this->response, 201);
  }

  public function viewEdit($id){
    error_log('algo a editar '.$id);
    if( !is_numeric($id) ){
      return redirect('/guardados');
    }

    //traer el personaje a editar
    $personaje = Character::where(["id" => $id])->first();
    if( is_null($personaje) ){
      return redirect('/guardados');
    }

    $this->data_view["personaje"] = $personaje;
    return view('edit_character',$this->data_view);
  }


  public function deleteSingle(Request $req){
    
    $_data = $req->all();

    $validator = Validator::make($_data, [
      'id' => 'required|integer'
    ]);
    
    if ($validator->fails()) {
      $this->response["data"] = $validator->errors();
      $this->response["done"] = false;
      $this->response["msg"] = "Error en los datos (0x010)";
      $this->response["code"] = 400;            
      return response()->json($this->response, 500);
    }
    
    $old_character = Character::where(["id" => $_data["id"] ])->first();
    
    if( is_null($old_character) ){
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = "El personaje que esta intentando borrar no existe (0x011)";
      $this->response["code"] = 400;
      return response()->json($this->response, 500);
    }
    
    try {
      $old_character->delete();
      $this->response["data"] = [];
      $this->response["done"] = true;
      $this->response["msg"] = "Personaje borrado correctamente ";
      $this->response["code"] = 200;
    } catch (\Throwable $th) {
      $this->response["data"] = [];
      $this->response["done"] = false;
      $this->response["msg"] = $th->getMessage();
      $this->response["code"] = 500;
    }
    
    return response()->json($this->response, 201);
  }

}
