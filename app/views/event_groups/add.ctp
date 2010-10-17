<?php echo $javascript->link('mapstuff.js');?>
<div class="eventGroups form">
<?php echo $form->create('EventGroup');?>
	<fieldset>
 		<legend><?php __('Add EventGroup');?></legend>
	<?php
		echo $form->input('name', array('type' => 'text'));
		echo $form->input('description');
		echo $form->input('photo_url', array('type' => 'text'));
		if (empty($currenteventGroup['EventGroup']['path']))
			$path = "/";
		else
			$path = "/".$currenteventGroup['EventGroup']['path']."/";
		if ($parentId == 0)
			echo $form->input('path', array('type' => 'text', 'label' => "http://www.oursite.com".$path));
	if ($parentId == 0) {	
	?>
	Category List (1 per row)
		<textarea name="data[Other][category_list]" id="OtherCategoryList">Food
Fun</textarea>

	<?php echo $form->input('location', array('label' => 'Location Name', 'type' => 'text'));?>
	<?php }?>
	 <div>
      <div style="margin-bottom: 5px;">
        Search Map:<div>
          <input type="text" id="queryInput" style="width: 250px;"/>
          <input type="button" value="Find" onclick="doSearch()"/>
        </div>
      </div>
      <div style="float:right">
        <div id="searchwell"></div>
      </div>
      <div id="map" style="height: 350px; border: 1px solid #979797;"></div>
      

    </div>
      <input name="data[EventGroup][latitude]" type="text" id="EventLatitude" value="<?php echo $currenteventGroup['EventGroup']['latitude']?$currenteventGroup['EventGroup']['latitude']:"";?>"/>
      <input name="data[EventGroup][longitude]" type="text" id="EventLongitude" value="<?php echo $currenteventGroup['EventGroup']['longitude']?$currenteventGroup['EventGroup']['longitude']:"";?>"/>
	<input type="hidden" name="data[EventGroup][parent_id]" id="EventGroupParentId" value="<?=$parentId?>">
	<input type="hidden" name="pathstart" value="<?=$currenteventGroup['EventGroup']['path']?>">
	</fieldset>
<?php 
echo $form->end('Submit');?>

</div>

