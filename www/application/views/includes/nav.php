<div class="navbar navbar-inverse ">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand">
                <a href="/">  
                    <img src="<?php echo base_url('/assets/pics/abc-logo-sm.png'); ?>">
                </a>
            </div>
            <h4 class="navbar-text"><?php echo $this->lang->line('hw_nav_title'); ?></h4>
        </div>
        <div id="my-nav" class="navbar-header collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="<?php if (uri_string() == '') echo 'active'; ?>">
                    <a href="<?php echo site_url(''); ?>" class=""><?php echo $this->lang->line('hw_nav_home'); ?></a>
                </li>
              <li class="dropdown ">  
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('hw_nav_submit'); ?><b class="caret"></b></a>  
                    <ul class="dropdown-menu">  
                        <li class="<?php if (uri_string() == 'user/activities') echo 'active'; ?>">
                            <a href="<?php echo site_url('user/activities'); ?>"><?php echo $this->lang->line('hw_nav_activity'); ?></a>
                        </li>
                        <li class="<?php if (uri_string() == 'hw/add_goal') echo 'active'; ?>">
                            <a href="<?php echo site_url('hw/add_goal'); ?>"><?php echo $this->lang->line('hw_nav_goal'); ?></a>
                        </li>  
                        <li><a href="#feedback-modal" data-toggle="modal"><?php echo $this->lang->line('hw_nav_feedback'); ?></a></li>
                   </ul>  
               </li>
               <?php if ($this->session->userdata('isadmin') == 1) { ?>
               <li class="dropdown ">  
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->lang->line('hw_nav_manage'); ?><b class="caret"></b></a>  
                    <ul class="dropdown-menu">  
                        <li>
                            <a href="<?php echo site_url('manage/activity_log'); ?>"><?php echo $this->lang->line('hw_nav_activities'); ?></a>
                        </li>
                        <li class="<?php if (uri_string() == 'manage/goals') echo 'active'; ?>">
                            <a href="<?php echo site_url('manage/goals'); ?>"><?php echo $this->lang->line('hw_nav_goals'); ?></a>
                        </li>  
                        <li class="<?php if (uri_string() == 'manage/data') echo 'active'; ?>">
                            <a href="<?php echo site_url('manage/data'); ?>"><?php echo $this->lang->line('hw_nav_database'); ?></a>
                        </li>
                        <li class="<?php if (uri_string() == 'crud/files') echo 'active'; ?>">
                            <a href="<?php echo site_url('crud/files'); ?>"><?php echo $this->lang->line('hw_nav_downloads'); ?></a>
                        </li>
                   </ul>  
               </li>
               <?php } ?>
               <li class="dropdown">  
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <?php echo $this->session->userdata('username'); ?> 
                      <b class="caret"></b>
                   </a>  
                    <ul class="dropdown-menu">
                        <li style="color: black;">
                            <a href="<?php echo site_url('user/profile'); ?>">
                                <?php echo $this->session->userdata('cn'); ?> 
                                <span class="badge"> <?php echo $this->session->userdata('hwnumber'); ?></span>
                            </a>
                        </li>
                        <li class="<?php if (uri_string() == 'user/activities') echo 'active'; ?>">
                            <a href="<?php echo site_url('user/activities'); ?>"><?php echo $this->lang->line('hw_nav_activities'); ?></a>
                        </li>
                        <li class="<?php if (uri_string() == 'user/goals') echo 'active'; ?>">
                            <a href="<?php echo site_url('user/goals'); ?>"><?php echo $this->lang->line('hw_nav_goals'); ?></a>
                        </li> 
                        <li><a href="<?php echo site_url('user/logout'); ?>"><?php echo $this->lang->line('hw_nav_logout'); ?></a></li>
                   </ul>  
               </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<div class="row-fluid centering col-sm-8 col-md-6">
<?php if (isset($msg)) { echo "<div class='alert alert-success alert-dismissable'>
     <button type='button' class='close' data-dismiss='alert' areia-hidden='true'>x</button>
     $msg
     </div>"; }?>
<?php if (isset($error)) { echo "<div class='alert alert-danger alert-dismissable'>
     <button type='button' class='close' data-dismiss='alert' areia-hidden='true'>x</button>
     $error
     </div>"; }?>
</div>
