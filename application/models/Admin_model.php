<?php

class Admin_model extends CI_Model {
	function __construct(){
      $this->load->database();
    
        } 
	public function user_data_save($table,$table_no,$user_name,$id_tables,$priority){
	$date_created = date("Y-m-d h:i:s");
	 $priority = $priority + 1;
	 $sql= "INSERT INTO Queue (table_id, player_name, seat_no,priority,status,created,`update`)
     VALUES ('$id_tables','$user_name','$table_no','$priority','1','$date_created','')";
	 $this->db->query($sql);
	 }
	public function get_table_id($data){
	    $result = $this->db->query("SELECT `id` FROM `tables` WHERE `name`='$data'");
        $id = $result->row();
        return $id->id;
       }
    public function get_priority(){
		 $last_row = $this->db->select('priority')->where('status',1)->order_by('priority',"desc")->limit(1)->get('Queue')->row();
		 if(empty($last_row)){
			$priority = 0; 
			 }else{
			$priority = $last_row->priority;	 
				 }
		  
 		 return $priority;
		 }
	 public function get_all_user_ordered_by_priority(){
		  $result = $this->db->select("*")->where('status',1)->order_by('priority',"ASC")->get('Queue');
		  return $result;
		  
		  } 
	 public function up_user_priority_by_id($id){
		  $result = $this->db->select("priority")->where('id',$id)->get('Queue')->row();
		  $priority = $result->priority;
		  $table_id = $this->get_table_id_by_id($id);
		  $query="SELECT id FROM Queue WHERE priority < $priority AND status = 1 AND table_id='$table_id' ORDER BY priority DESC LIMIT 1";
		  $result = $this->db->query($query);
		  $previous_id = $result->row();
		  if(empty($previous_id)){
			 $prev_id = $id;
			  }else{
		  $prev_id = $previous_id->id;
         }
          $result = $this->db->select("priority")->where('id',$prev_id)->get('Queue')->row();
		  $prev_priority = $result->priority;
		  $this->update_user_up($id,$prev_priority,$table_id);
		  $this->update_user_down($prev_id,$priority,$table_id);
		   $result = $this->get_all_user_for_table($table_id);
		   return $result;
		 }
		function get_all_player_priority_same_table($table_id){
		  $query="SELECT id FROM Queue WHERE table_id='$table_id' AND status='1' ORDER BY priority ASC ";
		  $result = $this->db->query($query);
		  $all_user_same_table = $result->result_array();
		  return $all_user_same_table;
		   }  
		 function update_user_up($id,$prev_priority,$table_id){
		  $sql="UPDATE Queue
               SET priority = '$prev_priority'
               WHERE id = '$id'";
		  $this->db->query($sql);
			
		  }
		 function update_user_down($prev_id,$priority,$table_id){
		  $sql="UPDATE Queue
               SET priority = '$priority'
               WHERE id = '$prev_id'";
		  $this->db->query($sql);
	            
			  }
	 public function down_user_priority_by_id($id){
		  $result = $this->db->select("priority")->where('id',$id)->get('Queue')->row();
		  $priority = $result->priority;
		  $table_id = $this->get_table_id_by_id($id);
		  $query="SELECT id FROM Queue WHERE priority > $priority AND status = 1 AND table_id='$table_id' ORDER BY priority ASC LIMIT 1";
		  $result = $this->db->query($query);
		  $change_id = $result->row();
          if(empty($change_id)){
			$id_next = $id;  
			  }else{
          $id_next = $change_id->id;
	        }
          $result = $this->db->select("priority")->where('id',$id_next)->get('Queue')->row();
		  $priority_next = $result->priority;
		  $this->update_user_up($id_next,$priority,$table_id);
		  $this->update_user_down($id,$priority_next,$table_id);
		  $result = $this->get_all_user_for_table($table_id);
		  return $result;
		 }
	  public function get_all_user_for_table($table_id){
		  $query="SELECT * FROM Queue WHERE table_id='$table_id' AND status='1' ORDER BY priority ASC";
		  $result = $this->db->query($query); 
		  $all_user = $result->result_array();
		   return $all_user;
		  }	 
	  public function delete_user($id){
		  $table_id = $this->get_table_id_by_id($id);
		  $query="DELETE FROM Queue WHERE id='$id'";
		  $result = $this->db->query($query); 
		  $result = $this->get_all_user_for_table($table_id);
		  return $result;
		  
		  }
	  public function get_table_id_by_id($id){
		  $table_id = $this->db->select("table_id")->where('id',$id)->get('Queue')->row();
		  $table_id = $table_id->table_id;
		  return $table_id;
		  } 
	  public function edit_user($id,$seat_no,$name){
		  $sql="UPDATE Queue
                SET player_name='$name', seat_no='$seat_no'
                WHERE id='$id'";
           $query_result = $this->db->query($sql); 
           $table_id = $this->get_table_id_by_id($id);     
		   $result = $this->get_all_user_for_table($table_id);
		  return $result;
		  }	   		   	 
	
	}

	
