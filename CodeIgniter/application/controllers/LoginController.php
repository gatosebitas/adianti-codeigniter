<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{


function __construct()
{
    parent::__construct();
    //$this->load->model('LoginModel');
}

public function index(){

    $datos['cui'] = $_POST['cui'];

    //$datos['password']= md5( $_POST['password']);

    //$users = $this->LoginModel ->login($datos);

    
    #Miramos que ha devuelto el modelo
    $sesion_authorization=TSession::getValue('SESION_AUTHORIZATION');
    if (empty($sesion_authorization)){
        //header("location: /listado");
        
        //$this->load->view('login');
        $this->load->view('login');
        
    }else{
        //header("location: /login/error");
        $this->load->view('videos');
    }
}

public function error(){
    echo "LOGIN ERROR";

}
public function listado(){
    echo "LOGIN VALIDADO";
}


public function logout(){
    echo "SESION CERRRADA CON EXITO";
    TSession::setValue('SESION_AUTHORIZATION', null);
    $this->load->view('login');
}

public function autenticacion(){

    try
		{
			// open a transaction with database 'database'
			TTransaction::open('database');

            $usuario = new ViewUsers( $_POST['cui']);
            if($usuario->password ==   $_POST['password']){
                TSession::setValue('SESION_AUTHORIZATION',$usuario);
                echo "Login correcto";
                $this->load->view('videos');
            }else

			$this->load->view('login');

			// close the transaction
			TTransaction::close();
		}
		catch(Exception $e) // in case of exception
		{
            echo "USUARIO NO ENCONTRADO";
            $this->load->view('login');
			TTransaction::close();
		}
			
}
}