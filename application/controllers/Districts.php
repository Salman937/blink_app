<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Districts extends CI_Controller 
{
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('user_info');
        
    }
    public function index()
    {
        $districts = $this->user_info->get_districts('districts');

        $Response = array(
                            'message' => "All Districts,Tehsils and TAM'S",
                            'success' => 'true',
                            'status'  => 200,
                            'Data'    => $districts
                        ); 

        echo json_encode($Response);
    }

}

/* End of file Controllername.php */
