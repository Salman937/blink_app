<?php $this->load->view('template/menu') ?>

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Complaint Responses  </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#"> Complaint Reponses</a></li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12"> 
        
        <!-- /.box -->
        
        <div class="box"> 
          
          <!-- /.box-header -->
          <div class="box-body">
            <br> <br>
            <br> <br>
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <a class="btn btn-default" href="javascript:window.print()" >
                    <i class="fa fa-print" aria-hidden="true"></i> Print
                    </a>
                    <br>
                    <br>
                    <ul class="list-group">
                        <li class="list-group-item"><b>District: <span class="pull-right"><?= $complaint_details[0]->district_slug ?></span></b></li>
                        <li class="list-group-item"><b>District TMA: <span class="pull-right"><?= $complaint_details[0]->district_tma_slug ?></span></b></li>
                        <li class="list-group-item"><b>Complaint Number: <span class="pull-right"><?= $complaint_details[0]->c_number ?></span></b></li>
                        <li class="list-group-item"><b>Complaint Details: <span class="pull-right"><?= $complaint_details[0]->c_details ?></span></b></li>
                        <li class="list-group-item"><b>Complaint Date: <span class="pull-right"><?= $complaint_details[0]->c_date ?></span></b></li>
                        <li class="list-group-item"><b>Complaint Type: <span class="pull-right"><?= $complaint_details[0]->c_type ?></span></b></li>
                        <li class="list-group-item"><b>Status: <span class="pull-right"><?= $complaint_details[0]->status ?></span></b></li>
                        <li class="list-group-item" style="height:100px"><b>Image: <span class="pull-right">
                            <img src="<?= base_url().$complaint_details[0]->image_path?>" width="100" alt=""></span>
                        </b></li>
                    </ul>
                </div>
            </div>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>

