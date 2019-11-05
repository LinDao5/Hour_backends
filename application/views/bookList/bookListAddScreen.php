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
            <small> 添加书籍</small>
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
                    <?php echo form_open_multipart('backend/bookList/addNewBook');?>
                        <div class="box-body " >

                            <table class="table table-hover table-bordered">
                                <tr>
                                    <td rowspan="4" style="width:15%; vertical-align: middle; text-align: center">
                                        <div class="form-group">
                                            <canvas id="pdf-canvas" width="40" height="50" style="z-index: 1000"></canvas>
                                            <div><h1 style="text-align: center; vertical-align: middle;"><strong>+</strong></h1></div>
                                            <div><h6 style="text-align: center; vertical-align: middle;">点击上传书籍</h6></div>
                                            <input type="file" id="hidden" accept="application/pdf"  name="bookfile" class="form-control"  id="bookfile">
                                        </div>
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%; ">编号</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;"><input class="no-border form-control required" type="text" name="bookSerial" id="bookSerial" value="<?php echo "";?>"></td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">分类</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <select name="category" id="category"  class="form-control input-sm pull-right"  >
                                            <option  value="">选择你想查看的分类</option>
                                            <option  value="2">未定</option>
                                            <option  value="1">自然科学</option>
                                            <option   value="2">文学艺术</option>
                                            <option   value="3">推荐</option>
                                            <option   value="4">关注</option>
                                        </select>
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">关注数</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                        <input class="no-border form-control required" type="text" name="attentionCount" id="attentionCount" value="--><?php //echo "";?><!--">-->
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">ISBN</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="isbn" id="isbn" value="<?php echo "";?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">书名</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="bookName" id="bookName" value="<?php echo "";?>">
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">人均进度</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                        <input class="no-border form-control required" type="text" name="averageProcess" id="averageProcess" value="--><?php //echo "";?><!--">-->
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">阅读数</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                        <input class="no-border form-control required" type="text" name="readingCount" id="readingCount" value="--><?php //echo "";?><!--">-->
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">版次</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="edition" id="edition" value="<?php echo "";?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">作者</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="author" id="author" value="<?php echo "";?>">
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">读完人均用时</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                        <input class="no-border form-control required" type="text" name="allAverageTime" id="allAverageTime" value="--><?php //echo "";?><!--">-->
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">已读数</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                        <input class="no-border form-control required" type="text" name="isReadCount" id="isReadCount" value="--><?php //echo "";?><!--">-->
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">出版时间</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="publishDate" id="publishDate" value="<?php echo "";?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">出版社</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="publishingHouse" id="publishingHouse" value="<?php echo "";?>">
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">收藏数</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                        <input class="no-border form-control required" type="text" name="favouriteCount" id="favouriteCount" value="--><?php //echo "";?><!--">-->
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">下载数</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
<!--                                        <input class="no-border form-control required" type="text" name="downloadedCount" id="downloadedCount" value="--><?php //echo "";?><!--">-->
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 8%">页数</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 12%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="pageCount" id="pageCount" value="<?php echo "";?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th rowspan="2" colspan="2" style="width: 15% ; text-align: center; vertical-align: middle">简介</th>
                                    <td rowspan="2" colspan="5" style="width: 20%;padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <textarea rows="4" class="no-border" style="width: 100%;height: 100%; margin-bottom: 0px; padding: 3px" name="summary" id="summary" value="<?php echo "";?>"></textarea>
                                    </td>
                                    <th style="text-align: center; vertical-align: middle; width: 5%">要求时长</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 15%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="demandTime" id="demandTime" value="<?php echo "";?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle; width: 5%">截止日期</th>
                                    <td style=" text-align: center; vertical-align: middle; width: 15%; padding: 0px;margin: 0px; border-spacing: 0px;">
                                        <input class="no-border form-control required" type="text" name="deadline" id="deadline" value="<?php echo "";?>">
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <input type="hidden" name="img_value" id="img_value" value="" />
                        <div class="text-right" style="margin-right: 20px">
                            <button type="submit" id="save"   class="btn btn-success"  style="background-color: #7d1886;" ;">保存</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

