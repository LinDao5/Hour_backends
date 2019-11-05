<?php
    $allCounts = $allCount;
?>
<style>
    td{
        text-align: center;
        vertical-align: middle;
    }
    body {
        color: #232323;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100% /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 500px;
        height: auto;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    /* The Close Button */
    .close {
        color: #191919;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: rgba(0, 0, 0, 1.0);
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        padding: 2px 16px;
        background-color: rgba(165, 65, 234, 0.71);
        color: #040404;
    }

    .modal-body {padding: 2px 16px;}

    .modal-footer {
        padding: 2px 16px;
        color: black;
    }
/* ---------------------------------- */
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-boo"></i>
          信息管理
        <small>意见反馈</small>
      </h1>
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group" >
                    <button class="btn btn-primary" id="contact-icon">发送信息</button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">信息列表</h3>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered">
                    <tr style="text-align: center; vertical-align: middle">
                        <th style="text-align: center; vertical-align: middle">编号</th>
                        <th style="text-align: center; vertical-align: middle">标题</th>
                        <th style="text-align: center; vertical-align: middle">信息内容</th>
                        <th style="text-align: center; vertical-align: middle" >发布时间</th>
                        <th style="text-align: center; vertical-align: middle">查看人数</th>
                        <th style="text-align: center; vertical-align: middle" >操作</th>
                    </tr>
                      <?php
                      if (!empty($informations)){
                          foreach ($informations as $information){
                              ?>
                              <tr>
                                  <td><?php echo $information->infoId?></td>
                                  <td><?php echo $information->title?> </td>
                                  <td><?php echo $information->content?>  </td>
                                  <td><?php echo $information->releaseTime?></td>
                                  <td > <?php echo $information->count . "/" . $allCounts;?> </td>
                                  <td class="text-center">
                                      <a class="btn btn-sm btn-danger deleteInformation" href="#" data-id="<?php echo $information->id; ?>" title=" 删除"><i class="fa fa-trash"></i></a>
                                  </td>
                              </tr>
                      <?php
                          }
                      }
                      ?>

                  </table>
                  
                </div>
              <form hidden action = "" id = "countings">
              </form>
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div>
            </div>
        </div>
    </section>

    <!-- information dialog-->
    <!--Contact Form-->
    <form class="" id="contact-form" action="<?php echo base_url() ?>send_information" method="post" role="form">
            <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close" style="margin-top: 15px">&times;</span>
                        <div style="flex: auto;">
                            <h3><b>发送信息</b></h3>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div style="width: 600px">


                                <div style="display: flex; margin-top: 20px; margin-left: 35px">
                                    <div style="margin-right: 25px; ">
                                        <label >标题 ： </label>
                                    </div>
                                    <div>
                                        <input type="text" id="dlgTitle" name="dlgTitle" style="width: 300px"/>
                                    </div>
                                </div>
                                <div style="display: flex;  margin-top: 20px; margin-left: 35px">
                                    <div style="margin-right: 30px ;">
                                        <label> 内容 : </label>
                                    </div>
                                    <div>
                                      <textarea id="dlgContent" name="dlgContent" style="width: 300px;height: 200px;">
                                      </textarea>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="height: 50px">
                        <div style="margin-top: 10px">
                            <input type="button" id = "close" name="close" value="取消" >
                            <input type="submit" id="send" name="send" value="发送" />
                        </div>
                    </div>

                </div>
            </div>
    </form>

</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/information.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<script type="text/javascript">

    // for pagination
    jQuery(document).ready(function(){

        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#countings").attr("action", baseURL + "information/" + value);
            jQuery("#countings").submit();

        });
    });


    // for dialog
    $(document).ready(function () {

        $("#contact-icon").click(function () {

            $("#myModal").css("display", "block");
        })

        $("#close").click(function () {

            $("#myModal").css("display", "none");
        })

        $(".close").click(function () {
            $("#myModal").css("display", "none");
        });

        $("#send").click( function () {
            $("#myModal").css("display", "none");

        });

        //Contact Form validation on click event
        // $("#contact-form").on("submit", function () {
        //     var valid = true;
        //     var dlgTitle = $("#dlgTitle").val();
        //     var dlgContent = $("#dlgContent").val();
        //
        //     return valid;
        // });
    });

</script>
