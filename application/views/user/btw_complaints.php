<?php //$this->load->view('template/header')?>
<?php $this->load->view('template/menu')?>

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Between Two Date Complaints  </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#"> Between Complaint</a></li>
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
            <div class="row" style="margin-top:2em">
                <div class="col-sm-6 col-sm-offset-3">
                    <form action="<?= base_url() ?>Admin/get_btw_complaints" method="post">
                        <div class="form-group">
                            <label>From</label>
                            <input type="date" class="form-control" name="from">
                        </div>
                        <div class="form-group">
                            <label>To</label>
                            <input type="date" class="form-control" name="to">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-defaul">Submit</button>
                        </div>  
                    </form>
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