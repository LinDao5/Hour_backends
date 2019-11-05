<?php
if (!empty($readingCount)){
    $readingCounts = $readingCount;
}
if (!empty($allTime)){
    $allTimes = $allTime;
}
?>
<style>
    th, td{
        text-align: center; vertical-align
    }
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
        <i class="fa fa-user"></i>
          用户管理
        <small>添加, 编辑, 删除</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">用户列表</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>bookuserListing" method="POST" id="searchList">
                            <div class="input-group">
                                <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="搜索"/>
                                <select name="classSearch" id="classSearch"  class="form-control input-sm pull-right" style="width: 160px; margin-right: 10px" placeholder="编号/书名/作者等" >
                                    <option  value="">选择你想查看的班级</option>
                                    <option <?php if ($classSearch == "电商14") echo 'selected';?> value="电商14">电商14</option>
                                    <option <?php if ($classSearch == "电商15") echo 'selected';?>  value="电商15">电商15</option>
                                    <option <?php if ($classSearch == "电商16") echo 'selected';?>  value="电商16">电商16</option>
                                    <option <?php if ($classSearch == "电商17") echo 'selected';?>  value="电商17">电商17</option>
                                </select>
                                <select name="schoolSearch" id="schoolSearch"  class="form-control input-sm pull-right" style="width: 160px; margin-right: 10px" placeholder="搜索" >
                                    <option  value="">选择你想查看的大学</option>
                                    <option <?php if ($schoolSearch == "辽宁科技大学") echo 'selected';?> value="辽宁科技大学">辽宁科技大学</option>
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
                    <tr>
                        <th>编号</th>
                        <th>姓名</th>
                        <th>最近阅读</th>
                        <th> &nbsp; 进度 &nbsp;&nbsp;</th>
                        <th>用时</th>
                        <th>阅历</th>
                        <th>已读本数</th>
                        <th>合格</th>
                        <th>学号</th>
                        <th>班级</th>
                        <th>学校</th>
                        <th>手机号</th>
                        <th>身份状态</th>
                        <th>人脸状态</th>
                        <th class="text-center">操作</th>
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $key => $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->userSerial;?></td>
                        <td><?php echo $record->name ; ?></td>
                        <td>
                            <img src="<?php echo base_url(). $record->coverUrl;?>" onerror="this.src='<?php echo base_url()."assets/upload/cover/austen.png";?>';" alt="Smiley face" height="42" width="32">
                            <?php  echo $record->bookName ;?>
                        </td>
                        <td>
                            <div id="myBar">
                                <div id="myProgress" style="width: <?php echo $record -> progress ."%"; ?>;"></div>
                            </div>
                            <?php if (!is_null($record -> progress))
                                echo $record -> progress ."%";
                            else echo ""?>
                        </td>
                        <td>
                            <?php echo $record -> time ;?>
                        </td>
                        <td><?php
                            if (!empty($allTimes[$key]))
                                echo $allTimes[$key];
                            ?></td>
                        <td><?php
                            if (!empty($readingCounts[$key]))
                                echo $readingCounts[$key];
                            else echo 0;
                            ?></td>
                        <td></td>
                        <td><?php echo $record->studId; ?></td>
                        <td><?php echo $record->class ; ?></td>
                        <td><?php echo $record->school ; ?></td>
                        <td><?php echo $record->mobile; ?></td>
                        <td><?php if ($record->identyStatus == 1) echo "已认证";
                             else echo "未认证"?></td>
                        <td><?php if ($record->faceStatus == 1) echo "已认证";
                            else echo "未认证"?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editBookUserScreen/'.$record->userId; ?>" title="编辑"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteBookUser" href="#" data-userid="<?php echo $record->userId; ?>" title="删除"><i class="fa fa-trash"></i></a>

                        </td>
                    </tr>
                    <?php
                        }
                    }
//                    ?>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bookuser.js" charset="utf-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "bookuserListing/" + value);
            jQuery("#searchList").submit();
        });
    });



</script>
