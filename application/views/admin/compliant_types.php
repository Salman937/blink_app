<?php //$this->load->view('template/header')?>
<?php $this->load->view('template/menu')?>

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> List All Compliant Types  </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#"> Complaint Types</a></li>
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
            <span class="btn bg-purple btn-flat margin pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Complaint Type</span>
            <br> <br>
            <br> <br>
            <?php 
                if($this->session->flashdata('success')):
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php 
               endif;
            ?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Complaint Types</th>
                  <th>Image</th>
                  <th>Expiry Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php if(isset($types)) foreach($types as $types){?>
                <tr>
                  <td><?=$types->id?></td>
                  <td><?=$types->complaint_types?></td>
                  <td> <img src="<?=$types->image?>" width="50"></td>
                  <td><?= $types->expire_date ?></td>
                  <td>
                  <a href="<?= base_url() ?>Admin/update_complaint_type/<?= $types->id ?>">
                    <span class="btn bg-olive btn-xs update btn-flat margin" data-toggle="modal" data-target="#updatemodel"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                  </a>
                  <a href="<?= base_url() ?>Admin/delete_complaint_type/<?= $types->id ?>">
                    <span class="btn bg-navy btn-xs  btn-flat margin"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
                  </a>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Complaint Type</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url() ?>Admin/complaint_types" enctype="multipart/form-data">
          <div class="form-group">
            <label for="complaint_type">Complaint Type</label>
            <input type="text" class="form-control" name="complaint_type" id="complaint_type" placeholder="Enter Complaint Type" required>
          </div>
          <div class="form-group">
            <label for="complaint_type">Image</label>
            <input type="file" class="form-control" name="image" required>
          </div>
          <div class="form-group">
            <label for="expiry_date">Select Expiry Duration</label>
            <select name="exiry_date" class="form-control" required>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
              <option>6</option>
              <option>7</option>
              <option>8</option>
              <option>9</option>
              <option>10</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
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
