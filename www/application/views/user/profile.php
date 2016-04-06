<div class="container-fluid">
    <div class="row-fluid">
        <div class="box centering col-sm-8 col-md-6 col-lg-5">
        <h3 class="section-title"><?php echo $this->session->userdata('cn') ?> profile</h3>
        <?php echo form_open('user/profile',array('class'=>'form form-horizontal')); ?>
            <input type="hidden" name="idusers" value="<?php echo $this->session->userdata('idusers'); ?>">
            <div class='form-group'>
                <label><?php echo $this->lang->line('hw_profile_name'); ?> </label>
                <?php echo form_error('cn'); ?>
                <input name="cn" class="form-control" value="<?php echo $this->session->userdata('cn'); ?>">
            </div>
            <div class='form-group'>
                <label><?php echo $this->lang->line('hw_profile_email'); ?> </label>
                <?php echo form_error('email'); ?>
                    <input name="email" class="form-control" value="<?php echo $this->session->userdata('email'); ?>">
            </div>
            <div class="form-group">
                <label><?php echo $this->lang->line('hw_profile_public'); ?> </label>
                <p class="" style=""><?php echo $this->lang->line('hw_profile_public_explanation'); ?> </p>
                <div class="btn btn-group " data-toggle="buttons">
                    <label class="btn btn-boa <?php if ($this->session->userdata('ispublic') == '1') echo "active"; ?>">
                       <input type="radio" id="inprogress" name="ispublic" value="1" <?php if ($this->session->userdata('ispublic') == '1') echo "checked='checked'"; ?>/>
                       <?php echo $this->lang->line('hw_yes'); ?>
                    </label>
                    <label class="btn btn-boa <?php if ($this->session->userdata('ispublic') == '0') echo "active"; ?>">
                       <input type="radio" id="achieved" name="ispublic" value="0"  <?php if ($this->session->userdata('ispublic') == '0') echo "checked='checked'"; ?>/>
                       <?php echo $this->lang->line('hw_no'); ?>
                    </label>
                </div>
            </div>
            <button class="btn btn-lg btn-boa btn-block" type="submit"><?php echo $this->lang->line('hw_nav_submit'); ?></button>
        </form>
        </div>
        <div  class="box centering col-sm-8 col-md-6 col-lg-5" >
            <div id="profile-column" ></div>
        </div>
    </div>
</div>