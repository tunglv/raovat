<!-- START OF LEFT PANEL -->
<div class="leftpanel">

    <div class="logopanel">
        <h1><a href="<?php echo $this->createUrl('/admin')?>">Admin Area <span><?php echo $this->domain?></span></a></h1>
    </div><!--logopanel-->

    <div class="datewidget">Today is <?php echo date('l, M d, Y')?></div>

    <div class="leftmenu">        
        <ul class="nav nav-tabs nav-stacked">
            <li class="nav-header">Main Navigation</li>
            
            
            <?php if($this->manager->isStaffOnly):?>
            <li <?php if($this->menu_parent_selected == 'manager'):?> class="active"<?php endif?>>
                <a href="<?php echo $this->createUrl('/admin/manager/update')?>"><span class="icon-user"></span> Tài khoản</a>
            </li>
            <?php else:?>
            <li class="dropdown <?php if($this->menu_parent_selected == 'manager'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/manager')?>">
                    <span class="icon-user"></span> Nhân viên
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'manager') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'manager_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/manager/create')?>">Thêm mới</a></li>
                    <li<?php if($this->menu_child_selected == 'manager'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/manager')?>">Quản lý</a></li>
                </ul>
            </li>
            <?php endif?>
            
            <li class="dropdown <?php if($this->menu_parent_selected == 'object'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/object')?>">
                    <span class="icon-fire"></span> Quản trị tin rao vặt
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'object') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'object_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/object/create')?>">Thêm tin rao vặt</a></li>
                    <li<?php if($this->menu_child_selected == 'object'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/object')?>">Quản lý tin rao vặt</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($this->menu_parent_selected == 'catagory'):?>active<?php endif?>">
                <a href="<?php echo $this->createUrl('/admin/catagory')?>">
                    <span class="icon-fire"></span> Danh mục SP
                </a>
                <ul class="<?php echo ($this->menu_parent_selected == 'catagory') ? 'opened':'closed'?>">
                    <li<?php if($this->menu_child_selected == 'catagory_create'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/catagory/create')?>">Thêm danh mục SP</a></li>
                    <li<?php if($this->menu_child_selected == 'catagory'):?> class="active"<?php endif?>><a href="<?php echo $this->createUrl('/admin/catagory')?>">Quản lý danh mục SP</a></li>
                </ul>
            </li>
        </ul>
    </div><!--leftmenu-->

    </div><!--mainleft-->
    <!-- END OF LEFT PANEL -->