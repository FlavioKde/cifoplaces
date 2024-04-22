<?php
//Controlador de la operación 'contacto'
class ContactoController extends Controller{
    public function index(){
        //carga la vista con el formulario de contacto
        $this->loadView('contacto');
    }
    public function send(){
        if(empty($this->request->post('enviar')))
            throw new FormException('No se recibio el formulario de contacto.');
        
            //toma los datos del formulario de contacto
            
            $from=$this->request->post('email');
            $name=$this->request->post('nombre');
            $subject=$this->request->post('asunto');
            $message=$this->request->post('mensaje');
            
            
         
             //prepara y enviar el email
            try { 
             $email = new Email(ADMIN_EMAIL, $from, $name, $subject, $message);
             $email->send();
             
             Session::success('Mensaje enviado, en breve recibirás una respuesta.');
             redirect('/');
                  
             }catch (EmailException $e){
             
                       Session::error("No se ha enviado el mensaje");
                       if(DEBUG){
                           throw new Exception($e->getMessage());
                       } else{
                        redirect("/Contacto");
         
    }
   }
    }
}