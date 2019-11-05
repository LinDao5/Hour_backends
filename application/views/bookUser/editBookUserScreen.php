<?php
$userId = $userInfo->userId;
$userSerial = $userInfo->userSerial;
$nickName = $userInfo->nickName;
$mobile = $userInfo->mobile;
$name = $userInfo->name;
$studId = $userInfo->studId;
$school = $userInfo->school;
$class = $userInfo->class;
$identyStatus = $userInfo->identyStatus;
$faceStatus = $userInfo->faceStatus;
$isReadCount = $count['isReadCount'];
$downloadedCount = $count['downloadedCount'];
$attentionCount = $count['attentionCount'];
$favouriteCount = $count['favouriteCount'];
$allTime = $count['allTime'];
$faceImageUrl = $userInfo->faceImageUrl;
$idCardFront = $userInfo->idCardFront;
$idCardBack = $userInfo->idCardBack;
var_dump($idCardBack);

?>

<style>
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .btn {
        height: 30px;
        border: 2px solid #7c1885;
        background-color: #7c1885;
        border-radius: 8px;
        font-size: 12px;
        color: #fffbe3;
        font-weight: bold;
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    th {
        background-color: #f8f9fb;
    }
    .hidden1{
        opacity: 0;
        width: 50px;
        height: 50px;
        position: absolute;
        cursor: pointer;
        top: 150px;
        left: 130px;
    }
    .hidden2{
        opacity: 0;
        width: 50px;
        height: 50px;
        position: absolute;
        cursor: pointer;
        top: 150px;
        right: 130px;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-user"></i> 用户管理
            <small> 编辑用户</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">个人信息</h3>
                    </div><!-- /.box-header -->

                    <!-- file upload part -->
                    <?php echo form_open_multipart('Backend/bookuser/updateBookUser');?>
                    <form role="form" action="<?php echo base_url() ?>editBookUserScreen" method="post" id="updateBookUser" name="updateBookUser" role="form">
                    <div class="box-body " >
                        <div class="text-right" style="margin-right: 20px">
                            <button type="submit" class="btn btn-success"  style="background-color: #7d1886;" onclick="capture();">保存修改</button>
                        </div>
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 8%; ">编号</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="userSerial" id="userSerial" value="<?php echo $userSerial;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">手机号</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="mobile" id="mobile" value="<?php echo $mobile ;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">人脸认证状态</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                    <input class="no-border form-control required" type="text" name="faceStatus" id="faceStatus"-->
<!--                                           value="--><?php //if ($faceStatus == 0)
//                                               echo "未认证";
//                                           elseif ($faceStatus == 1)
//                                           echo "已认证" ;?><!--">-->
                                    <select name="faceStatus" id="faceStatus"  class="form-control " style="width: 100%;"  >
                                        <option <?php if ($faceStatus == 0) echo 'selected';?> value= 0>未认证</option>
                                        <option <?php if ($faceStatus == 1) echo 'selected';?>  value= 1>已认证</option>
                                    </select>
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">关注书目</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="attentionCount" id="attentionCount" value="<?php echo $attentionCount;?>">
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 8%">昵称</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="nickName" id="nickName" value="<?php echo $nickName;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">学校</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="school" id="school" value="<?php echo $school;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">已读本数</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="isReadCount" id="isReadCount" value="<?php echo $isReadCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">阅历</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="allTime" id="allTime" value="<?php echo $allTime ;?>小时">
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 8%">真实姓名</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="name" id="name" value="<?php echo $name;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">班级</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="class" id="class" value="<?php echo $class;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">已下载</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="downloadedCount" id="downloadedCount" value="<?php echo $downloadedCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%"></th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="publishDate" id="publishDate" value="<?php echo "";?>">
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 8%">学号</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="studId" id="studId" value="<?php echo $studId;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">身份认证状态</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                    <input class="no-border form-control required" type="text" name="identyStatus" id="identyStatus"-->
<!--                                           value="--><?php //if ($identyStatus == 0)
//                                               echo "未认证";
//                                               elseif ($identyStatus == 1)
//                                                   echo "已认证";?><!--">-->
                                    <select name="identyStatus" id="identyStatus"  class="form-control " style="width: 100%;" placeholder="编号/书名/作者等" >
                                        <option <?php if ($identyStatus == 0) echo 'selected';?> value= 0>未认证</option>
                                        <option <?php if ($identyStatus == 1) echo 'selected';?>  value= 1>已认证</option>
                                    </select>
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">收藏书目</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="downloadedCount" id="downloadedCount" value="<?php echo $favouriteCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%"></th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="pageNumber" id="pageNumber" value="<?php echo "";?>">
                                </td>
                                <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                            </tr>
                        </table>

                    </div>

                    </form>

                    <!-- identify & face image upload part-->
                    <div class = "row" >
                        <div class = "col-lg-4" style="text-align: center">
                            <?php echo form_open_multipart('upload-identify_front/post');?>
                               <div>
                                   <img src="<?php echo base_url().$idCardFront;?>" onerror="this.src='<?php echo base_url()."assets/images/404.png";?>';" id="imgg" alt="Smiley face" height="150" width="350">
                                   <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                   <input type="hidden" value="<?php echo $mobile; ?>" name="mobile" id="mobile" />

                               </div>
                                <div class="form-group "  style="text-align: center;margin-top: 20px; ">
                                    <div class="upload-btn-wrapper" >
                                        <button class="btn " style="margin-right: 20px" >修改</button>
                                        <input type="file"  id="front" name="front" />
                                    </div>

<!--                                <div class="upload-btn-wrapper"  style="text-align: left; margin-left: 100px;">-->
<!--                                    <h6 style="border:1px"><b>修改</b></h6>-->
<!--                                    <input type="file" class="hidden1" id="front" name="front" />-->
<!--                                </div>-->
                                    <div class="upload-btn-wrapper">
                                        <button  class="btn" style="margin-left: 20px; ">认证</button>
<!--                                        <input type="submit"  value="upload" />-->
                                    </div>
<!--                                <div style="text-align: right; margin-right: 100px">-->
<!--                                    <h6 style="border:1px"><b>认证</b></h6>-->
<!--                                    <input type="submit" class="hidden2" value="upload" />-->
<!--                                </div>-->
                                </div>
                            </form>

                        </div>

                        <div class = "col-lg-4" style="text-align: center">
                            <?php echo form_open_multipart('upload-identify_back/post');?>
                            <img src="<?php echo base_url().$idCardBack;?>" onerror="this.src='<?php echo base_url()."assets/images/404.png";?>';"  alt="Smiley face" height="150" width="350">
                            <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                            <input type="hidden" value="<?php echo $mobile; ?>" name="mobile" id="mobile" />
                            <div class="form-group"  style="margin-top: 20px;">
<!--                                <div style="text-align: left; margin-left: 100px">-->
<!--                                    <h6><b>修改</b></h6>-->
<!--                                    <input type="file" class="hidden1"  name="back"/>-->
<!--                                </div>-->
<!--                                <div style="text-align: right; margin-right: 100px">-->
<!--                                    <h6><b>认证</b></h6>-->
<!--                                    <input type="submit"   class="btn-image-upload hidden2" value="upload" />-->
<!--                                </div>-->
                                    <div class="upload-btn-wrapper" >
                                        <button class="btn " style="margin-right: 20px" >修改</button>
                                        <input type="file"  id="front" name="back" />
                                    </div>
                                    <div class="upload-btn-wrapper">
                                        <button  class="btn" style="margin-left: 20px; ">认证</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class = "col-lg-4" style="text-align: center">
                            <?php echo form_open_multipart('upload-identify_face/post');?>
                            <img src="<?php echo base_url().$faceImageUrl;?>" onerror="this.src='<?php echo base_url()."assets/images/404.png";?>';" alt="Smiley face" height="150" width="350">
                            <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                            <input type="hidden" value="<?php echo $mobile; ?>" name="mobile" id="mobile" />
                            <div class="form-group"  style="margin-top: 20px;">
<!--                                <div style="text-align: left; margin-left: 100px">-->
<!--                                    <h6><b>修改</b></h6>-->
<!--                                    <input type="file" class="hidden1"  name="face"/>-->
<!--                                </div>-->
<!--                                <div style="text-align: right; margin-right: 100px">-->
<!--                                    <h6><b>认证</b></h6>-->
<!--                                    <input type="submit"  class="btn-image-upload hidden2" value="upload" />-->
<!--                                </div>-->

                                <div class="upload-btn-wrapper" >
                                    <button class="btn " style="margin-right: 20px" >修改</button>
                                    <input type="file"  id="front" name="face" />
                                </div>
                                <div class="upload-btn-wrapper">
                                    <button  class="btn" style="margin-left: 20px; ">认证</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/datepicker-zh-CN.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/html2canvas.min.js" type="text/javascript"></script>
<script>
    $(function () {
        $("#deadline").datepicker({
            format: "dd/mm/yy",
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            orientation: "top"
        });
    });

    /** preview function*/
    // $("#front").change(function(){
    //     $('#image_preview').html("");
    //     var total_file=document.getElementById("front").files.length;
    //
    //     for(var i=0;i<total_file;i++)
    //     {
    //         $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
    //         // $('#imgg').attr('src', $('#imgg').attr('src')+'?'+baseURL()+"/assets/upload/face/111111/face_image.jpg");
    //     }
    // });
    //
    // $('form').ajaxForm(function()
    // {
    //     alert("Uploaded SuccessFully");
    // });
</script>

<script type="text/javascript">
    function capture() {
        $('#target').html2canvas({
            onrendered: function (canvas) {
                //Set hidden field's value to image data
                $('#img_value').val(canvas.toDataURL("image/png"));
                //Submit the form1
                var hid_img=$("#img_value").val();
                $.ajax({
                    url: ""<?php base_url('bookList/save_img') ?>",
                    type: "POST",
                    data: {
                    hid_img: hid_img,
                },
                success: function (response) {

                    $(".show_img").html(response);

                }
            });
            }
        });
    }
</script>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>