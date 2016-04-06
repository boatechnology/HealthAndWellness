  <div class="modal fade" id="feedback-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('hw_footer_feedback_header'); ?></h4>
      </div>
      <div class="modal-body">
          <?php echo form_open(site_url('ajax/add_feedback'), 'class="form-horizontal" id="feedback-form"'); ?>
          <input type="hidden" value="<?php echo $this->session->userdata('cn'); ?>" name="name" />
        <div class="form-group">
            <label>
                <p class="h3"><?php echo $this->session->userdata('cn'); ?>:</p>
            </label>
            <div class="charsRemaining small"></div>
                <textarea name="feedback" class="form-control" rows="3"></textarea>
        </div>  
        <div class="form-group">
            <label>
                <input type="checkbox" name="feedbacker" /> <?php echo $this->lang->line('hw_footer_feedback_anonymous'); ?>
            </label>
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-boa" data-dismiss="modal"><?php echo $this->lang->line('hw_close'); ?></button>
        <button type="button" id="feedback-send" class="btn btn-boa"><?php echo $this->lang->line('hw_send'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  </body>
</html>