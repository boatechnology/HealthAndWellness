<script src="<?php echo base_url('/assets/js/jquery-1.11.3.js'); ?>"></script>
<script src="<?php echo base_url('/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/pickadate/picker.js'); ?>"></script>
<script src="<?php echo base_url('/assets/pickadate/picker.date.js'); ?>"></script>
<script src="<?php echo base_url('/assets/pickadate/legacy.js'); ?>"></script>
<script src="<?php echo base_url('/assets/js/spin.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/js/ladda.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/bootstrap3-editable/js/bootstrap-editable.js'); ?>"></script>
<?php if (isset($jsFile)) {
    foreach ($jsFile as $key => $value) { ?>
        <script type="text/javascript" src="<?php echo base_url("/assets/js/$value"); ?>.js"></script>
<?php }
   } ?> 
<?php if (isset($jsVar)) { ?>
<script type="text/javascript"><?php
    echo "\n";
    foreach ($jsVar as $key=>$value) { ?>
        var <?php echo $key; ?> = <?php echo $value; ?>;
    <?php } ?>
 </script>
 <?php }?>
 <?php
 // admins get wider date range
 if ($this->session->userdata('isadmin') != '1') {
    $date_str = $this->config->item('hw_max_date').date("/Y");
    $maxdate = "new Date(Date.parse('".date('D M d Y H:i:s O',strtotime($date_str))."'))";
    $mindate = "new Date(Date.parse('".date('D M d Y H:i:s O',strtotime("-".$this->config->item('hw_date_past_days')." days"))."'))";
 }else{
    $mindate = 'false';
    $maxdate = 'false';
 }
 ?>
 <script type="text/javascript"> 
    var hw = {};
    var mindate = <?php echo $mindate; ?>;
    var maxdate = <?php echo $maxdate; ?>;
    
    hw.lang = <?php echo json_encode($this->lang->language)?>;
 </script>