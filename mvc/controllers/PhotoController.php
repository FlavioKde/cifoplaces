<?php
//controlador para las operaciones con photos
//cada método implementará una operación o un paso de la misma
class PhotoController extends Controller{
    
    //operación por defecto
    public function index(){
        $this->list(); //redirige al método $list
    }
    
    //operación para listar los anuncios
    public function list(int $page = 1){
        
        
        
        //comprobar si hay filtros
        $filtro = Filter::apply('photos');
        
        //datos para paginación
        $limit = RESULTS_PER_PAGE;  //resultados por paginas
        if ($filtro){
            //recupera el total de los anuncios con los filtros aplicados
            $total = Photo::filteredResults($filtro);    //total de resultados
            
            //crea un objeto paginator
            $paginator = new Paginator('/Photo/list', $page, $limit, $total, 'en');
            
            //recupera los resultados para la página actual(el offset lo calcula el paginator)
            $photos = Photo::filter($filtro, $limit, $paginator->getOffset());
            //si no hay anuncio
        }else{
            $total=Photo::total();
            //crea el objeto paginator
            $paginator=new Paginator('/Place/list', $page, $limit, $total);
            //recupera todos los anuncio
            $photos = Place::orderBy('name', 'ASC', $limit, $paginator->getOffset());
        }
        //carga la vista
        $this->loadView('photo/list', [
            'photos'=> $photos,
            'paginator'=> $paginator, //pasamos el objeto Paginator a la vista
            'filtro'=>$filtro
            
        ]);
        
        
    }
    
    //método que muestra los detalles de un anuncio
    public function show(int $id = 0){
        
        $photo = Photo::findOrFail($id, "No se encontro el lugar solicitado.");
        $places = Place::hasMany('Place');
        
        
        
        //carga la vista y le pasa el libro
        $this->loadView('photo/show', [
            'photo'=> $photo,
            'places'=> $places,
        ]);
    }
    
