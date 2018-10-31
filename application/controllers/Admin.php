<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('common_model');

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
            'message'               => 'Total Complaints',
            'status'                => true,
            'all_complaints'        => $all_comp,
            'completed_complaints'  => $completed,
            'pending_complaints'    => $pending,
            'inprogress_complaints' => $inprogress,
            'over_due_complaints'   => $total_over_due,
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
        if (!empty($id)) 
        {
            $edit_data = $this->common_model->getAllData('complaint', '*',array('c_id' => $id));

            $Response = array(
                                'message' => 'complaint data',
                                'status' => true,
                                'complaint_data' => $edit_data,
                            );

            echo json_encode($Response);
        } 
        else {
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

        if (!empty($complaint_number)) 
        {
            $check = $this->common_model->getAllData('complaint','*',array('c_number' => $complaint_number));

            if (empty($check)) 
            {
                $Response = array(
                                    'message'        => 'Complaint ID not found in our Records',
                                    'status'         => false,
                                    'response_code'  => 401,
                                );

                echo json_encode($Response);
            } 
            else 
            {
                $data = array(
                                'status' => $this->input->post('status')
                             );
    
                $edit_data = $this->common_model->UpdateDB('complaint',array('c_number' => $complaint_number),$data);

                $new_data = array(
                                'complaint_id'       => $this->input->post('complaint_number'),
                                'complaint_response' => $this->input->post('message'),
                                'response_status'    => $this->input->post('status'),
                                'admin_id'           => $this->input->post('admin_id')

                );

                $this->db->insert('complaint_response',$new_data);
    
                $Response = array(
                                    'message'        => 'complaint status updated',
                                    'status'         => true,
                                    'complaint_data' => $edit_data,
                                 );
    
                echo json_encode($Response);
            }
            

        } 
        else {
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
        if($this->input->post())
        {
            $data['complaint_types'] = $this->input->post('complaint_type');
            $data['expire_date'] = date('Y-m-d', strtotime($this->input->post('exiry_date')));
            
            $query = $this->db->insert('complaint_types', $data);
            
            if ($query) 
            {
                $this->session->set_flashdata('success', "Complaint Type Inserted Successfully"); 
                redirect('Admin/complaint_types');
            } 
            else 
            {
                $this->session->set_flashdata('error', "Error!"); 
                redirect('Admin/complaint_types');
            }
            
        }
        else
        {
            $this->data['active'] = 'compliant_type';
            $this->data['types'] = $this->common_model->getAllData('complaint_types','*');

            $this->load->view('template/header');
			$this->load->view('admin/compliant_types',$this->data);
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

    public function update_complaint_type($id=Null)
    {
        if($this->input->post())
        {
            $data['complaint_types'] = $this->input->post('complaint_type');
            $data['expire_date'] = date('Y-m-d', strtotime($this->input->post('exiry_date')));
            
            $query = $this->common_model->UpdateDB('complaint_types',array('id' => $id),$data);
            
            if ($query) 
            {
                $this->session->set_flashdata('success', "Complaint Type Updated Successfully"); 
                redirect('Admin/complaint_types');
            } 
            else 
            {
                $this->session->set_flashdata('error', "Error!"); 
                redirect('Admin/complaint_types');
            }
            
        }
        else
        {
            $this->data['type'] = $this->common_model->getAllData('complaint_types','*',array('id' => $id));

            $this->load->view('template/header');
			$this->load->view('admin/update_complaint_type',$this->data);
			$this->load->view('template/footer-custom');
        }
    }
    public function responses($comp_no)
    {
        $this->data['responses'] = $this->common_model->getAllData('complaint_response','*',array('complaint_id' => $comp_no));

        $this->load->view('template/header');
        $this->load->view('admin/responses',$this->data);
        $this->load->view('template/footer-custom');
    }
}

/* End of file Controllername.php */
/* End of file filename.php */
