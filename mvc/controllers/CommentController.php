<?php
//controlador para las operaciones con libros
//cada método implementará una operación o un paso de la misma
class CommentController extends Controller{
    
    //operación por defecto
    public function index(){
        $this->list(); //redirige al método $list
    }
    
    public function list( $idplace,){
        
        $comments = Comment::where('idplace', $idplace)->get();
      
        //carga la vista
        $this->loadView('place/show', [
            'comments'=> $comments,
            
            
        ]);
        
        
    }
    
    //método que muestra los detalles de un comentario
    public function show(int $id = 0){
        
        $commentController = Comment::findOrFail($id, "No se encontro el comentario solicitado.");
        
        
    
        
         //carga la vista y le pasa el comentario
         $this->loadView('place/show', [
             'commentController'=> $commentController,   
            
         ]);
    }
    
   

    
    //guardar el comentario
    public function store(){
        
        Auth::oneRole(['ROLE_USER', 'ROLE_ADMIN']);
        //comprueba que la petición venga del formulario
        if (!$this->request->has('guardar'))
            throw new Exception('No se recibio el formulario');
        
        $comment = new Comment();  //crea el nuevo anuncio
        
        $comment->idplace                 =$this->request->post('idplace');
        $comment->idphoto                 =$this->request->post('idphoto');
        $comment->text                    =$this->request->post('text');
        $comment->created_at              =$this->request->post('created_at');
       
        $comment->iduser                  =Login::user()->id;
        
        
        

        try{
            $comment->save();  //guarda el anuncio
            
         
            
            //flashea un mensaje en sesión (para que no se borre al redireccionar)
            Session::success("Guardado del comentario correcto.");
            
            
            if($comment->idplace){
            redirect("/Place/show/$comment->idplace");  //redirecciona a los detalles
            }else{
                redirect("/Photo/show/$comment->idphoto");
            }
        
        }catch (SQLException $e){
            Session::error("No se puede guardar el comentario");
            
            //si estamos en modo DEBUG, si que iremos a la pagina de error
            if(DEBUG)
                throw new Exception($e->getMessage());
            
            //si no, volveremos al formulario de creación
            //pondremos los valores antiguos en el formulario con los helpers old()
            else 
                redirect("/Comment/create");
            //si se produce un error en la subida del fichero(sería después de guardar)    
        }catch(UploadException $e){
            Session::warning("El anuncio se guardo correctamente,
                              pero no se pudo subir el fichero de imagen");
             if(DEBUG)
                  throw new Exception($e->getMessage());
             else 
                 redirect("/Comment/edit/$comment->id"); //redirecciona a la edición
                 
        }
    }
    
    
   
    
        //muestra el formulario de edición del comentario
         public function edit(int $id = 0){
             
             //Primero Auth, luego compruebo quien es y lo comparo con el que esta logeado Y LANZO EXCEPCION
             Auth::check();
            
            $comment = Comment::findOrFail($id, "No se encontro el comentario.");
            
            if(Login::oneRole(['ROLE_USER']) && $comment->iduser != Login::user()->id ){
                Session::error("No tienes los permisos necesarios para hacer esto.");
                redirect('/');
            };
       
                
            //carga la vista con el formulario de edición
            $this->loadView('comment/edit', [
                'comment'=>$comment,
               
                
            ]);
        
      }

        
        //actualiza los datos del anuncio
        public function update() {
            if(!$this->request->has('actualizar')) //si no llega el formulario...
                throw new Exception('No se recibieron datos');
            
                $id = intval($this->request->post('id')); //recuperar el id vía POST
                $comment = Comment::find($id); //recupera el id desde la BDD
                
                if (!$comment) // si no hay anuncio con ese id
                    throw new NotFoundException("No se ha encontrado el anuncio $id.");
                //recuperar el resto de campos
                $place->name                        =$this->request->post('name');
                $place->type                        =$this->request->post('type');
                $place->location                    =$this->request->post('location');
                $place->description                 =$this->request->post('description');
                
                try{
                    $place->update();//actualiza los datos del anuncio
                    
                    //si hay que hacer cambios en la portada lo haremos con un segundo update()
                    //de esta forma nos aseguraremos que se ha actualizado el anuncio
                    //independientemente de si pudo procesar el fichero o no
                    $secondUpdate = false; //flag para saber si hay que actualizar de nuevo
                    $oldCover = $place->cover;  //portada antigua
                    
                    if (Upload::arrive('cover')){ //si llega una nueva foto
                        $place->cover = Upload::save(
                            'cover' , '../public/'.AD_IMAGE_FOLDER, true, 0, 'image/*', 'book_'
                            );
                        $secondUpdate = true;
                    }
                    //si hay que eliminar portada, el libro tenía una anterior y no llega una nueva...
                    if (isset($_POST['eliminarcover']) && $oldCover && !Upload::arrive('cover')){
                        $place->cover = NULL;
                        $secondUpdate = true;
                    }
                    if ($secondUpdate){
                        $place->update(); //aplica los cambios en la BDD(actualiza la portada)
                        @unlink('../public/'.AD_IMAGE_FOLDER.'/' .$oldCover); //elimina la portada anterior
                    }
                    Session::success("Actualización del anuncio $place->titulo correcta.");
                    redirect("/Place/edit/$id");
                    //si hay un error al hacer la consulta
                }catch (SQLException $e){
                    Session::error("No se pudo actualizar el anuncio $place->titulo.");
                    
                    if (DEBUG)
                           throw new Exception($e->getMessage());//redirecciona los detalles
                    //si hay error al subir el nuevo fichero
                }catch(UploadException $e){
                 Session::warning("El anuncio se actualizo correctamente,
                                  pero no se pudo subir el nuevo fichero de imagen.");
                 if (DEBUG)
                     throw new Exception($e->getMessage());
                 else 
                     redirect("/Place/edit/$place->id"); //redirecciona a edición
                }
        }
                   
        
        
        //muestra el formulario de confirmación de borrado
        public function delete(int $id = 0){
            //comprueba que llega el identificador
            Auth::check();
            $comment = Comment::find($id);
            
            if(Login::check() && !Login::isAdmin() && $comment->iduser != Login::user()->id){
                Session::error("No tienes los permisos necesarios para hacer esto.");
                redirect('/');
            };
            
            if (!$id)
                throw new Exception("No se indico el comentario a borrar.");
            
         //recupera el anuncio con dicho identificador
        // $anuncio = Anuncio::find($id);
         
         //comprueba que el anuncio existe
         if (!$comment)
             throw new NotFoundException("No existe el comentario $id.");
         $this->loadView('comment/delete', ['comment'=>$comment]);
        }
        //elimina el anuncio
        public function destroy(){
            //comprueba que llega el formulario de confirmación
            if (!$this->request->has('borrar'))
                throw new FormException('No se recibio la confirmación');
            
           $id = intval($this->request->post('id')); //recupera el identificador
           $comment = Comment::findOrFail($id); //recupera el libro
           
           //comprueba que el libro existe
           if (!$comment)
               throw new NotFoundException("No existe el anuncio $id.");
           
           try{
               $comment->deleteObject();
               
               //elimino la foto
               if ($place->foto)
                   @unlink('../public/'.AD_IMAGE_FOLDER.'/'.$place->foto);
               
               Session::success("Se ha borrado el comentario.");
               redirect("/Place/list");
               
           }catch(SQLException $e){
               Session::error("No se pudo borrar el libro $place->name.");
               
               if (DEBUG)
                   throw new Exception($e->getMessage());
               else 
                   redirect("/Place/delete/$id");
           }
        }
       
}
