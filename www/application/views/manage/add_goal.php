<div class="row-fluid box centering col-xs-11 col-sm-8 col-md-6">
    <h3><?php echo $this->lang->line('hw_add_goal_header'); ?> <span class="small pull-right"><span class="red">*</span> <?php echo $this->lang->line('hw_required_fields'); ?></span></h3>
    <div class="">
        <div>
            <?php echo form_open('','class=" form-horizontal white"'); ?>
                <div class='row'>
                <div class="">
                    <?php echo form_error('idusers'); ?>
                    <label for="idusers" class="pull-left" style="margin-right: 4px; position: relative; top: 6px;"><?php echo $this->lang->line('hw_user'); ?> </label> 
                    <?php echo $users_dropdown; ?>
                </div>
                <div class="top-spacer">
                    <?php echo form_error('status'); ?>
                    <label for="status" class="pull-left" style="margin-right: 4px; position: relative; top: 6px;"><?php echo $this->lang->line('hw_status'); ?> </label> 
                    <?php if (isset($status_dropdown)) echo $status_dropdown; ?>
                </div>
                </div>
                 <div class="form-group top-spacer">
                        <label>
                            <input type="checkbox" name="public" <?php if ((set_value('public') == "" && $this->input->post('idusers') == '') || set_value('public') == "on" || set_value('public') == "1") echo 'checked="checked"'; ?>> <?php echo $this->lang->line('hw_add_goal_public'); ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="anonymous" <?php if ((set_value('anonymous') == "" && $this->input->post('idusers') == '' ) || set_value('anonymous') == "on" || set_value('anonymous') == "1") echo 'checked="checked"'; ?>> <?php echo $this->lang->line('hw_add_goal_anonymous'); ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <?php echo form_error('name'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_name'); ?> <span class="red">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>">   
                    </div>
                    <div class="form-group">
                        <?php echo form_error('description'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_describe'); ?> <span class="red">*</span></label>
                        <div class="charsRemaining small"></div>
                            <textarea maxlength="150" name="description" class="form-control left" rows="2"><?php echo set_value('description'); ?></textarea>  
                    </div>
                    <div class="form-group inline">
                        <?php echo form_error('tier1'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_t1'); ?></label>
                            <input name="tier1" class="form-control">
                        <?php echo form_error('tier2'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_t2'); ?></label>
                            <input name="tier2" class="form-control">
                        <?php echo form_error('tier3'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_t3'); ?></label>
                            <input name="tier3" class="form-control">   
                    </div>
                    <div class="form-group">
                        <?php echo form_error('progress'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_progress'); ?> <span class="red">*</span></label>
                        <div class="charsRemaining small"></div>
                            <textarea maxlength="150" name="progress" class="form-control left" rows="2"><?php echo set_value('progress'); ?></textarea>
                    </div>
                    <div class="form-group">
                        <?php echo form_error('benefit'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_benefit'); ?></label>
                        <div class="charsRemaining small"></div>
                            <textarea maxlength="150" name="benefit" class="form-control left" rows="2"><?php echo set_value('benefit'); ?></textarea>
                    </div>
                    <div class="form-group">
                        <?php echo form_error('prove'); ?>
                        <label><?php echo $this->lang->line('hw_add_goal_prove'); ?></label>
                        <div class="charsRemaining small"></div>
                            <textarea maxlength="150" name="prove" class="form-control left" rows="2"><?php echo set_value('prove'); ?></textarea>
                    </div>
                    <div class="form-group row">
                        <?php echo form_error('start_date'); ?>
                        <?php echo form_error('end_date'); ?>
                        <div class="col-xs-12 col-sm-5">
                            <span class="inline pull-left" style="margin-top: 12px;"><?php echo $this->lang->line('hw_add_goal_start'); ?> <span class="red">*</span></span>
                           <div class="btn btn-group">
                               <input id="start_date" style="width: 85px;" type="text" class="btn btn-boa date noactive last" name="start_date" value="<?php echo set_value('start_date'); ?>" />
                           </div>
                        </div>
                         <div class="col-xs-12 col-sm-5">
                            <span class="inline pull-left" style="margin-top: 12px;"><?php echo $this->lang->line('hw_add_goal_end'); ?> <span class="red">*</span></span>
                           <div class="btn btn-group">
                               <input id="end_date" style="width: 85px;" type="text" class="btn btn-boa date noactive last" name="end_date" value="<?php echo set_value('end_date'); ?>" />
                           </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="">
                        <button type="submit" class="btn btn-block btn-boa"><?php echo $this->lang->line('hw_submit'); ?></button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>