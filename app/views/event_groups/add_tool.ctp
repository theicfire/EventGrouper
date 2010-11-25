<ul id="addTool">
<li id="event-1">
	Something <a href="#" class='addSubgroup'>Add Subgroup</a>
	<ul>
		<li>
			Inside
		</li>
	</ul>
	<ul>
		<li>
			Dif
		</li>
	</ul>
</li>
</ul>

<style type="text/css">
#addTool ul {
	margin-left:5px;
}
</style>
<script type="text/javascript">
function updateJs() {
	$('.addSubgroup').unbind();
	$('.addSubgroup').click(function() {
		var groupInput = '<ul><li>sweet <a href="#" class="addSubgroup">Add Subgroup</a> <a href="#" class="addPermissions">Add Permissions</a></li></ul>';
		$(this).after(groupInput);
		updateJs();
		return false;
	});
}
$(document).ready( function(){
	updateJs();
});
</script>