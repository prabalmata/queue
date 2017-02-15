<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
   
	public function index()
	{
        $this->load->view('header');
		$this->load->view('welcome_message');
		
	}
	public function ajax_data_submit_admin(){
	   $table = $_POST['table'];
	   $table_no = $_POST['table_no'];
	   $user_name = $_POST['user_name'];
	    $this->load->model("admin_model");
	   $id_tables = $this->admin_model->get_table_id($table);
	   $priority = $this->admin_model->get_priority();
	   $all_result  = $this->admin_model->user_data_save($table,$table_no,$user_name,$id_tables,$priority);
	    $all_result  = $this->admin_model->get_all_user_for_table($id_tables);		
		echo json_encode($all_result);
		}
	 public function ajax_data_up_position(){
		   $this->load->model("admin_model");
		   $id = $_POST['id'];
		   $all_user = $this->admin_model->up_user_priority_by_id($id);
		   echo json_encode($all_user);
		  }
	 public function ajax_data_down_position(){
		   $this->load->model("admin_model");
		   $id = $_POST['id'];
		   $all_user = $this->admin_model->down_user_priority_by_id($id);
		  	echo json_encode($all_user);	
		}
		public function ajax_get_table_selected_list(){
		  $this->load->model("admin_model");
		  $table = $_POST['table'];
		  $id_tables = $this->admin_model->get_table_id($table);
		  $all_user = $this->admin_model->get_all_user_for_table($id_tables);
		  echo json_encode($all_user);
		  }
		 public function ajax_data_cancel(){
			$this->load->model("admin_model");
			$id = $_POST['id']; 
			$all_user = $this->admin_model->delete_user($id);
			 echo json_encode($all_user);
			 }
		 public function ajax_data_edit(){
			$this->load->model("admin_model");
			$id = $_POST['id'];			 
			$seat_no = $_POST['seat_no'];			 
			$name = $_POST['name'];			 
			$all_user = $this->admin_model->edit_user($id,$seat_no,$name);
			 echo json_encode($all_user);			 
			 }	  	 
	}

