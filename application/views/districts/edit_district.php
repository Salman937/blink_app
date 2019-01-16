<?php //$this->load->view('template/header')?>
<?php $this->load->view('template/menu')?>

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Districts  </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#"> District</a></li>
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
            <span class="btn bg-purple btn-flat margin pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New District</span>
            <br> <br>
            <br> <br>
            <form method="post" action="<?= base_url() ?>Districts/districts" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="complaint_type">District Name</label>
                    <input type="text" class="form-control" name="district_name" id="complaint_type" placeholder="Enter District Name" required>
                </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
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


