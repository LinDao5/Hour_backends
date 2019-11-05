<?php
$bookId = $bookInfo->bookId;
$bookSerial = $bookInfo->bookSerial;
$bookName = $bookInfo->bookName;
$coverUrl = $bookInfo->coverUrl;
$author = $bookInfo->author;
$publishingHouse = $bookInfo->publishingHouse;
$publishDate = $bookInfo->publishDate;
$category = $bookInfo->category;
$averageProgress = $bookInfo->averageProgress;
$allAverageTime = $bookInfo->allAverageTime;
$favouriteCount = $bookInfo->favouriteCount;
$attentionCount = $bookInfo->attentionCount;
$readingCount = $bookInfo->readingCount;
$isReadCount = $bookInfo->isReadCount;
$downloadedCount = $bookInfo->downloadedCount;
$isbn = $bookInfo->isbn;
$edition = $bookInfo->edition;
$pageCount = $bookInfo->pageCount;
$demandTime = $bookInfo->demandTime;
$deadline = $bookInfo->deadline;
$summary = $bookInfo->summary;

?>

<style>
    th {
        background-color: #f8f9fb;
    }
    #hidden{
        opacity: 0;
        width: 245px;
        height: 185px;
        position: absolute;
        cursor: pointer;
        top: 20px;
        left: 20px;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-book"></i> 书籍管理
            <small> 编辑书籍</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">输入书籍详情</h3>
                    </div><!-- /.box-header -->

                    <!-- file upload part -->
                    <?php echo form_open_multipart('Backend/bookList/updateBook');?>
                    <div class="box-body " >

                        <table class="table table-hover table-bordered">
                            <tr>
                                <td rowspan="4" style="width:15%; vertical-align: middle; text-align: center">

                                    <div class="form-group">
                                        <img src="<?php echo base_url().$coverUrl;?>" alt="Smiley face" height="130" width="100">

<!--                                        <input type="file" id="hidden" name="bookfile" class="form-control"  id="bookfile">-->
                                    </div>
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%; ">编号</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="bookSerial" id="bookSerial" value="<?php echo $bookSerial;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">分类</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <select name="category" id="category"  class="form-control input-sm pull-right"  >
                                        <option   value="">选择你想查看的分类</option>
                                        <option <?php if ($category == "0") echo 'selected';?> value="0">未定</option>
                                        <option <?php if ($category == "0") echo 'selected';?> value="1">自然科学</option>
                                        <option <?php if ($category == "1") echo 'selected';?>  value="2">文学艺术</option>
                                        <option <?php  if ($category == "2") echo 'selected';?>  value="3">推荐</option>
                                        <option <?php  if ($category == "3") echo 'selected';?>  value="4">关注</option>
                                    </select>
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">关注数</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="attentionCount" id="attentionCount" value="<?php echo $attentionCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">ISBN</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="isbn" id="isbn" value="<?php echo $isbn;?>">
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 8%">书名</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="bookName" id="bookName" value="<?php echo $bookName;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">人均进度</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="averageProgress" id="averageProgress" value="<?php echo $averageProgress;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">阅读数</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="readingCount" id="readingCount" value="<?php echo $readingCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">版次</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="edition" id="edition" value="<?php echo $edition;?>">
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 8%">作者</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="author" id="author" value="<?php echo $author;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">读完人均用时</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="allAverageTime" id="allAverageTime" value="<?php echo $allAverageTime;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">已读数</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="isReadCount" id="isReadCount" value="<?php echo $isReadCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">出版时间</th>
                                <div class="input-group">
                                    <td class="input-group">
                                        <input id="publishDate" type="text" name="publishDate" value="<?php $dt = new DateTime($publishDate); echo $dt->format('Y-m-d'); ?>" class="form-control datepicker" placeholder="至今" autocomplete="off" />
                                        <span class="input-group-addon"><label for="publishDate"><i class="fa fa-calendar"></i></label></span>
                                    </td>
