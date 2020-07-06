<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model {

	public function loginUser($data){
		$this->db->select("*");
		$this->db->from("profesores");
		$this->db->where("username",$data['username']);
		$this->db->where("password",md5($data['password']));

		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{

			$this->db->select("*");
			$this->db->from("alumnos");
			$this->db->where("username",$data['username']);
		$this->db->where("password",md5($data['password']));

		$queryalumno=$this->db->get();

		if($queryalumno->num_rows()>0){
			return $queryalumno->result();
		}

			return NULL;
		
			
		}
		}

		//FUNCION GET ALUMNOS
		public function getAlumnos($curso){

			$this->db->select("*");
			$this->db->from("alumnos");
			$this->db->where("curso",$curso);
			$this->db->where("deleted",0);

			$query=$this->db->get();
			//print_r("LQ ".$this->db->last_query());
			if($query->num_rows()>0){
			return $query->result();
				}else{
					return NULL;
				}	
			
		}

		//FUNCION GET ALUMNOS
		public function deleteAlumno($id){

			$array=array(
				"deleted"=>1
			);
			
			$this->db->where("id",$id);
			$this->db->update("alumnos",$array);
		}

		//FUNCION UPLOAD TAREAS
		//nulo porque habra casos donde será nulo
		function uploadTarea($data,$archivo=null){
			if ($archivo) {
				$array=array(
				"nombre"=>$data['nombre'],
				"descripcion"=>$data['descripcion'],
				"fecha_inicial"=>$data['fecha'],
				"archivo"=>$archivo,
				"curso"=>$data['curso']
			);
			}//si hay archivo
			else{
				$array=array(
				"nombre"=>$data['nombre'],
				"descripcion"=>$data['descripcion'],
				"fecha_inicial"=>$data['fecha'],
				"curso"=>$data['curso']
			);
			}
			

			$this->db->insert("tareas",$array);
		}

		//FUNCTION GET TAREAS
		function getTareas($curso){
			$this->db->select("*");
			$this->db->from("tareas");
			$this->db->where("curso",$curso);
			$this->db->order_by("fecha_inicial","ASC");

			$query=$this->db->get();
			//print_r($this->db->last_query());

			if ($query->num_rows()>0) {
			  return $query->result();
			}else{
				return NULL;
			}
		}

		//FUNCION GET USUARIOS
		function getUsuarios($tipo,$curso){
			$this->db->select("*");
			if ($tipo=="profesor") {
				$this->db->from("alumnos");
			}
			if ($tipo=="alumno") {
				$this->db->from("profesores");
			}
			$this->db->where("curso",$curso);
			$query=$this->db->get();
			//print_r($this->db->last_query());

			if ($query->num_rows()>0) {
			  return $query->result();
			}else{
				return NULL;
			}
		}

		//FUNCION INSERTAR MENSAJE
		function insertMensaje($data,$iduser){
			$array=array(
				"texto"=>$data['mensaje'],
				"id_from"=>$iduser,
				"id_to"=>$data['id_to']
			);

			$this->db->insert("mensajes",$array);
		}

		//FUNCION GET TOKEN
		function getToken($id,$tipo){
			$this->db->select("*");
			$this->db->where("id",$id);

			if ($tipo=="profesor") {
			$this->db->from("profesores");
			}else if ($tipo=="alumno") {
			$this->db->from("alumnos");
			}

			$query=$this->db->get();
			//print_r($this->db->last_query());

			if ($query->num_rows()>0) {
			  $result= $query->result();//porq solo quiero el token
			  return $result[0]->token_mensaje;
			}else{
				return NULL;
			}
		}

		//FUNCION GET MENSAJES
		function getMensajes($token){
			$this->db->select("*");
			$this->db->where("id_to",$token);
			$this->db->from("mensajes");

			$query=$this->db->get();

			if ($query->num_rows()>0) {
			  return $query->result();
			}else{
				return NULL;
			}
		}


		//FUNCION GET MENSAJES
		function getNombre($id){
			$this->db->select("*");
			$this->db->from("alumnos");
			$this->db->where("token_mensaje",$id);

			$query1=$this->db->get_compiled_select();

			$this->db->select("*");
			$this->db->from("profesores");
			$this->db->where("token_mensaje",$id);

			$query2=$this->db->get_compiled_select();

			$query=$this->db->query($query1." UNION ".$query2);
			//print_r($this->last_query());

			if ($query->num_rows()>0) {
			  return $query->result();
			}else{
				return NULL;
			}
		}

		//FUNCION GET MENSAJE
		function getTextMensaje($idmensaje){
			$this->db->select("*");
			$this->db->from("mensajes");
			$this->db->where("id",$idmensaje);

			$query=$this->db->get();

			if ($query->num_rows()>0) {
				//marcar como leido
				$array=array(
					"is_read"=>1
				);
				$this->db->where("id",$idmensaje);
				$this->db->update("mensajes",$array);

			  return $query->result();
			}else{
				return NULL;
			}
		}
		
	}

