<div class="box container">
    <div class="row inline">
        <p class="h3 pull-left col-sm-2"><?php echo $this->lang->line('hw_activity_log'); ?> </p>
        <a href='<?php echo site_url('user/activities'); ?>' class="btn btn-boa">
            <?php echo $this->lang->line('hw_add_activity'); ?>
        </a>
    </div>
    <div id="filters">
        <?php echo form_open('','class="horizontal-form" id="filter-form"'); ?>
            <div class="row inline">
                <div class="top-spacer col-sm-4 col-lg-2">
                    <label for="date"><?php echo $this->lang->line('hw_since'); ?></label>
                    <input id="date" style="width: 85px;" type="text" class="btn btn-boa date noactive" name="date" value="<?php echo $date; ?>"  />
                </div>
                <div class="top-spacer col-sm-6 col-lg-2">
                    <label for="approval" class="pull-left" style="margin-right: 4px; "> </label> 
                    <?php if (isset($status_dropdown)) echo $status_dropdown; ?>
                </div>
               <div class="top-spacer col-sm-6 col-lg-5">
                    <label for="approval" class="pull-left" style="margin-right: 4px; position: relative; top: 6px;"> </label> 
                    <?php if (isset($users_dropdown)) echo $users_dropdown; ?>
                </div>
            </div>
            <div class='row inline'>
                <div class="top-spacer col-sm-4 col-lg-4">
                    <label for="approval" class="pull-left" style="margin-right: 4px; position: relative; top: 4px;"><?php echo $this->lang->line('hw_activities_class'); ?> </label> 
                    <?php if (isset($activity_class_dropdown)) echo $activity_class_dropdown; ?>
                </div>
                <div class="top-spacer col-sm-6 col-lg-4">
                    <label for="approval" class="pull-left" style="margin-right: 4px; position: relative; top: 4px;"><?php echo $this->lang->line('hw_activities_activity'); ?> </label> 
                    <?php if (isset($activity_dropdown)) echo $activity_dropdown; ?>
                </div>
            </div>
        </form>
    </div>
    <div class="onload-show" >
        <?php echo $activity_table; ?>
    </div>
</div>