<!--    <div>-->
<!---->
<!--        <!-- test-->
<!--        <div id="pdf-main-container">-->
<!--            <div id="pdf-contents">-->
<!--                <div id="pdf-meta">-->
<!--                    <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div>-->
<!--                </div>-->
<!---->
<!--                <a id="download-image" href="#">Download PNG</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div>-->
<!--        <h1>convert to jgp example</h1>-->
<!--        <div class="container">-->
<!--            <form method="POST" action="--><?php //echo base_url(); ?><!--getThumbnail" enctype="multipart/form-data">-->
<!---->
<!---->
<!--                <div class="form-group">-->
<!--                    <label>Add Image:</label>-->
<!--                    <input type="file" name="file" class="form-control">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <button class="btn btn-success">Submit</button>-->
<!--                </div>-->
<!--            </form>-->
<!---->
<!--        </div>-->
<!--    </div>-->

</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/datepicker-zh-CN.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/html2canvas.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery.plugin.html2canvas.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/pdf.worker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/pdf.js" type="text/javascript"></script>
<script src="pdf.js"></script>
<script src="pdf.worker.js"></script>
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


    $(function () {
        $("#publishDate").datepicker({
            format: "dd/mm/yy",
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            orientation: "top"
        });
    });


  /* pdf to image */
    var __PDF_DOC,
        __CURRENT_PAGE,
        __TOTAL_PAGES,
        __PAGE_RENDERING_IN_PROGRESS = 0,
        __CANVAS = $('#pdf-canvas').get(0),
        __CANVAS_CTX = __CANVAS.getContext('2d');

    function showPDF(pdf_url) {
        $("#pdf-loader").show();

        PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
            __PDF_DOC = pdf_doc;
            __TOTAL_PAGES = __PDF_DOC.numPages;

            // Hide the pdf loader and show pdf container in HTML
            $("#pdf-loader").hide();
            $("#pdf-contents").show();
            $("#pdf-total-pages").text(__TOTAL_PAGES);

            // Show the first page
            showPage(1);
        }).catch(function(error) {
            // If error re-show the upload button
            $("#pdf-loader").hide();
            $("#upload-button").show();

            alert(error.message);
        });;
    }

    function showPage(page_no) {
        __PAGE_RENDERING_IN_PROGRESS = 1;
        __CURRENT_PAGE = page_no;

        // Disable Prev & Next buttons while page is being loaded
        $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

        // While page is being rendered hide the canvas and show a loading message
        $("#pdf-canvas").hide();
        $("#page-loader").show();
        $("#download-image").hide();

        // Update current page in HTML
        $("#pdf-current-page").text(page_no);

        // Fetch the page
        __PDF_DOC.getPage(page_no).then(function(page) {
            // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
            var scale_required = __CANVAS.width / page.getViewport(1).width;

            // Get viewport of the page at required scale
            var viewport = page.getViewport(scale_required);

            // Set canvas height
            __CANVAS.height = viewport.height;

            var renderContext = {
                canvasContext: __CANVAS_CTX,
                viewport: viewport
            };

            // Render the page contents in the canvas
            page.render(renderContext).then(function() {
                __PAGE_RENDERING_IN_PROGRESS = 0;

                // Re-enable Prev & Next buttons
                $("#pdf-next, #pdf-prev").removeAttr('disabled');

                // Show the canvas and hide the page loader
                $("#pdf-canvas").show();
                $("#page-loader").hide();
                $("#download-image").show();
            });
        });
    }

    // Upon click this should should trigger click on the #file-to-upload file input element
    // This is better than showing the not-good-looking file input element
    // When user chooses a PDF file
    $("#save").on('click', function() {
        $("#download-image").trigger('click');
    });


    $("#file-to-upload").on('change', function() {
        // Validate whether PDF
        if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) == -1 ||
            ['application/epub'].indexOf($("#file-to-upload").get(0).files[0].type) == -1) {
            alert('Error : Not a PDF');
            return;
        }

        $("#upload-button").hide();

        // Send the object url of the pdf
        showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));
    });

    // Previous page of the PDF
    $("#pdf-prev").on('click', function() {
        if(__CURRENT_PAGE != 1)
            showPage(--__CURRENT_PAGE);
    });

    // Next page of the PDF
    $("#pdf-next").on('click', function() {
        if(__CURRENT_PAGE != __TOTAL_PAGES)
            showPage(++__CURRENT_PAGE);
    });

    // Download button
    $("#download-image").on('click', function() {
        $(this).attr('href', __CANVAS.toDataURL()).attr('download', 'page.png');
    });

</script>

<script type="text/javascript">

</script>