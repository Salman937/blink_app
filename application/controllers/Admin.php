<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(array('common_model','model_users'));

        if (!$this->session->userdata('is_logged_in')) {
            redirect('main/login_validation');
        }

        // print_r($this->session->all_userdata());die;
    }
    public function all_complaints()
    {
        $account_id = $this->input->get('account_id');

        $where = $this->common_model->getAllData('account', '*', array('account_id' => $account_id));

        $all_comp = $this->db->where('district_tma_slug', $where[0]->district_tma_slug)
            ->count_all_results('complaint');

        $completed = $this->db->where('status', 'completed')
            ->where('district_tma_slug', $where[0]->district_tma_slug)
            ->count_all_results('complaint');

        $pending = $this->db->where('status', 'pendingreview')
            ->where('district_tma_slug', $where[0]->district_tma_slug)
            ->count_all_results('complaint');

        $inprogress = $this->db->where("status", "inprogress")
            ->where('district_tma_slug', $where[0]->district_tma_slug)
            ->count_all_results('complaint');

        $status = array('pendingreview', 'inprogress');

        $query = $this->db->select("*")
            ->from('complaint')
            ->or_where_in('status', $status)
            ->get()->result();

        $dates = array();

        foreach ($query as $new_query) {
            $expiry_date = $new_query->created_at;

            $expiry_date = new DateTime($expiry_date);
            $today = new DateTime();
            $interval = $today->diff($expiry_date);
            $day = $interval->days;

            if ($day > 7) {
                $arr = array(

                    'c_id' => $new_query->c_id,
                    'district_slug' => $new_query->district_slug,
                    'district_tma_slug' => $new_query->district_tma_slug,
                    'account_id' => $new_query->account_id,
                    'c_number' => $new_query->c_number,
                    'c_details' => $new_query->c_details,
                    'image_path' => $new_query->image_path,
                    'longitude' => $new_query->longitude,
                    'latitude' => $new_query->latitude,
                    'bin_address' => $new_query->bin_address,
                    'c_date' => $new_query->c_date,
                    'c_time' => $new_query->c_time,
                    'c_date_time' => $new_query->c_date_time,
                    'c_type' => $new_query->c_type,
                    'status' => $new_query->status,
                    'token_id' => $new_query->token_id,
                    'created_at' => $new_query->created_at,
                    'updated_at' => $new_query->updated_at,
                );

                array_push($dates, $arr);
            }
        }
        $total_over_due = count($dates);


        $Response = array(
            'message' => 'Total Complaints',
            'status' => true,
            'all_complaints' => $all_comp,
            'completed_complaints' => $completed,
            'pending_complaints' => $pending,
            'inprogress_complaints' => $inprogress,
            'over_due_complaints' => $total_over_due,
        );

        echo json_encode($Response);
    }

    public function all_complaints_list()
    {
        $where = $this->common_model->getAllData('account', '*', array('account_id' => $this->input->post('account_id')));

        $all_comps = $this->common_model->getAllData('complaint', '*', array('district_tma_slug' => $where[0]->district_tma_slug));

        if (!empty($all_comps)) {
            $Response = array(
                'message' => 'Total Complaints',
                'status' => true,
                'all_complaints' => $all_comps,
            );

            echo json_encode($Response);
        } else {
            $Response = array(
                'message' => 'No Complaints found',
                'status' => false,
                'all_complaints' => $all_comps,
            );

            echo json_encode($Response);
        }
    }

    public function all_complaints_pending_list()
    {
        $where = $this->common_model->getAllData('account', '*', array('account_id' => $this->input->post('account_id')));

        $where_pending = array(

            'district_tma_slug' => $where[0]->district_tma_slug,
            'status' => 'pendingreview'
        );

        $all_pendings = $this->common_model->getAllData('complaint', '*', $where_pending);

        if (!empty($all_pendings)) {
            $Response = array(
                'message' => 'Total Complaints',
                'status' => true,
                'all_pending_complaints' => $all_pendings,
            );

            echo json_encode($Response);
        } else {
            $Response = array(
                'message' => 'No Pending Complaints Found',
                'status' => false,
                'all_pending_complaints' => $all_pendings,
            );

            echo json_encode($Response);
        }

    }

    public function all_complaints_inprogress_list()
    {
        $where = $this->common_model->getAllData('account', '*', array('account_id' => $this->input->post('account_id')));

        $where_inprogress = array(

            'district_tma_slug' => $where[0]->district_tma_slug,
            'status' => 'inprogress'
        );

        $all_inprogress = $this->common_model->getAllData('complaint', '*', $where_inprogress);

        if (!empty($all_inprogress)) {
            $Response = array(
                'message' => 'Total Complaints',
                'status' => true,
                'all_inprogress_complaints' => $all_inprogress,
            );

            echo json_encode($Response);
        } else {
            $Response = array(
                'message' => 'No inprogress complaints found',
                'status' => false,
                'all_inprogress_complaints' => $all_inprogress,
            );

            echo json_encode($Response);
        }


    }

    public function all_complaints_completed_list()
    {
        $where = $this->common_model->getAllData('account', '*', array('account_id' => $this->input->post('account_id')));

        $where_completed = array(

            'district_tma_slug' => $where[0]->district_tma_slug,
            'status' => 'completed'
        );

        $all_completed = $this->common_model->getAllData('complaint', '*', $where_completed);

        if (!empty($all_completed)) {
            $Response = array(
                'message' => 'Total Complaints',
                'status' => true,
                'all_completed_complaints' => $all_completed,
            );

            echo json_encode($Response);
        } else {
            $Response = array(
                'message' => 'No completed complaints found',
                'status' => false,
                'all_completed_complaints' => $all_completed,
            );

            echo json_encode($Response);
        }
    }
    public function over_due_complaints()
    {
        $status = array('pendingreview', 'inprogress');

        $query = $this->db->select("*")
            ->from('complaint')
            ->or_where_in('status', $status)
            ->get()->result();

        $dates = array();

        foreach ($query as $new_query) {
            $expiry_date = $new_query->created_at;
            $expiry_date = new DateTime($expiry_date);
            $today = new DateTime();
            $interval = $today->diff($expiry_date);
            $day = $interval->days;

            if ($day > 7) {
                $arr = array(

                    'c_id' => $new_query->c_id,
                    'district_slug' => $new_query->district_slug,
                    'district_tma_slug' => $new_query->district_tma_slug,
                    'account_id' => $new_query->account_id,
                    'c_number' => $new_query->c_number,
                    'c_details' => $new_query->c_details,
                    'image_path' => $new_query->image_path,
                    'longitude' => $new_query->longitude,
                    'latitude' => $new_query->latitude,
                    'bin_address' => $new_query->bin_address,
                    'c_date' => $new_query->c_date,
                    'c_time' => $new_query->c_time,
                    'c_date_time' => $new_query->c_date_time,
                    'c_type' => $new_query->c_type,
                    'status' => $new_query->status,
                    'token_id' => $new_query->token_id,
                    'created_at' => $new_query->created_at,
                    'updated_at' => $new_query->updated_at,
                );

                array_push($dates, $arr);
            }
        }

        $Response = array(
            'message' => 'All Over Due Complaints',
            'status' => true,
            'over_due_complaints' => $dates,
        );

        echo json_encode($Response);
    }

    public function edit_copmplaint($id)
    {
        if (!empty($id)) {
            $edit_data = $this->common_model->getAllData('complaint', '*', array('c_id' => $id));

            $Response = array(
                'message' => 'complaint data',
                'status' => true,
                'complaint_data' => $edit_data,
            );

            echo json_encode($Response);
        } else {
            $Response = array(
                'message' => '`This complaint is not found in database',
                'status' => false,
                'response_code' => 401,
            );

            echo json_encode($Response);
        }
    }

    public function update_copmplaint()
    {
        $complaint_number = $this->input->post('complaint_number');

        if (!empty($complaint_number)) {
            $check = $this->common_model->getAllData('complaint', '*', array('c_number' => $complaint_number));

            if (empty($check)) {
                $Response = array(
                    'message' => 'Complaint ID not found in our Records',
                    'status' => false,
                    'response_code' => 401,
                );

                echo json_encode($Response);
            } else {
                $data = array(
                    'status' => $this->input->post('status')
                );

                $edit_data = $this->common_model->UpdateDB('complaint', array('c_number' => $complaint_number), $data);

                $new_data = array(
                    'complaint_id' => $this->input->post('complaint_number'),
                    'complaint_response' => $this->input->post('message'),
                    'response_status' => $this->input->post('status'),
                    'admin_id' => $this->input->post('admin_id')

                );

                $this->db->insert('complaint_response', $new_data);

                $Response = array(
                    'message' => 'complaint status updated',
                    'status' => true,
                    'complaint_data' => $edit_data,
                );

                echo json_encode($Response);
            }


        } else {
            $Response = array(
                'message' => 'Complaint ID not Found',
                'status' => false,
                'response_code' => 401,
            );

            echo json_encode($Response);
        }
    }

    public function complaint_types()
    {
        if ($this->input->post()) {

            $config['upload_path'] = './uploads/complaint_types/';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                
                $this->session->set_flashdata('error', "Error! Image Not Uploading");
                redirect('Admin/complaint_types');

            } else {
                $upload_img = array('upload_data' => $this->upload->data());
                $image = $upload_img['upload_data']['file_name'];
            }

            $data['complaint_types'] = $this->input->post('complaint_type');
            $data['expire_date'] = $this->input->post('exiry_date');
            $data['image'] = base_url().'uploads/complaint_types/'.$image;

            $query = $this->db->insert('complaint_types', $data);

            if ($query) {
                $this->session->set_flashdata('success', "Complaint Type Inserted Successfully");
                redirect('Admin/complaint_types');
            } else {
                $this->session->set_flashdata('error', "Error!");
                redirect('Admin/complaint_types');
            }

        } else {
            $this->data['active'] = 'compliant_type';
            $this->data['types'] = $this->common_model->getAllData('complaint_types', '*');

            $this->load->view('template/header');
            $this->load->view('admin/compliant_types', $this->data);
            $this->load->view('template/footer-custom');
        }
    }

    public function delete_complaint_type($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('complaint_types');

        $this->session->set_flashdata('success', "Complaint Type Deleted Successfully");
        redirect('Admin/complaint_types');
    }

    public function update_complaint_type($id = null)
    {
        if ($this->input->post()) {

            if($_FILES["image"]["name"] == '')
            {
                $image = $this->input->post('old_image');
            }
            else
            {
                $config['upload_path'] = './uploads/complaint_types/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());
                    
                    $this->session->set_flashdata('error', "Error! Image Not Uploading");
                    redirect('Admin/complaint_types');

                } else {
                    $upload_img = array('upload_data' => $this->upload->data());
                    $image = $upload_img['upload_data']['file_name'];
                }
            }
            $data['complaint_types'] = $this->input->post('complaint_type');
            $data['expire_date'] = $this->input->post('exiry_date');
            $data['image'] = base_url().'uploads/complaint_types/'.$image;

            $query = $this->common_model->UpdateDB('complaint_types', array('id' => $id), $data);

            if ($query) {
                $this->session->set_flashdata('success', "Complaint Type Updated Successfully");
                redirect('Admin/complaint_types');
            } else {
                $this->session->set_flashdata('error', "Error!");
                redirect('Admin/complaint_types');
            }

        } else {
            $this->data['type'] = $this->common_model->getAllData('complaint_types', '*', array('id' => $id));

            $this->load->view('template/header');
            $this->load->view('admin/update_complaint_type', $this->data);
            $this->load->view('template/footer-custom');
        }
    }
    public function responses($comp_no)
    {
        $this->data['responses'] = $this->common_model->DJoin('*, complaint_response.created_at as response_date,complaint.created_at as complaint_date','complaint_response','complaint','complaint.c_number = complaint_response.complaint_id','',array('complaint_id' => $comp_no));

        $this->load->view('template/header');
        $this->load->view('admin/responses', $this->data);
        $this->load->view('template/footer-custom');
    }

    public function add_complaint()
    {
        $increament = 1;
        $config['upload_path'] = './uploads/map/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image_path')) {
            $error = array('error' => $this->upload->display_errors());

            echo json_encode($error);
            die;
        } else {
            $image_name = array('upload_data' => $this->upload->data());

            $data['image_path'] = $image_name['upload_data']['file_name'];
        }

        $data['c_number'] = $this->input->post('c_number');
        $data['account_id'] = $this->input->post('account_id');

        $data['c_details'] = $this->input->post('c_details');

					// $decoded_string = base64_decode($this->input->post());
					// $image_path = './uploads/map/' . $data['c_number'] . '.jpeg';
					// $data['image_path'] = $image_path;
					// file_put_contents($image_path, $decoded_string);

        $data['longitude'] = $this->input->post('longitude');
        $data['latitude'] = $this->input->post('latitude');
        $data['bin_address'] = $this->input->post('bin_address');
        $data['status'] = $this->input->post('status');
        $data['c_date'] = date("Y-m-d");
        $data['c_date_time'] = date("Y-m-d h:i:sa"); //$this->input->post('c_date_time');
        $data['c_time'] = date("h:i:sa");
        $data['c_type'] = $this->input->post('c_type');
        $data['district_slug'] = $this->input->post('district_slug');
        $data['district_tma_slug'] = $this->input->post('district_tma_slug');
        $data['created_at'] = date('Y-m-d');

        $query = $this->db->insert('complaint', $data);

        $data = array(
            'status' => 'Successfully Registered!',
        );
        if ($query) {
            echo json_encode($data);
        } else {
            echo json_encode("Complaint Faild");
        }
    }

    public function complaint_details($comp_no)
    {
        $this->data['complaint_details'] = $this->common_model->getAllData('complaint', '*', array('c_number' => $comp_no));

        $this->load->view('template/header');
        $this->load->view('admin/complaint_details', $this->data);
        $this->load->view('template/footer-custom');
    }

    public function get_btw_complaints()
    {
        $from = $this->input->post('from');
        $to = $this->input->post('to');

        $where = array(
            'created_at >=' => $from,
            'created_at <=' => $to,
        );

        $this->data['multiListingData'] = $this->common_model->getAllData("complaint", '*', $where);

        $this->load->view('template/header');
        $this->load->view('user/get_btw_complaints', $this->data);
        $this->load->view('template/footer-custom');

    }

    public function complaint_reports()
    {
        $this->data['districts'] = $this->common_model->getAllData('complaint','*, COUNT(c_id) AS total_districts','','','','district_slug');

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('admin/complaint_reports',$this->data);
        $this->load->view('template/footer-custom');
    }

    public function district_tma($tma)
    {
        $this->data['district_tmas'] = $this->common_model->getAllData('complaint','*, COUNT(c_id) AS total_districts',array('district_slug' => $tma),'','','district_tma_slug');

        // echo "<pre>";
        // print_r($this->data['district_tmas']);
        // die;

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('admin/tmas_districts',$this->data);
        $this->load->view('template/footer-custom');
    }

    public function district_tma_complaints($tma)
    {
        $this->data['multiListingData'] = $this->common_model->getAllData('complaint','*',array('district_tma_slug' => $tma));

        // echo "<pre>";
        // print_r($this->data['district_tma_complaints']);
        // die;

        $this->load->view('template/header');
        $this->load->view('template/menu');
        $this->load->view('admin/district_tma_complaints',$this->data);
        $this->load->view('template/footer-custom');
    }
}

/* End of file Controllername.php */
/* End of file filename.php */
