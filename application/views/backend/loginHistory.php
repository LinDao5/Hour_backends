<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" />
<style>
    th, td{
        text-align: center;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> 登录历史
        <small>跟踪登录历史</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
          <form action="<?php echo base_url() ?>login-history" method="POST" id="searchList">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
              <div class="input-group">
                <input id="fromDate" type="text" name="fromDate" value="<?php echo $fromDate; ?>" class="form-control datepicker" placeholder="从日期" autocomplete="off" />
                <span class="input-group-addon"><label for="fromDate"><i class="fa fa-calendar"></i></label></span>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group">
              <div class="input-group">
                <input id="toDate" type="text" name="toDate" value="<?php echo $toDate; ?>" class="form-control datepicker" placeholder="至今" autocomplete="off" />
                <span class="input-group-addon"><label for="toDate"><i class="fa fa-calendar"></i></label></span>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 form-group">
              <input id="searchText" type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control" placeholder="探索"/>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-6 form-group">
              <button type="submit" class="btn btn-md btn-primary btn-block searchList pull-right"><i class="fa fa-search" aria-hidden="true"></i></button> 
            </div>
            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-6 form-group">
              <button class="btn btn-md btn-default btn-block pull-right resetFilters"><i class="fa fa-refresh" aria-hidden="true"></i></button>
            </div>
          </form>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= !empty($userInfo) ? $userInfo->name." : ".$userInfo->email : "所有 用户" ?></h3>
                    <div class="box-tools">
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>会议数据</th>
                      <th>IP 地址</th>
                      <th>用户 代理人</th>
                      <th>代理全字符串</th>
                      <th>平台</th>
                      <th>日期-时间</th>
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->sessionData ?></td>
                      <td><?php echo $record->machineIp ?></td>
                      <td><?php echo $record->userAgent ?></td>
                      <td><?php echo $record->agentString ?></td>
                      <td><?php echo $record->platform ?></td>
                      <td><?php echo $record->createdDtm ?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;
            jQuery("#searchList").attr("action", link);
            jQuery("#searchList").submit();
        });

        jQuery('.datepicker').datepicker({
          autoclose: true,
          format : "dd-mm-yyyy",
          language: 'zh-CN'
        });
        jQuery('.resetFilters').click(function(){
          $(this).closest('form').find("input[type=text]").val("");
        })
    });
</script>
