<?php echo $html->css('forms', 'stylesheet', array('media'=>'all' ), false); ?>
<?php echo $html->css('admin_style', 'stylesheet', array('media'=>'all' ), false); ?>
<?php $javascript->link('jqueryui/jquery-ui-1.8.5.custom.min.js', false); ?>
<script type="text/javascript">
$(document).ready( function()
{
	$(".make_button").button();
	
	$(".date_input").datepicker({ dateFormat: 'yy-mm-dd' });
	
});

</script>
    <div id="personal_id" class="info_box">
    
    	<div class="left"><p><img src="<?php echo $html->url('/'); ?>css/rinoa/lock.png" class="<?php echo $html->url('/'); ?>css/rinoa_small_inline" /> You are logged in as <span id="main_email"><?=$session->read('username')?></span>.</p></div>
        <div class="right"><p>
        
        <a href="#" class="make_button">Exit admin panel</a> <a href="#" class="make_button">Edit account</a> <a href="#" class="make_button">Log out</a> 
        
        </p>
        
        
        </div>
        <div class="clear"></div>
    </div>