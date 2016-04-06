<div class='container-fluid'>
    <div class="row-fluid">
        <div class="col-sm-push-4 col-lg-push-2 col-xs-12 col-sm-8 col-md-8 col-lg-10">  
            <div class='row-fluid'>
              <div class="col-lg-9">
                  <div class="box container-fluid">
                      <div class="row inline">
                          <p class="h3 pull-left "><?php echo $this->lang->line('hw_activity_log'); ?> </p>
                          <a href='<?php echo site_url('user/activities'); ?>' class="btn btn-boa">
                              <?php echo $this->lang->line('hw_add_activity'); ?>
                          </a>
                      </div>
                      <div class='onload-show row-fluid'>
                          <?php echo $activity_log_table; ?>
                      </div>
                  </div>
                  <div class="box container-fluid">
                      <div class="row inline">
                          <p class="h3 pull-left "><?php echo $this->lang->line('hw_public'); ?> <?php echo $this->lang->line('hw_nav_goals'); ?> </p>
                          <a href='<?php echo site_url('hw/add_goal'); ?>' class="btn btn-boa">
                              <?php echo $this->lang->line('hw_add_goal'); ?>
                          </a>
                      </div>
                      <div class="row">
                          <?php echo form_open('','class="horizontal-form" id="filter-form"'); ?>
                              <div class="form-group">
                                  <div class="col-xs-12 col-sm-5 col-md-5">
                                      <span class="inline pull-left" style="margin-top: 12px;"><?php echo $this->lang->line('hw_since'); ?> </span>
                                      <div class="btn btn-group">    
                                          <input id="since" style="width: 85px;" type="text" class="btn btn-boa date-unlimited noactive last" name="since" value="<?php echo $since; ?>" />
                                      </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-7 col-md-7">
                                      <span class="inline pull-left" style="margin-top: 12px;"><?php echo $this->lang->line('hw_status'); ?></span>
                                      <div class="btn btn-group " data-toggle="buttons">
                                          <label class="btn btn-boa <?php if ($status == '2') echo "active"; ?>">
                                             <input type="radio" id="inprogress" name="status" value="2" <?php if ($status == '2') echo "checked='checked'"; ?>/>
                                             <?php echo $this->lang->line('hw_approved'); ?>
                                          </label>
                                          <label class="btn btn-boa <?php if ($status == '3') echo "active"; ?>">
                                             <input type="radio" id="achieved" name="status" value="3"  <?php if ($status == '3') echo "checked='checked'"; ?>/>
                                             <?php echo $this->lang->line('hw_achieved'); ?>
                                          </label>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                      <div class="row">
                          <div class="onload-show top-spacer">
                              <?php echo $recentgoals; ?>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-3">
                  <div class="box container-fluid">
                       <div id="top-right" class="edit-me">
                           <?php echo $topright; ?>
                       </div>    
                       <div id="downloads" class="">
                           <h3 class="section-title"><?php echo $this->lang->line('hw_nav_downloads'); ?></h3>
                           <?php echo $downloads; ?>
                       </div>
                  </div>
              </div>
            </div>
        </div>
        <div class="col-sm-pull-8 col-lg-pull-10 col-xs-12 col-sm-4 col-md-4 col-lg-2">
            <div class="box " >
                <div class="row inline">
                    <p class='h3 pull-left'><?php echo $this->lang->line('hw_consistency_board'); ?></p>
                    <a class="btn btn-boa form-control" style="font-weight: normal;" href="/index.php/hw/report"><?php echo $this->lang->line('hw_consistency_chart'); ?></a>
                </div>
                <div class='top-spacer'>
                     <?php echo $consistency_board; ?>
                </div>
                
            </div>
        </div>
    </div>
</div>