<!--                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">-->
<!--                                        <input class="no-border form-control required form-control datepicker" type="text" name="publishDate" id="publishDate" value="--><?php //$dt = new DateTime($publishDate); echo $dt->format('Y-m-d') ;?><!--" autocomplete="off">-->
<!--                                        <span class="input-group-addon"><label for="publishDate"><i class="fa fa-calendar"></i></label></span>-->
<!--                                    </td>-->
                                </div>

                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 8%">出版社</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="publishingHouse" id="publishingHouse" value="<?php echo $publishingHouse;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">收藏数</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="favouriteCount" id="favouriteCount" value="<?php echo $favouriteCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">下载数</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="downloadedCount" id="downloadedCount" value="<?php echo $downloadedCount;?>">
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 8%">页数</th>
                                <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="pageCount" id="pageCount" value="<?php echo $pageCount;?>">
                                </td>
                            </tr>

                            <tr>
                                <th rowspan="2" colspan="2" style="width: 15% ; text-align: center; vertical-align: middle">简介</th>
                                <td rowspan="2" colspan="5" style="width: 20%;padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <textarea rows="4" class="no-border" style="width: 100%;height: 100%; margin-bottom: 0px; padding: 3px" name="summary" id="summary" value="<?php echo $summary;?>"><?php echo $summary;?></textarea>
                                </td>
                                <th style="text-align: center; vertical-align: middle; width: 5%">要求时长</th>
                                <td style=" text-align: center; vertical-align: middle; width: 15%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                    <input class="no-border form-control required" type="text" name="demandTime" id="demandTime" value="<?php  echo $demandTime;?>">
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; width: 5%">截止日期</th>
                                <td  class="input-group">
                                    <input id="deadline" type="text" name="deadline" value="<?php $dt = new DateTime($deadline); echo $dt->format('Y-m-d'); ?>" class=" form-control datepicker " autocomplete="off" />
                                    <span class="input-group-addon"><label for="deadline"><i class="fa fa-calendar"></i></label></span>
                                </td>
<!--                                    <input class="no-border form-control required" type="text" name="deadline" id="deadline" value="--><?php //$dt = new DateTime($deadline); echo $dt->format('Y-m-d') ;?><!--">-->
<!--                                    <span class="input-group-addon"><label for="deadline"><i class="fa fa-calendar"></i></label></span>-->
                            </tr>

                        </table>
                    </div>

                    <input type="hidden" name="bookId" id="bookId" value="<?php  echo $bookId;?>"/>
                    <div class="text-right" style="margin-right: 20px">
                        <button type="submit" class="btn btn-success"  style="background-color: #7d1886;" >保存修改</button>
                    </div>
                    </form>

                </div>
            </div>

        </div>
    </section>

</div>

<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!--<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<!--<script src="--><?php //echo base_url(); ?><!--assets/plugins/jQueryUI/html2canvas.min.js" type="text/javascript"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--assets/plugins/jQueryUI/jquery.plugin.html2canvas.js" type="text/javascript"></script>-->
<script  type="text/javascript">
    // $(function () {
    //     $("#deadline").datepicker({
    //         format: "dd-mm-yyyy",
    //         showOtherMonths: true,
    //         selectOtherMonths: true,
    //         autoclose: true,
    //         changeMonth: true,
    //         changeYear: true,
    //         orientation: "top"
    //     });
    // });
    //
    // $(function () {
    //     $("#publishDate").datepicker({
    //         format: "dd-mm-yyyy",
    //         showOtherMonths: true,
    //         selectOtherMonths: true,
    //         autoclose: true,
    //         changeMonth: true,
    //         changeYear: true,
    //         orientation: "top"
    //     });
    // });
    jQuery(document).ready(function(){

        jQuery('#deadline').datepicker({
            autoclose: true,
            format : "yyyy-mm-dd",
            language: 'zh-CN'
        });
        jQuery('#publishDate').datepicker({
            autoclose: true,
            format : "yyyy-mm-dd",
            language: 'zh-CN'
        });
    });

</script>
