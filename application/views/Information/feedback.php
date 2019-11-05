<style>
    td{
        text-align: center;
        vertical-align: middle;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-boo"></i>
          信息管理
        <small>意见反馈</small>
      </h1>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">意见反馈列表</h3>

                               </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered">
                    <tr style="text-align: center; vertical-align: middle">
                        <th style="text-align: center; vertical-align: middle">编号</th>
                        <th style="text-align: center; vertical-align: middle">意见反馈内容</th>
                        <th style="text-align: center; vertical-align: middle">提交时间</th>
                        <th style="text-align: center; vertical-align: middle" >操作</th>
                    </tr>
                      <?php
                      if (!empty($feedbacks)){
                          foreach ($feedbacks as $feedback){
                              ?>
                              <tr>
                                  <td><?php echo $feedback->id?></td>
                                  <td>
                                      <textarea onfocus="false" onclick="false" contenteditable="false" rows="2" class="no-border" style="width: 100%;height: 100%; margin-bottom: 0px; padding: 0px" name="feedback" id="feedback"><?php echo $feedback->feedback;?></textarea>
                                  </td>
                                  <td><?php echo $feedback->date?></td>
                                  <td class="text-center">
                                      <a class="btn btn-sm btn-danger deletefeedback" href="#" data-id="<?php echo $feedback->id; ?>" title=" 删除"><i class="fa fa-trash"></i></a>
                                  </td>
                              </tr>
                      <?php
                          }
                      }
                      ?>

                  </table>
                  
                </div>
                  <form hidden action = "" id = "searchList">
                  </form>
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/feedback.js" charset="utf-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "feedbacking/" + value);
            jQuery("#searchList").submit();

        });
        // jQuery('ul.pagination li a').click(function (e) {
        //     e.preventDefault();
        //     var link = jQuery(this).get(0).href;
        //     jQuery("#searchList").attr("action", link);
        //     jQuery("#searchList").submit();
        // });
    });
</script>
