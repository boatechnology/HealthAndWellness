<div class="box container">
    <div class="row inline">
        <p class="h3 pull-left col-sm-2"><?php echo $this->lang->line('hw_activity_log'); ?> </p>
    </div>
    <div  class="row inline">
        <form id='activity-log-form' class='form-inline' role='form'>
            <p class="h4 pull-left" style="margin-top: 17px;"><?php echo $this->lang->line('hw_add_activity'); ?></p>
            <input type='hidden' name='idusers' value='<?php echo $this->session->userdata('idusers'); ?>' />
            <div class='form-group top-spacer'>
                <label class='sr-only' for='date'><?php echo $this->lang->line('hw_date'); ?></label>
                <input name='date' type='text' style='max-width: 85px;' class='form-control date' placeholder='<?php echo $this->lang->line('hw_date'); ?>' value='' />
            </div>
            <div class='form-group top-spacer' style=''>
                <label class='sr-only' for='activity'><?php echo $this->lang->line('hw_activity_class'); ?></label>
                <?php echo $activity_class_dropdown; ?>
            </div>
            <div class='form-group top-spacer' style=''>
                <label class='sr-only' for='activity'><?php echo $this->lang->line('hw_activity'); ?></label>
                <div id='activity_dropdown'>
                </div>
            </div>
            <label id='factor-txt' class='form-group top-spacer' style=''></label>
            <div class='form-group top-spacer'>
                <label class='sr-only' for='quantity'><?php echo $this->lang->line('hw_quantity'); ?></label>
                <input name='quantity' type='number' style='width: 100px;' class='form-control' placeholder='<?php echo $this->lang->line('hw_quantity'); ?>' value='' />
            </div>
            <div class='form-group top-spacer'>
                <label class='sr-only' for='comments'><?php echo $this->lang->line('hw_comments'); ?></label>
                <input name='comments' type='text' class='form-control' placeholder='<?php echo $this->lang->line('hw_comments'); ?>' value='' />
            </div>
            <button id='add_activity' type='button' class='btn btn-boa top-spacer ladda-button' data-style='zoom-in'><?php echo $this->lang->line('hw_add'); ?></button>
        </form>
    </div>
    <div id="filters">
        <?php echo form_open('','class="horizontal-form" id="filter-form"'); ?>
            <div class='row inline'>
                <div class="top-spacer col-sm-2 col-lg-2">
                    <p style="color: #FCC225; margin-bottom: 3px; padding-top: 2px; font-weight: bold;"><?php echo $this->lang->line('hw_since'); ?></p>
                    <input id="date" style="width: 85px;" type="text" class="btn btn-boa date-unlimited noactive" name="date" value="<?php echo $date; ?>"  />
                </div>
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