<?php
//controlador para las operaciones con lugares
//cada método implementará una operación o un paso de la misma
class PlaceController extends Controller{
    
    //operación por defecto
    public function index(){
        $this->list(); //redirige al método $list
    }
    
    //operación para listar los lugares
    public function list(int $page = 1){
       
        
        
        //comprobar si hay filtros
        $filtro = Filter::apply('places');
        
        //datos para paginación
        $limit = RESULTS_PER_PAGE;  //resultados por paginas
        if ($filtro){
            //recupera el total de lugares con los filtros aplicados
        $total = Place::filteredResults($filtro);    //total de resultados
        
        //crea un objeto paginator
        $paginator = new Paginator('/Place/list', $page, $limit, $total, 'en');
        
        //recupera los resultados para la página actual(el offset lo calcula el paginator)
        $places = Place::filter($filtro, $limit, $paginator->getOffset());
        //si no hay lugar
        }else{
            $total=Place::total();
            //crea el objeto paginator
            $paginator=new Paginator('/Place/list', $page, $limit, $total);
            //recupera todos los lugares
            $places = Place::orderBy('name', 'ASC', $limit, $paginator->getOffset());
        }
        //carga la vista
        $this->loadView('place/list', [
            'places'=> $places,
            'paginator'=> $paginator, //pasamos el objeto Paginator a la vista
            'filtro'=>$filtro
            
        ]);
        
        
    }
    
    //método que muestra los detalles de un lugar
    public function show(int $id = 0){
        
        $place = Place::findOrFail($id, "No se encontro el lugar solicitado.");
        
       $photos = $place->hasMany('Photo');
        //$photos = $place->photos;
        //$photos = $place->belongsTo('Photo');
        $createComments = $place->hasMany('Comment');
      
       
        
         //carga la vista y le pasa el lugar
         $this->loadView('place/show', [
             'place'=> $place,   
             'photos'=> $photos,
             'createComments'=> $createComments,
        
         ]);
    }
    
