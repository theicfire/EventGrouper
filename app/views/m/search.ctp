<div class="m_search">
	<h1><?=$currenteventGroup['EventGroup']['name'];?></h1>
	
	<h2><a href="<?php echo $html->url("/mob/view/".$id); ?>">View all events</a></h2>
	
	or 
	
	<h2>Search:</h2>
	<form name="filter" id="filter" method="GET" action="<?php echo $html->url("/mob/view/".$id); ?>">
	<table>
		<tr>
			<th>Keywords</th><td><input type="text" name="search" id="search"></td>
		</tr>
		<tr>
			<th>Time Start</th><td><select name="time_start" id="time_start">
						<option value="0">midnight</option>
						<option value="1">1:00 am</option>
						<option value="2">2:00 am</option>
						<option value="3">3:00 am</option>
						
						<option value="4">4:00 am</option>
						<option value="5">5:00 am</option>
						<option value="6">6:00 am</option>
						<option value="7">7:00 am</option>
						
						<option value="8">8:00 am</option>
						<option value="9">9:00 am</option>
						<option value="10">10:00 am</option>
						<option value="11">11:00 am</option>
						
						<option value="12">noon</option>
						<option value="13">1:00 pm</option>
						<option value="14">2:00 pm</option>
						<option value="15">3:00 pm</option>
						
						<option value="16">4:00 pm</option>
						<option value="17">5:00 pm</option>
						<option value="18">6:00 pm</option>
						<option value="19">7:00 pm</option>
						
						<option value="20">8:00 pm</option>
						<option value="21">9:00 pm</option>
						<option value="22">10:00 pm</option>
						<option value="23">11:00 pm</option>
					</select></td>
		</tr>
		<tr>
			<th>Date Start</th><td><select name="date_start" id="date_start">
						
						<option value="04/07/2010">Thursday, Apr 7, 2011</option>
						<option value="04/08/2010">Friday, Apr 8, 2011</option>
						<option value="04/09/2010">Saturday, Apr 9, 2011</option>
						<option value="04/10/2010">Sunday, Apr 10, 2011</option>
					
					</select></td>
		</tr>
	</table>
	<div style="padding: 5px;"><input type="submit" value="go!"></div>
	</form>
</div>
