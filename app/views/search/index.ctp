<form method="get">
<input type="text" name="q">
<input type="submit" value="Search">
</form>
<?php if (empty($eventGroups)) {
	echo "Nothing matched";
} else {
?> 
<table border="1">
<tr>
<td>name</td><td>description</td>
</tr>
<?php foreach ($eventGroups as $eventGroup) {?>
<tr>
		<td>
			<?php echo $html->link($eventGroup['EventGroup']['name'], "/".$eventGroup['EventGroup']['path']); ?>
		</td>
		<td>
			<?php echo $eventGroup['EventGroup']['description']; ?>
		</td>
</tr>
<?php }?>
</table>
<?php }?>