<?php echo $this->Form->create('EventGroup'); ?>

<?php $top_level = true;
if (count($groupPath) > 0) { $top_level = false; } ?>

<div id="new_group" class="info_box">
    
    <script type="text/javascript" >
    
    $(document).ready( init_validation );
    
    function nospecial( value, element ){ return this.optional(element) || value.match("^[-0-9a-zA-Z_+&.!,'? ]*$");  }
    function validurl( value, element ){ return this.optional(element) || value.match("^[-0-9a-zA-Z]*$");  }
    
    jQuery.validator.addMethod("nospecial", nospecial, "Only use letters, numbers, spaces, and . , ! & + _ '");
    jQuery.validator.addMethod("validurl", validurl, "Only use letters, numbers, and dashes. (no spaces)");
    
    function init_validation(){
		var nameField = $("input[name='data[EventGroup][name]']");
		if ($("input[name='data[EventGroup][path]']").is(":visible")) {
			$("input[name='data[EventGroup][name]']").keyup( function(){
				$("input[name='data[EventGroup][path]']").val( $("input[name='data[EventGroup][name]']").val().replace( /[^A-Za-z0-9]/g, "-" ).toLowerCase() );
			});
		}
		$("#EventGroup<?=$type=='add'?'Add':'Edit'?>Form").validate({
			rules: {
				'data[EventGroup][name]': {
					required: true,
					minlength: 2,
					nospecial: true
				},
				'data[EventGroup][path]': {
					required: true,
					minlength: 2,
					validurl: true
				},
				'data[Event][location]': {
					required: false,
					nospecial: true
				},
			},
		});
	}
    
    </script>
    
    
    <h1><img src="<?php echo $html->url('/'); ?>css/rinoa/user_add.png" class="rinoa_large_inline" /> 
	<?php 
	if ( $top_level ) {
		if ($type == 'add') echo "New Gathering";
		else echo "Edit Gathering Information";
	}
	else {
		if ($type == 'add') echo "New Group for Events";
		else echo "Edit Group Information";
	}
	?>
	</h1>
    <p><?php if ( !$top_level ) echo "in ".$this->element('grouppath', array('groupStr' => $currenteventGroup['EventGroup']['path'], 'highestName' => $currenteventGroup['EventGroup']['highest_name']))?></p>
    
        <div class="form_section">
			<h2>Basic Information</h2>
        
        
			<?php echo $form->create('EventGroup');?>
			<?php echo $form->input('name', array('type' => 'text', 'class' => 'textfield'));?>
			<p class="form_tip">
			
			<?php 
				if ( $top_level ) {
					echo "This name will be displayed on the home page of the Gathering.  (for example, 'MIT Campus Preview Weekend')";
				}
				else {
					echo "This name will be displayed on the group's page, and will be used for searching. (for example, 'MIT Juggling Club')";
				}
			?>
			
			</p>
			
<!--			<label>Picture</label>-->
<!--			<input type="file" name="picture" />-->
<!--			<p class="form_tip">This image will be displayed alongside the group description on the group's page.</p>-->
        
			<?php	
				if ($parentId == 0) {
					if ($type == 'add') {
						if (empty($currenteventGroup['EventGroup']['path']))
							$path = "/";
						else
							$path = "/".$currenteventGroup['EventGroup']['path']."/";
						echo $form->input('path', array('type' => 'text', 'label' => 'Group URL', 'class' => 'textfield'));
						
						echo '<p class="form_tip">Your group will be found at <span id="group_url_update">';
						
						if($path == "/")
						{ echo "http://www.oursite.com".$path . "[Group URL]"; }
						else
						{ echo "http://www.oursite.com".$path;	}
						
						echo '</span>.  This URL should be easy to remember and type.</p>';
						?>
						
						<p class='form_explanation ui-state-highlight ui-corner-all'><span class='ui-icon ui-icon-info' style='float: left; margin-right: 5px;'></span> You will not be able to change this URL later.</p>
						
						<?php
					} else {
						echo $form->input('path', array('type' => 'hidden'));
					}
				} 
			?>
				
			<label>Description</label>
			<?php echo $form->textarea('description', array('class' => 'description_textarea'));?>      
		</div>
        
        <?php 
        if ($type == 'add') $group = $currenteventGroup;
        else $group = $this->data;
		$centerLat = $group['EventGroup']['latitude'];
		if (empty($centerLat)) $centerLat = '42.359051';
		$centerLong = $group['EventGroup']['longitude'];
		if (empty($centerLong)) $centerLong = '-71.093623';
		$hasDefault = false;
		if (!empty($group['EventGroup']['longitude']))
			$hasDefault = true;
			
		if ( $top_level )
		{
			$whichForm = "toplevel";
		}
		else
		{
			$whichForm = "subgroup";
		}
			
		echo $this->element('admin/map', array('type'=>'EventGroup', 'centerLat' => $centerLat, 'centerLong' => $centerLong, 'hasDefault' => $hasDefault, 'whichForm' => $whichForm));
		?>
        <div class="form_section">
        <h2>Save Information</h2>
        
        <?php if ($type=='add') {?><input type="hidden" name="data[EventGroup][parent_id]" id="EventGroupParentId" value="<?=$parentId?>"><?php }?>
		<?php if ($type=='add') {?><input type="hidden" name="pathstart" value="<?=$currenteventGroup['EventGroup']['path']?>"><?php }?>
		<?php if ($type == 'edit') echo $form->input('id', array('type'=>'hidden'));?>
        <?=$this->Form->button('Submit', array('type' => 'submit', 'class' => 'make_button'));?> 
<!--        <p class="form_tip">This group will be approved by the REX coordinators.</p>-->
        </div>
    
    </div>
<?php echo $this->Form->end(); ?>
