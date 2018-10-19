<?php
class user_info extends CI_Model
{
	public function system_is_creating_user()
	{
	    $data['fullname'] = $this->input->post('fullname');
		$data['emailad']   =$this->input->post('emailad');
	   	$data['mobilenumber']  = $this->input->post('mobilenumber');
	   	
	   	$data['roll']  = $this->input->post('roll');
	   	$data['password']  = sha1($this->input->post('password'));
	   	$data['zones_id']  = $this->input->post('zones');
	   	$data['uc_id']  = $this->input->post('uc');
	   	$data['nc_id']  = $this->input->post('nc');
	   	//$data['address']  = $this->input->post('address');

		$query=$this->db->insert('account',$data);
		   return $query;
	   
	   }
	   public function system_is_creating_user_for_app(){
	 
		
	    $data['fullname'] = $this->input->post('fullname');
		$data['emailad']   =$this->input->post('emailad');
	   	$data['mobilenumber']  = $this->input->post('mobilenumber');
	   	$data['roll']  = $this->input->post('roll');
	   	$data['password']  = sha1($this->input->post('password'));
	   	$data['address']  = $this->input->post('address');
	   	//$data['uc_id']  = $this->input->post('uc');
	   	//$data['nc_id']  = $this->input->post('nc');
		
	    $query=$this->db->insert('account',$data);
			$data=array(
				'status' => 'Successfully Registered !',   
			);
			
			if($query){
				echo json_encode($data);
			   }
			   else{
				echo json_encode("Registeration Faild !");
			   }
	   
	   }
	   
	   function upload(){
	
			$config['upload_path'] = './uploads/profile/';
		
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '100000';
			$config['max_width']  = '10240';
			$config['max_height']  = '7680';
			$config['encrypt_name'] = true;
		
		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload('profile_image')){
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}
		else{
			$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}
	public function get_districts($table)
	{
		$query = $this->db->get($table);
		
		return $query->result();
	}
	function getAllData($table,$specific='',$Where='',$order='',$limit='',$groupBy='',$like = '')
	{
		// If Condition
		if (!empty($Where)):
			$this->db->where($Where);
		endif;
		// If Specific Columns are require
		if (!empty($specific)):
			$this->db->select($specific);
		else:
			$this->db->select('*');
		endif;

		if (!empty($groupBy)):
			$this->db->group_by($groupBy);
		endif;
		// if Order
		if (!empty($order)):
			$this->db->order_by($order);
		endif;
		// if limit
		if (!empty($limit)):
			$this->db->limit($limit);
		endif;

		//if like
		if(!empty($like)):
			$this->db->like('title', $like);
		endif;	
		// get Data
		$GetData = $this->db->get($table);
		return $GetData->result();
	}
	function InsertData($table,$Data)
	{
		$Insert = $this->db->insert($table,$Data);
		if ($Insert):
			return true;
		endif;
	}
	function DJoin($field,$tbl,$jointbl1,$Joinone,$jointbl3='',$Where='',$order='',$groupy = '',$limit = '',$like = '')
    {
        $this->db->select($field);
        $this->db->from($tbl);
        $this->db->join($jointbl1,$Joinone);
        if (!empty($jointbl3)):
            foreach ($jointbl3 as $Table => $On):
                $this->db->join($Table,$On);
            endforeach;
        endif;
        // if Group
		if (!empty($groupy)):
			$this->db->group_by($groupy);
		endif;
        if(!empty($order)):
            $this->db->order_by($order);
        endif;
        if(!empty($Where)):
            $this->db->where($Where);
        endif;
        if(!empty($limit)):
            $this->db->limit($limit);
        endif;
        
        if(!empty($like)):
            $this->db->like('title', $like);
        endif;

        $query=$this->db->get();
        return $query->result();
	}
	function Authentication($table,$data)
	{
		$this->db->where($data);
		$query = $this->db->get($table);
		if ($query) {
			return $query->row();
		}
		else
		{
			return false;
		}
	}
}
