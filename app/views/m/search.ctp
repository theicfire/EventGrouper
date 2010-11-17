<form name="filter" id="filter" method="GET" action="<?php echo $html->url("/mob/view/".$id); ?>">
<div>Keywords: <input type="text" name="search" id="search"></div>
<div>Time Start: <input type="text" name="time_start" id="time_start"></div>
<div>Date Start: <input type="text" name="date_start" id="date_start"></div>
<input type="submit" value="go!">
</form>