<?php
//Controlador para las operaciones de los usuarios
class UserController extends Controller{
    
    
    public function home(int $id = 0){
        Auth::check();// autorización solo identificados
        
     //  Obtener el ID del usuario actual
       
       $user = Auth::user();
       
        
       //  Obtener los anuncios publicados por el usuario
       $places = $user->hasMany('Place');
       
       
        //Carga la vista la home y le pasa el usuario
        $this->loadView('user/home', [
            'places'=>$places,
            'user'=>$user
          
            ]);
    }


     public function create(){
    
         
         
         //carga la vista
         $this->loadView('user/create');
}
      public function store(){
  
              
          //otro intento con el original ver el anterior POR QUE LO HAGO MAL
          if(empty($_POST['guardar']))
              throw new Exception('No se recibio el formulario');
          $user = new User();
          
          $user->password =md5($_POST['password']);
          $repeat         =md5($_POST['repeatpassword']);
          
          if ($user->password !=$repeat)
              throw new Exception("Las claves no coinciden.");
          $user->displayname = $_POST['displayname'];
          $user->email = $_POST['email'];
          $user->phone = $_POST['phone'];
          $user->addRole('ROLE_USER', $_POST['roles']);
          
          
          try {
              $user->save();    //guarda el usuario
              
              if (Upload::arrive('picture')){ //si llega el fichero con la imagen
                  $user->picture = Upload::save(
                      'picture', //nombre del input
                      '../public/'.USER_IMAGE_FOLDER,  //ruta de la carpeta de destino
                      true,
                      1240000,        //tamaño maximo
                      'image/*',  //tipo mime
                      'user_',    //prefijo para las pictures
                      );
                  $user->update(); //añade la caratula del libro
              }
              
              Session::success("Nuevo usuario $user->displayname creado con éxito.");
              redirect("/Login");

                    // si se produce un error al guardar los datos
          }catch(SQLException $e){
              Session::error("Se produjo un error al guardar el usuario $user->displayname.");
              
              if (DEBUG)
                  throw new Exception($e->getMessage());
              else 
                  redirect("/User/create");
              //si se produce un error en la subida del fichero(sería despues de guardar)
          }catch (UploadException $e){
            Session::warning("El usuario se guardo correctamente pero no se pudo subir
                              el fichero de la imagen.");
            if (DEBUG)
                throw new Exception($e->getMessage());
            else 
                redirect("/"); //redirecciona a la edición
          
      
      }
          
}
        
        //comprueba si el usuario éxiste
        public function registered(string $email = ''){
            $response = new stdClass();
            
            if (!Login::isAdmin()){ //solo para administradores
                $response->status = "NOT AUTHORIZED";
                $response->registered = 'UNKNOW';
            }else{
                try{
                    $response->status ='OK';
                    $response->registered = User::checkEmail($email);
                }catch (SQLException $e){
                    $response->status = 'ERROR';
                    $response->registered = 'UNKNOW';
                }
            }
            header('Content-Type: application/json'); //el content-type desde json
            echo json_encode($response);
        }
       
        
        }
