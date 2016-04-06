<div class="container-fluid">
    <div class="row-fluid ">
        <div class="box centering text-center col-xs-10 col-sm-5 col-md-4 col-lg-3" style="min-width: 220px; margin-top: 3em;">
            <?php echo form_open(); ?>              
                <h2 class=""><?php echo $this->lang->line('hw_sign_in'); ?></h2>
                <?php echo $login_error; ?>
              <div class='form-group'>
                <input type="text" class="form-control" name='username' value="<?php echo set_value('username'); ?>" placeholder="<?php echo $this->lang->line('hw_username'); ?>" required autofocus>
                <input type="password" class="form-control" name='password' placeholder="<?php echo $this->lang->line('hw_password'); ?>" >
              </div>
              <button class="btn btn-lg btn-boa btn-block" type="submit"><?php echo $this->lang->line('hw_nav_submit'); ?></button>
            </form>
        </div>
    </div>
</div>