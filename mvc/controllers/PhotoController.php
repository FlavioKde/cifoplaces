<?php
//controlador para las operaciones con photos
//cada método implementará una operación o un paso de la misma
class PhotoController extends Controller{
    
    //operación por defecto
    public function index(){
        $this->list(); //redirige al método $list
    }
    
    //operación para listar las photos
   // public function list(int $page = 1){
   //public function list( $idplace){
    public function list(int $id = 0){
    
        $photos = Photo::getById($id);
        
    //    $photos = Photo::where('idplace', $idplace)->get();
    
        //carga la vista
        $this->loadView('place/show', [
            'photos'=> $photos,
           
            
        ]);
        
        
    }
    
    //método que muestra los detalles de una foto
    public function show(int $id = 0){
        
        $photo = Photo::findOrFail($id, "No se encontro el lugar solicitado.");
       
        $createPhotoComments = $photo->hasMany('Comment');
        
        
        //carga la vista y le pasa el libro
        $this->loadView('photo/show', [
            'photo'=> $photo,
            'createPhotoComments'=>$createPhotoComments,
         
        ]);
    }
    
    //método que muestra el formulario de creación de la nueva foto en un lugar
    public function create(int $idplace = 0){
        
       
        
        if (!Login::oneRole(['ROLE_USER'])){
            Session::error("No tienes los permisos necesarios para hacer esto.");
            redirect('/');
        }
        
      
        
        $this->loadView('photo/create', [
            'place'=> Place::findOrFail($idplace)
        
            
        ]);
    }
    
    
    //guardar el anuncio
    public function store(int $id = 0){
        
        Auth::oneRole(['ROLE_USER', 'ROLE_ADMIN']);
        //comprueba que la petición venga del formulario
        if (!$this->request->has('guardar'))
            throw new Exception('No se recibio el formulario');
            
            
            $photo = new Photo();  //crea la nueva foto
            
            
            $photo->name                     =$this->request->post('name');
            $photo->date                     =$this->request->post('date');
            $photo->time                     =$this->request->post('time');
            $photo->description              =$this->request->post('description');
            $photo->created_at               =$this->request->post('created_at');
            $photo->updated_at               =$this->request->post('updated_at');
            
          
            
            $photo->iduser=Login::user()->id;
            
            $photo->idplace = $this->request->post('idplace');
            
            
            
            //con un try-catch local evitaremos ir directamente a la página de error
            //cuando no se pueda gurdar el libro y no estemos en DEBUG
            try{
                $photo->save();  //guarda el anuncio
                
                
                if(Upload::arrive('file')){//si llega el fichero de la portada...
                    $photo->file = Upload::save(
                        'file', //nombre del input
                        '../public/'.PI_IMAGE_FOLDER, //ruta de la carpeta de destino
                        true,     //generar nombre único
                        1240000,   //tamaño máximo
                        'image/*', //tipo mime
                        'pi_'    //prefijo del nombre
                        );
                    $photo->update(); //añade la foto del anuncio
                }
                
                //flashea un mensaje en sesión (para que no se borre al redireccionar)
                Session::success("Guardado de foto $photo->name correcto.");
                redirect("/Place/show/$photo->idplace");  //redirecciona a los detalles
            }catch (SQLException $e){
                Session::error("No se puede guardar el anuncio $photo->name");
                
                //si estamos en modo DEBUG, si que iremos a la pagina de error
                if(DEBUG)
                    throw new Exception($e->getMessage());
                    
                    //si no, volveremos al formulario de creación
                    //pondremos los valores antiguos en el formulario con los helpers old()
                    else
                        redirect("/Photo/create");
                        //si se produce un error en la subida del fichero(sería después de guardar)
            }catch(UploadException $e){
                Session::warning("El anuncio se guardo correctamente,
                              pero no se pudo subir el fichero de imagen");
                if(DEBUG)
                    throw new Exception($e->getMessage());
                    else
                        redirect("/Photo/edit/$photo->id"); //redirecciona a la edición
                        
            }
    }
    
    
    
    
    //muestra el formulario de edición de la foto
    public function edit(int $id = 0){
        
        //Primero Auth, luego compruebo quien es y lo comparo con el que esta logeado Y LANZO EXCEPCION
        Auth::check();
        
        $photo = Photo::findOrFail($id, "No se encontro la foto.");
        
        if(Login::oneRole(['ROLE_USER']) && $photo->iduser != Login::user()->id ){
            Session::error("No tienes los permisos necesarios para hacer esto.");
            redirect('/');
        };
        
        
        //carga la vista con el formulario de edición
        $this->loadView('photo/edit', [
            'photo'=>$photo,
            
            
        ]);
        
    }
    
    
    //actualiza los datos de la foto
    public function update(int $id = 0) {
        if(!$this->request->has('actualizar')) //si no llega el formulario...
            throw new Exception('No se recibieron datos');
            
            $id = intval($this->request->post('id')); //recuperar el id vía POST
            $photo = Photo::find($id); //recupera el id desde la BDD
            
           // $photo->idplace            =$this->request->post('idplace');
            
            if (!$photo) // si no hay una foto con ese id
                throw new NotFoundException("No se ha encontrado la foto $id.");
                //recuperar el resto de campos
                $photo->name               =$this->request->post('name');
                $photo->date               =$this->request->post('date');
                $photo->time               =$this->request->post('time');
                $photo->description        =$this->request->post('description');
               // $photo->created_at         =$this->request->post('created_at');
               // $photo->updated_at         =$this->request->post('updated_at');
               
                //aca esta parte del problema
               // $photo->idplace            =$this->request->post('idplace');
                
                try{
                    $photo->update();//actualiza los datos del anuncio
                    
                    //si hay que hacer cambios en la portada lo haremos con un segundo update()
                    //de esta forma nos aseguraremos que se ha actualizado el anuncio
                    //independientemente de si pudo procesar el fichero o no
                    $secondUpdate = false; //flag para saber si hay que actualizar de nuevo
                    $oldCover = $photo->file;  //portada antigua
                    
                    if (Upload::arrive('file')){ //si llega una nueva foto
                        $photo->file = Upload::save(
                            'file' , '../public/'.AD_IMAGE_FOLDER, true, 0, 'image/*', 'book_'
                            );
                        $secondUpdate = true;
                    }
                    //si hay que eliminar portada, el libro tenía una anterior y no llega una nueva...
                    if (isset($_POST['eliminarfoto']) && $oldCover && !Upload::arrive('file')){
                        $photo->file = NULL;
                        $secondUpdate = true;
                    }
                    if ($secondUpdate){
                        $photo->update(); //aplica los cambios en la BDD(actualiza la portada)
                        @unlink('../public/'.AD_IMAGE_FOLDER.'/' .$oldCover); //elimina la portada anterior
                    }
                    Session::success("Actualización de la foto correcta.");
                    redirect("/Place/show/$photo->idplace");
                    //si hay un error al hacer la consulta
                }catch (SQLException $e){
                    Session::error("No se pudo actualizar el anuncio $photo->name.");
                    
                    if (DEBUG)
                        throw new Exception($e->getMessage());//redirecciona los detalles
                        //si hay error al subir el nuevo fichero
                }catch(UploadException $e){
                    Session::warning("El anuncio se actualizo correctamente,
                                  pero no se pudo subir el nuevo fichero de imagen.");
                    if (DEBUG)
                        throw new Exception($e->getMessage());
                        else
                            redirect("/Photo/edit/$photo->id"); //redirecciona a edición
                }
    }
    
    
    
    //muestra el formulario de confirmación de borrado
    public function delete(int $id = 0){
        //comprueba que llega el identificador
        Auth::check();
        $photo = Photo::find($id);
        
        if(Login::check() && !Login::isAdmin() && $photo->iduser != Login::user()->id){
            Session::error("No tienes los permisos necesarios para hacer esto.");
            redirect('/');
        };
        
        if (!$id)
            throw new Exception("No se indico el anuncio a borrar.");
            
            
            //comprueba que la foto existe
            if (!$photo)
                throw new NotFoundException("No existe la foto $id.");
                $this->loadView('photo/delete', ['photo'=>$photo]);
    }
    //elimina el anuncio
    public function destroy(){
        //comprueba que llega el formulario de confirmación
        if (!$this->request->has('borrar'))
            throw new FormException('No se recibio la confirmación');
            
            $id = intval($this->request->post('id')); //recupera el identificador
            $photo = Photo::findOrFail($id); //recupera la foto
            
            //comprueba que la foto existe
            if (!$photo)
                throw new NotFoundException("No existe la foto $id.");
                
                try{
                    $photo->deleteObject();
                    
                    //elimino la foto
                    if ($photo->foto)
                        @unlink('../public/'.AD_IMAGE_FOLDER.'/'.$photo->foto);
                        
                        Session::success("Se ha borrado la foto $photo->name.");
                        redirect("/Place/show/$photo->idplace");
                        
                }catch(SQLException $e){
                    Session::error("No se pudo borrar la foto $photo->name.");
                    
                    if (DEBUG)
                        throw new Exception($e->getMessage());
                        else
                            redirect("/Photo/delete/$id");
                }
    }
    
}