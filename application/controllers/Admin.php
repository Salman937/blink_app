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
        $all_comp = $this->db->count_all_results('complaint');

        $completed = $this->db->where('status', 'completed')
                              ->count_all_results('complaint');

        $pending   = $this->db->where('status', 'pendingreview')
                          ->count_all_results('complaint');

        $inprogress = $this->db->where("status","inprogress")
                           ->count_all_results('complaint');

        // $completed = $this->db->where('status', 'completed')
                        //   ->count_all_results('complaint');


        $Response = array(
            'message'       => 'Total Complaints',
            'status'        => true,
            'all_complaints'        => $all_comp,
            'completed_complaints'  => $completed,
            'pending_complaints'    => $pending,
            'inprogress_complaints'     => $inprogress,
        );

        echo json_encode($Response);
    }

    public function all_complaints_list()
    {
        $where = $this->common_model->getAllData('account','*',array('account_id' => $this->input->post('account_id')));
        
        $all_comps = $this->common_model->getAllData('complaint','*',array('district_tma_slug' => $where[0]->district_tma_slug));

        if (!empty($all_comps)) 
        {
            $Response = array(
                                'message'           => 'Total Complaints',
                                'status'            => true,
                                'all_complaints'    => $all_comps,
                            );
            
            echo json_encode($Response);
        } 
        else 
        {
            $Response = array(
                                'message'    => 'No Complaints found',
                                'status'     => false,
                                'all_complaints'    => $all_comps,
                            );
            
            echo json_encode($Response);
        }
    }

    public function all_complaints_pending_list()
    {
        $where = $this->common_model->getAllData('account','*',array('account_id' => $this->input->post('account_id')));
        
        $where_pending = array(

                                'district_tma_slug' => $where[0]->district_tma_slug,
                                'status' => 'pendingreview'
                             );

        $all_pendings = $this->common_model->getAllData('complaint','*',$where_pending);

        if (!empty($all_pendings)) 
        {
            $Response = array(
                'message'           => 'Total Complaints',
                'status'            => true,
                'all_pending_complaints'    => $all_pendings,
            );

            echo json_encode($Response);
        } 
        else 
        {
            $Response = array(
                                'message'           => 'No Pending Complaints Found',
                                'status'            => false,
                                'all_pending_complaints'    => $all_pendings,
                            );
            
            echo json_encode($Response);
        }
        
    }

    public function all_complaints_inprogress_list()
    {
        $where = $this->common_model->getAllData('account','*',array('account_id' => $this->input->post('account_id')));
        
        $where_inprogress = array(

                                'district_tma_slug' => $where[0]->district_tma_slug,
                                'status' => 'inprogress'
                             );

        $all_inprogress = $this->common_model->getAllData('complaint','*',$where_inprogress);

        if (!empty($all_inprogress)) 
        {
            $Response = array(
                                'message'           => 'Total Complaints',
                                'status'            => true,
                                'all_inprogress_complaints'    => $all_inprogress,
                            );
            
            echo json_encode($Response);
        } 
        else 
        {
            $Response = array(
                'message'           => 'No inprogress complaints found',
                'status'            => false,
                'all_inprogress_complaints'    => $all_inprogress,
            );

            echo json_encode($Response);
        }
        

    }

    public function all_complaints_completed_list()
    {
        $where = $this->common_model->getAllData('account','*',array('account_id' => $this->input->post('account_id')));
        
        $where_completed = array(

                                'district_tma_slug' => $where[0]->district_tma_slug,
                                'status' => 'completed'
                             );

        $all_completed = $this->common_model->getAllData('complaint','*',$where_completed);

        if (!empty($all_completed)) 
        {
            $Response = array(
                                'message'           => 'Total Complaints',
                                'status'            => true,
                                'all_completed_complaints'    => $all_completed,
                            );
            
            echo json_encode($Response);
        } 
        else 
        {
            $Response = array(
                'message'           => 'No completed complaints found',
                'status'            => false,
                'all_completed_complaints'    => $all_completed,
            );

            echo json_encode($Response);
        }
    }

}

/* End of file Controllername.php */
/* End of file filename.php */