    //método que muestra el formulario del nuevo lugar
    public function create(){
      
       
        if (!Login::oneRole(['ROLE_USER','ROLE_MODE'])){
            Session::error("No tienes los permisos necesarios para hacer esto.");
            redirect('/');
        }
        
        $this->loadView('place/create', [
            
          
           ]);
    }

    
    //guardar el anuncio
    public function store(){
        
        Auth::oneRole(['ROLE_USER', 'ROLE_MODE']);
        //comprueba que la petición venga del formulario
        if (!$this->request->has('guardar'))
            throw new Exception('No se recibio el formulario');
        $place = new Place();  //crea el nuevo anuncio
        
        $place->name                    =$this->request->post('name');
        $place->type                    =$this->request->post('type');
        $place->location                =$this->request->post('location');
        $place->description             =$this->request->post('description');   
       
        
        $place->iduser=Login::user()->id;

        try{
            $place->save();  //guarda el anuncio
            
         
            if(Upload::arrive('cover')){//si llega el fichero de la portada...
                $place->cover = Upload::save(
                    'cover', //nombre del input
                    '../public/'.AD_IMAGE_FOLDER, //ruta de la carpeta de destino
                    true,     //generar nombre único
                    1240000,   //tamaño máximo
                    'image/*', //tipo mime
                    'ad_'    //prefijo del nombre
                 );
                $place->update(); //añade la foto 
            }
            
            //flashea un mensaje en sesión (para que no se borre al redireccionar)
            Session::success("Guardado del place $place->name correcto.");
            redirect("/Place/show/$place->id");  //redirecciona a los detalles
        }catch (SQLException $e){
            Session::error("No se puede guardar el lugar $place->name");
            
            //si estamos en modo DEBUG, si que iremos a la pagina de error
            if(DEBUG)
                throw new Exception($e->getMessage());
            
            //si no, volveremos al formulario de creación
            //pondremos los valores antiguos en el formulario con los helpers old()
            else 
                redirect("/Place/create");
            //si se produce un error en la subida del fichero(sería después de guardar)    
        }catch(UploadException $e){
            Session::warning("El anuncio se guardo correctamente,
                              pero no se pudo subir el fichero de imagen");
             if(DEBUG)
                  throw new Exception($e->getMessage());
             else 
                 redirect("/Place/edit/$place->id"); //redirecciona a la edición
                 
        }
    }
    
    
   
    
        //muestra el formulario de edición del libro
         public function edit(int $id = 0){
             
             //Primero Auth, luego compruebo quien es y lo comparo con el que esta logeado Y LANZO EXCEPCION
             Auth::check();
            
            $place = Place::findOrFail($id, "No se encontro el lugar.");
            
            if(Login::oneRole(['ROLE_USER']) && $place->iduser != Login::user()->id ){
                Session::error("No tienes los permisos necesarios para hacer esto.");
                redirect('/');
            };
       
                
            //carga la vista con el formulario de edición
            $this->loadView('place/edit', [
                'place'=>$place,
               
                
            ]);
        
      }

        
        //actualiza los datos del anuncio
        public function update() {
            if(!$this->request->has('actualizar')) //si no llega el formulario...
                throw new Exception('No se recibieron datos');
            
                $id = intval($this->request->post('id')); //recuperar el id vía POST
                $place = Place::find($id); //recupera el id desde la BDD
                
                if (!$place) // si no hay anuncio con ese id
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
                    Session::success("Actualización del lugar $place->titulo correcta.");
                    redirect("/Place/edit/$id");
                    //si hay un error al hacer la consulta
                }catch (SQLException $e){
                    Session::error("No se pudo actualizar el lugar $place->titulo.");
                    
                    if (DEBUG)
                           throw new Exception($e->getMessage());//redirecciona los detalles
                    //si hay error al subir el nuevo fichero
                }catch(UploadException $e){
                 Session::warning("El lugar se actualizo correctamente,
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
            $place = Place::find($id);
            
            if(Login::check() && !Login::isAdmin() && $place->iduser != Login::user()->id){
                Session::error("No tienes los permisos necesarios para hacer esto.");
                redirect('/');
            };
            
            if (!$id)
                throw new Exception("No se indico el lugar a borrar.");
            
         
         //comprueba que el lugar existe
         if (!$place)
             throw new NotFoundException("No existe el lugar $id.");
         $this->loadView('place/delete', ['place'=>$place]);
        }
        //elimina el lugar
        public function destroy(){
            //comprueba que llega el formulario de confirmación
            if (!$this->request->has('borrar'))
                throw new FormException('No se recibio la confirmación');
            
           $id = intval($this->request->post('id')); //recupera el identificador
           $place = Place::findOrFail($id); //recupera el libro
           
           //comprueba que el lugar existe
           if (!$place)
               throw new NotFoundException("No existe el lugar $id.");
           
           try{
               $place->deleteObject();
               
               //elimino la foto
               if ($place->foto)
                   @unlink('../public/'.AD_IMAGE_FOLDER.'/'.$place->foto);
               
               Session::success("Se ha borrado el lugar $place->name.");
               redirect("/Place/list");
               
           }catch(SQLException $e){
               Session::error("No se pudo borrar el lugar $place->name.");
               
               if (DEBUG)
                   throw new Exception($e->getMessage());
               else 
                   redirect("/Place/delete/$id");
           }
        }
        //método que muestra los nuevos comentarios
        public function createComment(int $id = 0){
            
            
            if (!Login::oneRole(['ROLE_USER'])){
                Session::error("No tienes los permisos necesarios para hacer esto.");
                redirect('/');
            }
            
            $place= Place::findOrFail($id);
           
            
            $this->loadView('place/createComment',[
                    'place'=>$place,
             
                
            ]);
            
          
        }//método que muestra el formulario del nuevo comentario
        public function createPhotoComment(int $id = 0){
            
            
            if (!Login::oneRole(['ROLE_USER'])){
                Session::error("No tienes los permisos necesarios para hacer esto.");
                redirect('/');
            }
            
            $photo= Photo::findOrFail($id);
            
            
            $this->loadView('photo/createPhotoComment',[
                'photo'=>$photo,
                
                
            ]);
            
            
        }
}

