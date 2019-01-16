<?php
class  user extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('user_info');
		$this->load->model('model_users');
		$this->load->library('session');
		$this->baseurl=dirname(dirname(base_url()));

		// echo"<pre>";
		// print_r($this->session->all_userdata());die;
	}
	  function members()
	  {
		$data['content']='success';
		 $this->load->view('v_content',$data);
		}
	   function index(){
	
		// $this->load->view('registration_form');
		 	
		$data['content']='v_content';

		$this->load->view('template/header-custom', $data);
 		$this->load->view('template/menu');
    	$this->load->view('registration_form');
    	$this->load->view('template/footer-custom');
		//$this->load->view('registration_form',$data);
	
		}
		
		function registration(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
		$this->form_validation->set_rules(
        'mobilenumber', 'Mobile number',
        'required|is_unique[account.mobilenumber]',
        array(
                $this->form_validation->set_message('is_unique', 'This %s is already registered.')
        )
		);
		
		$this->form_validation->set_rules('roll', 'Roll', 'trim|required');
		$this->form_validation->set_rules('emailad', 'Email Address', 'trim|required|valid_email|is_unique[account.emailad]',
        array(
                $this->form_validation->set_message('is_unique', 'This %s is already registered.')
        ));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
		//$this->form_validation->set_message('is_unique', 'This %s is already registered.');
			if($this->form_validation->run() == FALSE)
			{
				$this->index();
			}
			
			else
			{			
				if($query = $this->user_info->system_is_creating_user())
				{
					redirect("main/login_validation");
					//$this->members();	
				}
				else
				{
					$this->index();			
				}
			}
		}

		function registration_app(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('mobilenumber', 'Mobile number', 'required|is_unique[account.mobilenumber]');
		$this->form_validation->set_rules('roll', 'Roll', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');

			if($this->form_validation->run() == FALSE) {
				$data=array(
				'status' => 'Already Registered !',   
				);
				echo json_encode($data);
				return;
			}
			if($query = $this->user_info->system_is_creating_user_for_app()) {
				
				echo "done";
			}
		}

		function user_register()
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
			$this->form_validation->set_rules('phone', 'Mobile number', 'required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[account.emailad]');
			$this->form_validation->set_rules('address', 'Adress', 'trim|required|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|sha1');
	
			if($this->form_validation->run() == FALSE) 
			{
				$data=array(
							'success' => false,  
							'response_code' => 401,  
							'message' => 'Please Review All Fields',   
				);
				echo json_encode($data);
				die;
			}
			else 
			{
				$data = array (

					'fullname' 		=> $this->input->post('name'),
					'emailad' 		=> $this->input->post('email'),
					'mobilenumber' 	=> $this->input->post('phone'),
					'password' 		=> $this->input->post('password'),
					'profile_image' => 'Null',
					'token_id' 		=> 'Null',
					'address'	 	=> $this->input->post('address'),
					'user_type' 	=> 'user',
				);
				

				$this->db->insert('account',$data);

				$new_data = array(
								'success' => true,  
								'response_code' => 200,  
								'message' => 'User Registered Successfully',   
						   );

				echo json_encode($new_data);

				die;
			}
		}

	/**
	 * [load add new user page]
	 * @return [void]
	 */
	public function new_user()
	{
		$this->data['active']		=	'new_user';
		
		if($this->session->userdata('is_logged_in'))
		{
			$this->data['districts'] = $this->user_info->getAllData('districts','*',array('level' => 0));

			$where = array(
				'districts AS C' => 'A.district_tma_slug = C.slug', 
			  );

			$this->data['users'] = $this->user_info->DJoin('*,B.districts_categories AS district,C.districts_categories AS district_tma','account AS A','districts AS B','A.district_tma_slug = B.slug',$where);

			// echo"<pre>";
			// print_r($this->data['users']);
			// die;

			$this->load->view('template/header',$this->data);
        	$this->load->view('district_users/add_user',$this->data);
        	$this->load->view('template/footer-custom');
	 	}
	 	else
	 	{
		 	redirect('main/login_validation');
	 	}	
	}

	/**
	 * [Add New User]
	 */
	public function add()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]|is_unique[account.emailad]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]|is_unique[account.mobilenumber]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('district_id', 'User District', 'trim|required');

		if ($this->form_validation->run() == FALSE) 
		{
			$this->index();
		} 
		else 
		{
			$data = array(
							'fullname'        => $this->input->post('username'),
							'emailad'         => $this->input->post('email'),
							'mobilenumber'    => $this->input->post('mobile_no'),
							'password' 	      => sha1($this->input->post('password')),
							'district_slug'     => $this->input->post('district_id'),
							'district_tma_slug' => $this->input->post('district_tma_id'),
						 );

			$result = $this->user_info->InsertData('account',$data);

			if ($result) 
			{
				$this->session->set_flashdata('msg','User Added Successfully!');
				redirect('user/new_user');
			} 
			
		}
	}

	/**
	 * [Show All Users]
	 * @param  string $value
	 * @return [void]
	 */
	public function show($value='')
	{
		$data['title']          =  'Traffic Police | Dashboard';
        $data['heading']        =  'Users';
        $data['page_name']      =  'admin/users/users';

        $data['users'] = $this->common_model->getAllData('admin_login','*');

		view('template',$data);	
	}

	/**
	 * [Delete a User]
	 * @param integer $id 
	 */
	public function delete($id='')
	{
		if ($id == 1) 
		{
			$this->session->set_flashdata('msg','You Can Not Delete Super Admin!');
			redirect('dashboard/User/show');
		} 
		
		$this->common_model->DeleteDB('admin_login',array('admin_id' => $id));

		$this->session->set_flashdata('msg','User Deleted Successfully!');
		redirect('dashboard/User/show');
	}

	/**
	 * [get user data for update]
	 * @param  integer $id [description]
	 * @return [void]      
	 */
	public function edit($id='')
	{
		$result = $this->common_model->getAllData('admin_login','*',1,array('admin_id' => $id));

		echo json_encode($result);
	}

	public function update()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('district', 'User District', 'trim|required');

		if ($this->form_validation->run() == FALSE) 
		{
			$this->show();
		} 
		else 
		{
			$data = array(
							'admin_name'     => post('username'),
							'admin_email'    => post('email'),
							'admin_district' => post('district'),
						 );

			$where = array('admin_id' => post('id'));

			$result = $this->common_model->UpdateDB('admin_login',$where,$data);

			if ($result) 
			{
				$this->session->set_flashdata('msg','User Updated Successfully!');
				redirect('dashboard/User/show');
			} 
			
		}
	}

	public function get_tma($id)
	{
		$tmas = $this->user_info->getAllData('districts','*',array('parent_id'=>$id));

		echo '<div class="form-group">
				<label for="sector" class="col-sm-3 control-label">Distirct TMA</label>
				<div class="col-sm-6">
					<select name="district_tma_id" class="form-control" required>';

						foreach ($tmas as $tma):
						
						echo '<option value="'.$tma->slug.'"> '.$tma->districts_categories.' </option>';

						endforeach;

		echo'		</select>
				</div>
			  </div>';
	}

	/**
	 * Slugify Helper
	 *
	 * Outputs the given string as a web safe filename
	 */
	function slugify($string, $replace = array(), $delimiter = '-', $locale = 'en_US.UTF-8', $encoding = 'UTF-8') {
		if (!extension_loaded('iconv')) {
			throw new Exception('iconv module not loaded');
		}
		// Save the old locale and set the new locale
		$oldLocale = setlocale(LC_ALL, '0');
		setlocale(LC_ALL, $locale);
		$clean = iconv($encoding, 'ASCII//TRANSLIT', $string);
		if (!empty($replace)) {
			$clean = str_replace((array) $replace, ' ', $clean);
		}
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower($clean);
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		$clean = trim($clean, $delimiter);
		// Revert back to the old locale
		// setlocale(LC_ALL, $oldLocale);
		return $clean;
	}
}