    //método que muestra el formulario del nuevo anuncio
    public function create(){
        
       
        
        if (!Login::oneRole(['ROLE_USER'])){
            Session::error("No tienes los permisos necesarios para hacer esto.");
            redirect('/');
        }
        
       $places = Place::hasMany('place');
        
        $this->loadView('photo/create', [
            'places'=> $places,
            
        ]);
    }
    
    
    //guardar el anuncio
    public function store(){
        
        Auth::oneRole(['ROLE_USER', 'ROLE_ADMIN']);
        //comprueba que la petición venga del formulario
        if (!$this->request->has('guardar'))
            throw new Exception('No se recibio el formulario');
            $photo = new Photo();  //crea el nuevo anuncio
            
            $photo->name                     =$this->request->post('name');
            $photo->date                     =$this->request->post('date');
            $photo->time                     =$this->request->post('time');
            $photo->description              =$this->request->post('description');
            $photo->created_at               =$this->request->post('created_at');
            $photo->updated_at               =$this->request->post('updated_at');
            
            //$place->cover                      =$this->request->post('cover');
            
            $photo->iduser=Login::user()->id;
            
            
            $photo->idplace = $this->request->post('idplace');
            
            
            //con un try-catch local evitaremos ir directamente a la página de error
            //cuando no se pueda gurdar el libro y no estemos en DEBUG
            try{
                $photo->save();  //guarda el anuncio
                
                
                if(Upload::arrive('cover')){//si llega el fichero de la portada...
                    $photo->cover = Upload::save(
                        'cover', //nombre del input
                        '../public/'.AD_IMAGE_FOLDER, //ruta de la carpeta de destino
                        true,     //generar nombre único
                        1240000,   //tamaño máximo
                        'image/*', //tipo mime
                        'ad_'    //prefijo del nombre
                        );
                    $photo->update(); //añade la foto del anuncio
                }
                
                //flashea un mensaje en sesión (para que no se borre al redireccionar)
                Session::success("Guardado del place $photo->name correcto.");
                redirect("/Photo/show/$photo->id");  //redirecciona a los detalles
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
    
    
    
    
    //muestra el formulario de edición del libro
    public function edit(int $id = 0){
        
        //Primero Auth, luego compruebo quien es y lo comparo con el que esta logeado Y LANZO EXCEPCION
        Auth::check();
        
        $photo = Photo::findOrFail($id, "No se encontro el anuncio.");
        
        if(Login::oneRole(['ROLE_USER']) && $photo->iduser != Login::user()->id ){
            Session::error("No tienes los permisos necesarios para hacer esto.");
            redirect('/');
        };
        
        
        //carga la vista con el formulario de edición
        $this->loadView('photo/edit', [
            'photo'=>$photo,
            
            
        ]);
        
    }
    
    
    //actualiza los datos del anuncio
    public function update() {
        if(!$this->request->has('actualizar')) //si no llega el formulario...
            throw new Exception('No se recibieron datos');
            
            $id = intval($this->request->post('id')); //recuperar el id vía POST
            $photo = Photo::find($id); //recupera el id desde la BDD
            
            if (!$photo) // si no hay anuncio con ese id
                throw new NotFoundException("No se ha encontrado el anuncio $id.");
                //recuperar el resto de campos
                $photo->name               =$this->request->post('name');
                $photo->date               =$this->request->post('date');
                $photo->time               =$this->request->post('time');
                $photo->description        =$this->request->post('description');
                $photo->created_at         =$this->request->post('created_at');
                $photo->updated_at         =$this->request->post('updated_at');
                
                try{
                    $photo->update();//actualiza los datos del anuncio
                    
                    //si hay que hacer cambios en la portada lo haremos con un segundo update()
                    //de esta forma nos aseguraremos que se ha actualizado el anuncio
                    //independientemente de si pudo procesar el fichero o no
                    $secondUpdate = false; //flag para saber si hay que actualizar de nuevo
                    $oldCover = $place->foto;  //portada antigua
                    
                    if (Upload::arrive('cover')){ //si llega una nueva foto
                        $photo->cover = Upload::save(
                            'cover' , '../public/'.AD_IMAGE_FOLDER, true, 0, 'image/*', 'book_'
                            );
                        $secondUpdate = true;
                    }
                    //si hay que eliminar portada, el libro tenía una anterior y no llega una nueva...
                    if (isset($_POST['eliminarfoto']) && $oldCover && !Upload::arrive('cover')){
                        $photo->cover = NULL;
                        $secondUpdate = true;
                    }
                    if ($secondUpdate){
                        $photo->update(); //aplica los cambios en la BDD(actualiza la portada)
                        @unlink('../public/'.AD_IMAGE_FOLDER.'/' .$oldCover); //elimina la portada anterior
                    }
                    Session::success("Actualización del anuncio $photo->name correcta.");
                    redirect("/Photo/edit/$id");
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
            
            //recupera el anuncio con dicho identificador
            // $anuncio = Anuncio::find($id);
            
            //comprueba que el anuncio existe
            if (!$photo)
                throw new NotFoundException("No existe el photo $id.");
                $this->loadView('photo/delete', ['photo'=>$photo]);
    }
    //elimina el anuncio
    public function destroy(){
        //comprueba que llega el formulario de confirmación
        if (!$this->request->has('borrar'))
            throw new FormException('No se recibio la confirmación');
            
            $id = intval($this->request->post('id')); //recupera el identificador
            $photo = Photo::findOrFail($id); //recupera el libro
            
            //comprueba que el libro existe
            if (!$photo)
                throw new NotFoundException("No existe el anuncio $id.");
                
                try{
                    $photo->deleteObject();
                    
                    //elimino la foto
                    if ($photo->foto)
                        @unlink('../public/'.AD_IMAGE_FOLDER.'/'.$photo->foto);
                        
                        Session::success("Se ha borrado el anuncio $photo->name.");
                        redirect("/Photo/list");
                        
                }catch(SQLException $e){
                    Session::error("No se pudo borrar el libro $photo->name.");
                    
                    if (DEBUG)
                        throw new Exception($e->getMessage());
                        else
                            redirect("/Photo/delete/$id");
                }
    }
    
}