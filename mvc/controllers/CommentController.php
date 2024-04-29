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
            $comment->save();  //guarda el comentario
            
         
            
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
      
         
         //comprueba que el comment existe
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
           
           //comprueba que el comment existe
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
