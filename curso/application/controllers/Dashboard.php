<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	public function index()
	{
		//$this->load->view('welcome_message');
		/*$this->load->view('includes/header');
		$this->load->view('includes/sidebar');
		$this->load->view('includes/footer');
		$this->load->view('index');*/
		$this->loadViews("index");

	}

	public function login(){
		if($_POST['username'] && $_POST['password']){
			$login=$this->Site_model->loginUser($_POST);
			//print_r($login);
			if ($login) {
				$array = array(
				'id' =>$login[0]->id ,
				'nombre' =>$login[0]->nombre ,
				'apellidos' =>$login[0]->apellidos ,
				'username' =>$login[0]->username , 
				'curso' =>$login[0]->curso 
			);

				if(isset($login[0]->is_profesor)){
					$array['tipo']="profesor";
				}else if(isset($login[0]->is_alumno)){
					$array['tipo']="alumno";
				}

				$this->session->set_userdata($array);
				print_r($_SESSION);
		}
}

		$this->loadViews('login');
	}

		//Function mis tareas
	function misTareas(){

		if ($_SESSION['id']) {
		$data['tareas']=$this->Site_model->getTareas($_SESSION['curso']);
		$this->loadViews("mistareas",$data);
		
		}else{
			redirect(base_url()."Dashboard/login","location");
		}
		
	}

//GESTION ALUMNOS
	function gestionAlumnos(){
		if ($_SESSION['tipo']=="profesor") {

      $data['alumnos']=$this->Site_model->getAlumnos($_SESSION['curso']);
			$this->loadViews("gestionalumnos",$data);	
		}else{
			redirect(base_url()."Dashboard","location");
		}
		   	
		
	}//end

	//FUNCION LOAD VIEWS
	function loadViews($view,$data=null){
		//Si tenemos sesion creda
		if($_SESSION['username']){
			//so la vista es login redirige a la home
			if ($view=="login") {
				redirect(base_url()."Dashboard","location");
			}


//si es una vista cualquiera se carga
		$this->load->view('includes/header');
		$this->load->view('includes/sidebar');
		$this->load->view('includes/footer');
		$this->load->view($view,$data);
		//si no tenemos sesion
		}else{

			//si la vista el login se carga

			if($view=="login"){
				$this->load->view($view);
			}else{
			redirect(base_url()."Dashboard/login","location");			
			}
		}
	}



	//Function eliminar alumno
	function eliminarAlumno(){

		if ($_POST['idalumno']) {
		$this->Site_model->deleteAlumno($_POST['idalumno']);
		}
	}

	//Funcion crear tareas
	function crearTareas(){

		//Si se ejecuto un formulario
		if ($_POST) {
			if ($_FILES['archivo']) {
				$config['upload_path']          = './uploads/';
              $config['allowed_types']        = 'gif|jpg|png';
            
              //nombre del archivo
			  $config['file_name']=uniqid().$_FILES['archivo']['name'];
              $this->load->library('upload', $config);

              if ( ! $this->upload->do_upload('archivo'))
                {
                   echo "Error";
                }
                else
                {
                   $this->Site_model->uploadTarea($_POST,$config['file_name']);
                }
			}//if files
			  else{
			  	//si no hay una imagen no le pasamos el archivo
			  	$this->Site_model->uploadTarea($_POST);
			  }
                
		}//--if post

		$this->loadViews("crearTareas");
	}

	//funcion mensajes
	function mensajes(){
		if ($_SESSION['id']) {

			//insertar
			if ($_POST) {
				$token=$this->Site_model->getToken($_SESSION['id'],$_SESSION['tipo']);
				$this->Site_model->insertMensaje($_POST,$token);
			}
			//obtener usuarios
			$data['usuarios']=$this->Site_model->getUsuarios($_SESSION['tipo'],$_SESSION['curso']);

			$token=$this->Site_model->getToken($_SESSION['id'],$_SESSION['tipo']);
			//echo "TOKEN ".$token;
			//obtener mensajeria
			$data['mensajes']=$this->Site_model->getMensajes($token);

			$this->loadViews("mensajes",$data);
		}else{
			redirect(base_url()."Dashboard/login","location");	
		}
	}

	//funcion ver mensaje
	function getMensaje(){
		echo $_POST;
	}

}
