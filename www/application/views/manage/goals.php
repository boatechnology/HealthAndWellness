<div class="box container">
    <div class="row inline">
        <p class="h3 pull-left col-sm-2"><?php echo $this->lang->line('hw_nav_goals'); ?> </p>
        <a href='<?php echo site_url('manage/add_goal'); ?>' class="btn btn-boa">
            <?php echo $this->lang->line('hw_add_goal'); ?>
        </a>
    </div>
    <div id="filters">
        <?php echo form_open('','class="horizontal-form" id="filter-form"'); ?>      
            <div class="row">
                <div class="top-spacer col-sm-4 col-lg-2">
                    <label for="since"><?php echo $this->lang->line('hw_since'); ?></label>
                    <input id="since" style="width: 85px;" type="text" class="btn btn-boa date noactive" name="since" value="<?php echo $since; ?>" />
                </div>
                <div class="top-spacer col-sm-6 col-lg-3">
                    <label for="idusers" class="pull-left" style="margin-right: 4px; position: relative; top: 6px;"><?php echo $this->lang->line('hw_user'); ?> </label> 
                    <?php echo $users_dropdown; ?>
                </div>
                <div class="top-spacer col-sm-6 col-lg-4">
                    <label for="status" class="pull-left" style="margin-right: 4px; position: relative; top: 6px;"><?php echo $this->lang->line('hw_status'); ?> </label> 
                    <?php if (isset($status_dropdown)) echo $status_dropdown; ?>
                </div>
                <div class="top-spacer col-sm-6 col-lg-3">
                    <span class="inline"><?php echo $this->lang->line('hw_sort_by'); ?></span>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-boa <?php if ($sort == 'date') echo "active";?>">
                            <input type="radio" id="sort-date" name="sort" value="date">
                           <?php echo $this->lang->line('hw_created_date'); ?>
                        </label>
                        <label class="btn btn-boa <?php if ($sort == 'user') echo "active";?>">
                            <input type="radio" id="sort-user" name="sort" value="user">
                           <?php echo $this->lang->line('hw_user'); ?>
                        </label>
                    </div> 
                </div>
            </div>
       </form>
    </div>
    <div class="">
        <?php echo $mygoals; ?>
    </div>
</div>