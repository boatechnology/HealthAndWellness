<div class="box container">
    <div class="row inline">
        <p class="h3 pull-left col-sm-3"><?php echo $this->lang->line('hw_manage_database'); ?> </p>
        <a href='<?php echo site_url('crud/sql_backup'); ?>' class="btn btn-boa">
            <?php echo $this->lang->line('hw_manage_download_sql'); ?>
        </a>
    </div>
        <div class="top-spacer" >
            <ul class="nav nav-tabs" id="myTabs">
                <li class="active btn-boa"><a href="#activities" data-toggle="tab"><?php echo $this->lang->line('hw_nav_activities'); ?></a></li>
                <li class="btn-boa"><a href="#activity_classes" data-toggle="tab"><?php echo $this->lang->line('hw_manage_activity_classes'); ?></a></li>
                <li class="btn-boa"><a href="#activity_statuses" data-toggle="tab"><?php echo $this->lang->line('hw_manage_activity_statuses'); ?></a></li>
                <li class="btn-boa"><a href="#activity_log" data-toggle="tab"><?php echo $this->lang->line('hw_manage_activity_logs'); ?></a></li>
                <li class="btn-boa"><a href="#goals" data-toggle="tab"><?php echo $this->lang->line('hw_nav_goals'); ?></a></li>
                <li class="btn-boa"><a href="#statuses" data-toggle="tab"><?php echo $this->lang->line('hw_manage_goal_statuses'); ?></a></li>
                <li class="btn-boa"><a href="#users" data-toggle="tab"><?php echo $this->lang->line('hw_manage_users'); ?></a></li>
                <li class="btn-boa"><a href="#content" data-toggle="tab"><?php echo $this->lang->line('hw_manage_content'); ?></a></li>
            </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="activities" data-src="<?php echo site_url('crud/activities') ?>">
                <iframe style="height: 1050px; width: 100%;" src="<?php echo site_url('crud/activities') ?>">
                </iframe>
            </div>
            <div class="tab-pane" id="activity_classes" data-src="<?php echo site_url('crud/activity_classes') ?>">
                <iframe style="height: 1050px; width: 100%;" src="<?php //echo site_url('crud/activity_classes') ?>">
                </iframe>
            </div>
            <div class="tab-pane" id="activity_statuses" data-src="<?php echo site_url('crud/activity_statuses') ?>">
                <iframe style="height: 1050px; width: 100%;" src="">
                </iframe>
            </div>
            <div class="tab-pane" id="activity_log" data-src="<?php echo site_url('crud/activity_log') ?>">
                <iframe style="height: 1050px; width: 100%;" src="<?php //echo site_url('crud/activity_log') ?>">
                </iframe>
            </div>
            <div class="tab-pane" id="goals" data-src="<?php echo site_url('crud/goals') ?>">
                <iframe style="height: 1050px; width: 100%;" src="<?php //echo site_url('crud/activity_classes') ?>">
                </iframe>
            </div>
            <div class="tab-pane" id="statuses" data-src="<?php echo site_url('crud/statuses') ?>">
                <iframe style="height: 1050px; width: 100%;" src="<?php //echo site_url('crud/activity_classes') ?>">
                </iframe>
            </div>
            <div class="tab-pane" id="users" data-src="<?php echo site_url('crud/users') ?>">
                <iframe style="height: 1050px; width: 100%;" src="<?php //echo site_url('crud/activity_classes') ?>">
                </iframe>
            </div>
            <div class="tab-pane" id="content" data-src="<?php echo site_url('crud/content') ?>">
                <iframe style="height: 1050px; width: 100%;" src="<?php //echo site_url('crud/activity_classes') ?>">
                </iframe>
            </div>
        </div>
        </div>
    </div>
</div>
