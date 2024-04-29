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
        //muestra el formulario de edición del user
        public function edit(int $id = 0){
            
            Auth::check();
            
            $user = User::findOrFail($id, "No se encontro el lugar.");
            
            
            //carga la vista con el formulario de edición
            $this->loadView('user/edit', [
                'user'=>$user,
                
                
            ]);
            
        }
        
        
        //actualiza los datos del user
        public function update() {
            if(!$this->request->has('actualizar')) //si no llega el formulario...
                throw new Exception('No se recibieron datos');
                
                $id = intval($this->request->post('id')); //recuperar el id vía POST
                $user = User::find($id); //recupera el id desde la BDD
                
                if (!$user) // si no hay lugar con ese id
                    throw new NotFoundException("No se ha encontrado el usuario $id.");
                    //recuperar el resto de campos
                    $user->password =md5($_POST['password']);
                    $repeat         =md5($_POST['repeatpassword']);
                    
                    if ($user->password !=$repeat)
                        throw new Exception("Las claves no coinciden.");
                        $user->displayname = $_POST['displayname'];
                        $user->email = $_POST['email'];
                        $user->phone = $_POST['phone'];
                        $user->addRole('ROLE_USER', $_POST['roles']);
                  
                    
                    try{
                        $user->update();//actualiza los datos del usuario
                        
                        //si hay que hacer cambios en la portada lo haremos con un segundo update()
                        //de esta forma nos aseguraremos que se ha actualizado el lugar
                        //independientemente de si pudo procesar el fichero o no
                        $secondUpdate = false; //flag para saber si hay que actualizar de nuevo
                        $oldCover = $user->picture;  //foto antigua
                        
                        if (Upload::arrive('picture')){ //si llega una nueva foto
                            $user->picture = Upload::save(
                                'picture' , '../public/'.USER_IMAGE_FOLDER, true, 0, 'image/*', 'user_'
                                );
                            $secondUpdate = true;
                        }
                        //si hay que eliminar foto, el lugar tenía una anterior y no llega una nueva...
                        if (isset($_POST['eliminarpicture']) && $oldCover && !Upload::arrive('picture')){
                            $user->picture = NULL;
                            $secondUpdate = true;
                        }
                        if ($secondUpdate){
                            $user->update(); //aplica los cambios en la BDD(actualiza la portada)
                            @unlink('../public/'.USER_IMAGE_FOLDER.'/' .$oldCover); //elimina la foto anterior
                        }
                        Session::success("Actualización del usuario $user->displayname correcta.");
                        redirect("/User/home/$id");
                        //si hay un error al hacer la consulta
                    }catch (SQLException $e){
                        Session::error("No se pudo actualizar el usuario $user->displayname.");
                        
                        if (DEBUG)
                            throw new Exception($e->getMessage());//redirecciona los detalles
                            //si hay error al subir el nuevo fichero
                    }catch(UploadException $e){
                        Session::warning("El lugar se actualizo correctamente,
                                  pero no se pudo subir el nuevo fichero de imagen.");
                        if (DEBUG)
                            throw new Exception($e->getMessage());
                            else
                                redirect("/User/edit/$user->id"); //redirecciona a edición
                            }
        }
        
       
        
        }
