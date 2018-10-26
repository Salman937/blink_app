<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('common_model');
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
}

/* End of file Controllername.php */
/* End of file filename.php */
