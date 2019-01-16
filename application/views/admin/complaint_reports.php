
<div class="content-wrapper">
  <section class="content-header">
    <h1> All Districts  Complaints</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">All Districts complaints</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
    
    <?php foreach($districts as $district): ?>

    <a href="<?= base_url() ?>Admin/district_tma/<?= $district->district_slug ?>">  
      <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="info-box" style="min-height: 70px;"> 
          <div class="info-box-content" style="margin-left: 50px;"> 
            <span class="info-box-text"><b><?= $district->district_slug ?></b></span> 
              <span class="">
              Total Complaints: <?= $district->total_districts ?>
              </span>
          </div>
        </div>
      </div>
    </a>
      <?php endforeach; ?>                      
    </div>  
  </section>
</div>
<?php //$this->load->view('template/footer'); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');

</script>