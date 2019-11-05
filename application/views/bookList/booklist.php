<style>
    #myBar {
        width: 100%;
        background-color: #fdcb33;
    }

    #myProgress {
        width: 0%;
        height: 10px;
        background-color: purple;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-boo"></i>
          书籍管理
        <small>加, 编辑, 删除</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>bookListAddScreen"><i class="fa fa-plus"></i> 添加书籍</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">书籍列表</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>bookListing" method="POST" id="searchList">
                            <div class="input-group">
                                <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px; margin-right: 10px" placeholder="编号/书名/作者等"/>
                                <select name="categorySearch" id="categorySearch"  class="form-control input-sm pull-right" style="width: 160px; margin-right: 10px" placeholder="搜索" >
                                   <option  value="">选择你想查看的分类</option>
                                    <option <?php if ($categorySearch == "0") echo 'selected';?> value="0">未定</option>
                                    <option <?php if ($categorySearch == "1") echo 'selected';?> value="1">自然科学</option>
                                    <option <?php if ($categorySearch == "2") echo 'selected';?>  value="2">文学艺术</option>
                                    <option <?php  if ($categorySearch == "3") echo 'selected';?>  value="3">推荐</option>
                                    <option <?php  if ($categorySearch == "4") echo 'selected';?>  value="4">关注</option>
                                </select>
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered">
                    <tr style="text-align: center; vertical-align: middle">
                        <th style="text-align: center; vertical-align: middle">编号</th>
                        <th style="text-align: center; vertical-align: middle">图标</th>
                        <th style="text-align: center; vertical-align: middle">书名</th>
                        <th style="text-align: center; vertical-align: middle">作者</th>
                        <th style="text-align: center; vertical-align: middle" >分类</th>
                        <th style="text-align: center; vertical-align: middle">人均进度</th>
                        <th style="text-align: center; vertical-align: middle">人均用时</th>
                        <th style="text-align: center; vertical-align: middle">读完人均用时</th>
                        <th style="text-align: center; vertical-align: middle">要求时长</th>
                        <th style="text-align: center; vertical-align: middle">截止日期</th>
                        <th style="text-align: center; vertical-align: middle">收藏数</th>
                        <th style="text-align: center; vertical-align: middle">下载数</th>
                        <th style="text-align: center; vertical-align: middle">关注数</th>
                        <th style="text-align: center; vertical-align: middle">阅读数</th>
                        <th style="text-align: center; vertical-align: middle">已读数</th>
                        <th class="text-center">操作</th>
                    </tr>
                    <?php
                   if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr style="text-justify: auto" >
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->bookSerial ?></td>
                        <td style="text-align: center; vertical-align: middle"><img src="<?php echo base_url(). $record->coverUrl;?>" onerror="this.src='<?php echo base_url()."assets/upload/cover/austen.png";?>';" alt="Smiley face" height="42" width="32"></td>
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->bookName; ?></td>
                        <td style="text-align: center; vertical-align: middle"><?php  echo $record->author ;?></td>
                        <td style="text-align: center; vertical-align: middle">
                            <?php  $case = $record->category;
                                   switch ($case){
                                       case $case == 0:
                                           echo "未定";
                                           break;
                                       case $case == 1:
                                           echo "自然科学";
                                           break;
                                       case $case == 2:
                                           echo "文学艺术";
                                           break;
                                       case $case == 3:
                                           echo "推荐";
                                           break;
                                       case $case == 4:
                                           echo "关注";
                                           break;
                                   }
                                ;?>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <div id="myBar">
                                <div id="myProgress" style="width:<?php
                                if (!is_null($record->averageProgress) )
                                    echo $record->averageProgress ;
                                else echo "0";?>%"></div>
                            </div>
                            <?php if (!is_null($record->averageProgress) && !$record->averageProgress == "")
                                echo $record->averageProgress;
                                else echo ""; ?>
                        </td>
                        <td style="text-align: center; vertical-align: middle">
                            <?php if (!is_null($record->averageTime) && !$record->averageTime == 0)
                                echo $record->averageTime ;
                            else echo "0" ;?>小时</td>
                        <td style="text-align: center; vertical-align: middle">
                            <?php if (!is_null($record->allAverageTime) && !$record->allAverageTime == 0)
                                echo $record->allAverageTime ;
                            else echo "0" ;?>小时
                        </td>
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->demandTime; ?>小时</td>
                        <td style="text-align: center; vertical-align: middle"><?php $dt = new DateTime($record->deadline)  ;
                                              echo  $dt->format('Y-m-d') ;?></td>
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->favouriteCount; ?></td>
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->downloadedCount; ?></td>
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->attentionCount; ?></td>
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->readingCount; ?></td>
                        <td style="text-align: center; vertical-align: middle"><?php echo $record->isReadCount; ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editBookListScreen/'.$record->bookId; ?>" title="编辑"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteBookList" href="#" data-bookid="<?php echo $record->bookId; ?>" title=" 删除"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div>
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/booklist.js" charset="utf-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // jQuery('ul.pagination li a').click(function (e) {
        //     e.preventDefault();
        //     var link = jQuery(this).get(0).href;
        //     var value = link.substring(link.lastIndexOf('/') + 1);
        //     jQuery("#searchList").attr("action", baseURL + "bookListing/" + value);
        //     jQuery("#searchList").submit();
        // });

        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            jQuery("#searchList").attr("action", link);
            jQuery("#searchList").submit();
        });
    });
</script>
