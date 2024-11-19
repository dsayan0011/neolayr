<?php

class Admin_users_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteAdminUser($id)
    {
        $this->db->where('id', $id);
        if (!$this->db->delete('users')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getAdminUsers($user = null)
    {
        if ($user != null && is_numeric($user)) {
            $this->db->where('id', $user);
        } else if ($user != null && is_string($user)) {
            $this->db->where('username', $user);
        }
        $query = $this->db->get('users');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }
	
	public function getAdminUsersLevel($user = null)
    {
       
        $query = $this->db->get('user_levels');
        if ($user != null) {
            return $query->row_array();
        } else {
            return $query;
        }
    }

    public function setAdminUser($post)
    {
        if ($post['edit'] > 0) {
            if (trim($post['password']) == '') {
                unset($post['password']);
            } else {
                $post['password'] = md5($post['password']);
            }
            $this->db->where('id', $post['edit']);
            unset($post['id'], $post['edit']);
            if (!$this->db->update('users', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        } else {
            unset($post['edit']);
            $post['password'] = md5($post['password']);
            if (!$this->db->insert('users', $post)) {
                log_message('error', print_r($this->db->error(), true));
                show_error(lang('database_error'));
            }
        }
    }
	public function deleteAdminUserLevel($id)
    {
        $this->db->where('user_level_id', $id);
        if (!$this->db->delete('user_levels')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	function getAllMemberpermission()
	{
	   $this->db->select('*');
	   $this->db->from('user_permissions');
	   
	   $query = $this->db->get();
	   
	   return $query->result_array(); 
	}
	function getAllMemberpermissionType()
	{
	   $this->db->select('*');
	   $this->db->from('user_permission_types');
	   
	   $query = $this->db->get();
	   
	   return $query->result_array(); 
	}
	function addMemberLevel()
	{
		    $data = array(
			'user_level_active' => "yes",
			'user_level_name' => $this->input->post('level_name'),
			'user_level_is_default' => "yes"
			); 
			
			 $query=$this->db->insert('user_levels', $data);
			 return $this->db->insert_id();
	}
	function addLevelPermission($level_id)
	{
			$post_data = $this->input->post();
			$display_order = implode(",",$post_data['display_order']);
			$update_order = implode(",",$post_data['update_order']);
			
			unset($post_data['level_name']);
			unset($post_data['edit']);
			unset($post_data['add_new_level']);
			unset($post_data['display_order']);
			unset($post_data['update_order']);
			$data = array('user_level_id' => $level_id);
			foreach($post_data as $key=>$value){
				$data[$key] = $value;
			}
		   
			$data['display_order'] = $display_order;
		    $data['update_order'] = $update_order;
			 $query=$this->db->insert('user_levels_permissions', $data);
			 return $this->db->insert_id();
	}
	function getLevelDetails($level_id)
	{
		   $this->db->select('*');
		   $this->db->from('user_levels');
		   $this->db->join('user_levels_permissions','user_levels.user_level_id=user_levels_permissions.user_level_id');
		   $this->db->where('user_levels.user_level_id', $level_id);
		   $query = $this->db->get();
		   
		   return $query->row_array();
	}
	function updateLevelDetails($level_id)
	{
		    $data = array(
							'user_level_name' => $this->input->post('level_name')
						 ); 
						 
			
			$this->db->where('user_level_id', $level_id);
			$this->db->update('user_levels', $data);
	}
	function updateLevelPermission($level_id)
	{
		    $update_data = array();
			$post_data = $this->input->post();
			$display_order = implode(",",$post_data['display_order']);
			$update_order = implode(",",$post_data['update_order']);
			
			unset($post_data['level_name']);
			unset($post_data['edit']);
			unset($post_data['add_new_level']);
			unset($post_data['display_order']);
			unset($post_data['update_order']);
			foreach($post_data as $key=>$value){
				$update_data[$key] = $value;
			}
		   	$update_data['display_order'] = $display_order;
		    $update_data['update_order'] = $update_order;
			
			 $this->db->where('user_level_id', $level_id);
			 $this->db->update('user_levels_permissions', $update_data);
	}
	function checkPermission($permission_type,$staus,$level_id)
	{
	   $this->db->select('*');
	   $this->db->from('user_levels_permissions');
	   $this->db->where(array($permission_type => $staus,'user_level_id' => $level_id));
	   $query = $this->db->get();
	   
	   $count = $query->num_rows();
		
		if($count>0)
			return true;
		else
			return false;
	   
	   
	}
}
