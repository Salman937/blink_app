<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Districts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(array('user_info', 'common_model'));

    }
    public function index()
    {
        $districts = $this->user_info->get_districts('districts');

        $Response = array(
            'message' => "All Districts,Tehsils and TAM'S",
            'success' => 'true',
            'status' => 200,
            'Data' => $districts
        );

        echo json_encode($Response);
    }

    public function districts()
    {
        if ($this->input->post()) {

            $data['districts_categories'] = $this->input->post('district_name');

            $query = $this->db->insert('districts', $data);

            if ($query) {
                $this->session->set_flashdata('success', "District Inserted Successfully");
                redirect('Districts/districts');
            } else {
                $this->session->set_flashdata('error', "Error!");
                redirect('Districts/districts');
            }
        }
        else {
            
            $this->data['active'] = 'district';
            $this->data['head_districts'] = $this->common_model->getAllData('districts', '*', array('level' => 0));
            
            $this->load->view('template/header');
            $this->load->view('districts/district', $this->data);
            $this->load->view('template/footer-custom');
        }
    }

    public function delete_district($id)
    {
        $this->common_model->DeleteDB('districts',array('id' => $id));

        $this->session->set_flashdata('success', "District Deleted Successfully");
        redirect('Districts/districts');
    }

    public function edit_district($id)
    {
        $this->data['district'] = $this->common_model->getAllData('districts', '*', array('level' => 0));

        $this->load->view('template/header');
        $this->load->view('districts/district', $this->data);
        $this->load->view('template/footer-custom');
    }
    public function districts_tma()
    {
        if ($this->input->post()) {

            $data['parent_id'] = $this->input->post('district');
            $data['districts_categories'] = $this->input->post('district_tma');
            $data['slug'] = $this->slugify($this->input->post('district_tma'));
            $data['level'] = 1;

            $query = $this->db->insert('districts', $data);

            if ($query) {
                $this->session->set_flashdata('success', "District TMA Inserted Successfully");
                redirect('Districts/districts_tma');
            } else {
                $this->session->set_flashdata('error', "Error!");
                redirect('Districts/districts_tma');
            }
        }
        else {
            
            $this->data['active'] = 'tma-district';
            $this->data['districts'] = $this->common_model->DJoin('*, head_districts.districts_categories AS head_districts,district_tma.districts_categories AS tma_districts ','districts AS head_districts','districts AS district_tma','head_districts.id = district_tma.parent_id');

            $this->data['head_districts'] = $this->common_model->getAllData('districts', '*', array('level' => 0));

            // echo"<pre>";
            // print_r($this->data['districts']);
            // die;
            
            $this->load->view('template/header');
            $this->load->view('districts/tma-district', $this->data);
            $this->load->view('template/footer-custom');
        } 
    }

    public function slugify($string, $replace = array(), $delimiter = '-', $locale = 'en_US.UTF-8', $encoding = 'UTF-8') {
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

/* End of file Controllername.php */
