<?php //$this->load->view('template/header')?>
<?php $this->load->view('template/menu')?>

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
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Complaint Number</th>
                  <th>Complaint Response</th>
                  <th>Response Status</th>
                  <th>Resovle Days</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
              <?php if(isset($responses)) foreach($responses as $response){?>
                <tr>
                  <td><?=$response->id?></td>
                  <td><?=$response->complaint_id?></td>
                  <td><?= $response->complaint_response ?></td>
                  <td>
                      <?php

                          $complaint_date = $response->complaint_date;
                          $response_date  = $response->response_date;
                          
                          $diff = abs(strtotime($response_date) - strtotime($complaint_date));
                          
                          $years = floor($diff / (365*60*60*24));
                          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                          
                          printf("%d years, %d months, %d days\n", $years, $months, $days);

                        // die;
                      ?>
                  </td>
                  <td><span class="btn bg-olive btn-sm btn-flat margin"><?= $response->response_status ?></span></td>
                  <!-- <td>
                  <a href="<?= base_url() ?>Admin/update_complaint_type/<?= $response->id ?>">
                    <span class="btn bg-olive btn-xs update btn-flat margin" data-toggle="modal" data-target="#updatemodel"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                  </a>
                  <a href="<?= base_url() ?>Admin/delete_complaint_type/<?= $response->id ?>">
                    <span class="btn bg-navy btn-xs  btn-flat margin"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</span>
                  </a>
                  </td> -->
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
