<?php //$this->load->view('template/header')?>
<?php $this->load->view('template/menu')?>

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Users </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Add Users</a></li>
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
            <span class="btn bg-purple btn-flat pull-right" id="show">Add New User</span>
            <h2>List of All district Users</h2>
<!-- form start -->
                <form class="form-horizontal" action="<?php echo base_url()?>user/add" method="post" id="form" enctype="multipart/form-data" style="display:none">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="username" class="col-sm-3 control-label">Username</label>
                      
                      <div class="col-sm-6">
                          <input type="text" class="form-control" name="username" id="username" maxlength="30" placeholder="Enter Username" required>
                          <?php echo '<span class="error">'. form_error('username').'</span>'; ?>
                      </div>
                      <div class="col-sm-2">
                          <i class="fa fa-times pull-right" id="hide" aria-hidden="true" style="cursor:pointer"></i>
                      </div>
                    </div>              
                    
                    <div class="form-group">
                      <label for="cnic" class="col-sm-3 control-label">Email</label>
                      
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="Enter Email" required>
                        <?php echo '<span class="error">'. form_error('email').'</span>'; ?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="mobile_no" class="col-sm-3 control-label">Mobile No</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="mobile_no" id="email" maxlength="50" placeholder="Enter Mobile No" required>
                        <?php echo '<span class="error">'. form_error('email').'</span>'; ?>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="name" class="col-sm-3 control-label">Password</label>
                      <div class="col-sm-6">
                        <input type="password" class="form-control" name="password" id="pass" placeholder="Enter Password" required>
                        <?php echo '<span class="error">'. form_error('password').'</span>'; ?>
                      </div>
                    </div>  
                     
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Select User District</label>
                      <div class="col-sm-6">
                          <select name="district_id" id="district_id" class="form-control" onchange="getSector(this)" required>
                            <option value="">Select District</option>

                            <?php foreach ($districts as $district): ?>
                              <option value="<?php echo $district->id ?>"><?php echo $district->districts_categories ?></option>
                            <?php endforeach ?> 
                          </select>
                          <?php echo '<span class="error">'. form_error('district').'</span>'; ?>
                      </div>
                    </div>
                    <div class="tma">
                    </div>
                             
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <div class="col-sm-offset-6 col-sm-3">
                       <a href="<?php echo base_url().'admin/get_license_list'; ?>" class="btn btn-default">Cancel</a>
                        <span type="reset" class="btn btn-default">Reset</span>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                  </div>
                  <!-- /.box-footer -->
                </form>

            <div class="row">
                <div class="col-sm-12">

                    <!-- session message -->
            <?php if($this->session->flashdata('msg')):?>
            <div class="callout callout-success" id="msg">
                <p align="center" style="position:relative; font-size:16px;">
                    <?=$this->session->flashdata('msg')?>
                </p>
            </div>
            <?php endif;?>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>TMA Districts</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($users)): ?>

                            <tr>
                                <td> <font color="red">Users Not Available</font> </td>
                            </tr>
                        <?php else: ?>  

                        <?php foreach($users as $user): ?>

                            <tr>
                                <td><?php echo $user->fullname ?></td>
                                <td><?php echo $user->emailad ?></td>
                                <td><?php echo $user->mobilenumber ?></td>
                                <td><?php echo $user->district_tma ?></td>
                            </tr>

                        <?php endforeach; ?>    

                        <?php endif; ?>    
                        </tbody>
                    </table>
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
<style>
.error{
color:#FF0000;
}
</style>

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/js/w2ui-1.4.2.min.css">
<script src="<?php echo base_url();?>assets/plugins/js/w2ui-1.4.2.min.js"></script>
<script>
$(document).ready(function() {

  $(".popup_image").on('click', function() {
    w2popup.open({
      title: 'Image',
      body: '<div class="w2ui-centered"><img src="' + $(this).attr('src') + '"></img></div>'
    });
  });

});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');

</script>