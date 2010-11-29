<?php
class PermissionsController extends AppController {

	var $name = 'Permissions';
	var $uses = array('EventGroup', 'User', 'UserAlias', 'Event');
	var $helpers = array('Html', 'Form', 'Javascript', 'Navigation', 'Access');
	var $components = array('Acl', 'MyAcl', 'Email');

	function view($groupId) {
		//check permissions
		//from now on, assume userid is set
		$this->MyAcl->runcheck('EventGroup',$groupId,'editperms');
		$currentGroup = $this->EventGroup->findById($groupId);
		$hasAlias = false;
		$unregistered = false;
		if (!empty($this->data)) {//adding a user
			$userRow = $this->User->findByEmail($this->data['email']);
			if (!empty($userRow) && $this->MyAcl->checkUser('EventGroup',$groupId,$userRow['User']['id'], 'create'))
				$this->Session->setFlash("This user already has permissions to this group");
			else {
				if (empty($userRow)) {
					$aliasRow = $this->UserAlias->findByAlias($this->data['email']);
					if (!empty($aliasRow)) {
						$userRow['User'] = $aliasRow['User'];
						$hasAlias = true;
					} else {
						echo "in here";
						//add this user to the database and email the user about it
						$this->User->create();
						$userData = array('email' => $this->data['email'], 'pass' => 'unregistered');
						$this->User->set($userData);
						$this->User->save();
						$userRow = $this->User->findById($this->User->getLastInsertId());
						$unregistered = true;
						
						$aroArr = array(
							'model' => 'User',
							'foreign_key' => $userRow['User']['id'],
							'parent_id' => 1//This is the designated guest id in aros
						);
						$this->Acl->Aro->create();
						$this->Acl->Aro->save($aroArr);
					}
				} 
				
				//add permissions
				$this->Acl->allow(array('model' => 'User', 'foreign_key' => $userRow['User']['id']), array('model' => 'EventGroup', 'foreign_key' => $groupId), 'create');
				if ($unregistered) {
					$alertText = "This user has not registered yet. He/she will be sent an email to sign up.";
					$emailText = sprintf("You have been granted permissions to %s. Go here to sign up: %s",
					FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path'],
					FULL_BASE_URL.$this->webroot."users/add/".$userRow['User']['id']);
				}
				elseif ($hasAlias) {
					$alertText = $userRow['User']['email']."(".$this->data['email'].") added";
					$emailText = sprintf("You have been granted permissions to %s.",
					FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path']);
				}
				else {
					$alertText = $userRow['User']['email']." added";
					$emailText = sprintf("You have been granted permissions to %s.",
					FULL_BASE_URL.$this->webroot.$currentGroup['EventGroup']['path']);
				}
				$this->Session->setFlash($alertText);
				
				echo $emailText;
				$this->Email->from    = 'RushRabbit <noreply@rushrabbit.com>';
				$this->Email->to      = sprintf('%s <%s>', $userRow['User']['email'], $userRow['User']['email']);
				$this->Email->subject = 'You\'ve been granted permissions on RushRabbit';
				$this->Email->send($emailText);
			}
						
			
		
		}
		$userPerms = $this->EventGroup->getAllPermissions($groupId, $this->Session->read('userid'));
		$currentEventGroup = $this->EventGroup->findById($groupId);
		$this->set(compact('userPerms', 'groupId', 'groupPath', 'currentEventGroup'));
		$this->set('isAdmin', true);
	}

	function delete($groupId, $aroId = null) {
		$this->autoRender = false;
		if (!$aroId) {
			$this->Session->setFlash(__('Invalid id for Permissions', true));
			$this->redirect(array('action'=>'index'));
		} else {
			$children = $this->EventGroup->getAllEventGroupsUnderThis($groupId);
			$query = "SELECT aros_acos.id FROM aros_acos LEFT JOIN (acos, event_groups) ON (aros_acos.aco_id = acos.id AND acos.foreign_key = event_groups.id) 
			WHERE acos.model = 'EventGroup' AND aros_acos.aro_id = ".$aroId." AND event_groups.id IN (".implode(",",$children).")";
			$idsToDelete = $this->Acl->Aco->query($query);
			foreach ($idsToDelete as $id) {
				$this->Acl->Aco->query("DELETE FROM aros_acos WHERE id = ".$id['aros_acos']['id']);
			}
			
			
			$this->Session->setFlash(__('Permission deleted', true));
			
			$newGroup = $this->EventGroup->findById($groupId);
			$this->redirect("/event_groups/view_admin/".$newGroup['EventGroup']['path']);
		}
		
	}
	
	
	function trash() {
		$this->autoRender = false;
		$content = 
		<<<EOT
<tr>

<td>12:00am-2:00am</td>
<td>F</td>
<td>Midnight Munchies at Zeta Psi</td>
<td>Zeta Psi, 233 Massachusetts Ave., Cambridge</td>
<td>After a long night come relax then with cool drinks and fried food, prepared by the Brothers of Zeta Psi.</td>
</tr>
<tr>
<td>12:00am-3:00am</td>
<td>D</td>
<td>Movie Night</td>

<td>Ashdown House (NW35)</td>
<td>Join us for a night of movies and enjoy some snacks and refreshments.</td>
</tr>
<tr>
<td>12:00am-4:30am</td>
<td>D</td>
<td>Movie Night: Transformers I and II</td>
<td>Next House (W71), 3rd floor</td>
<td>Come watch at Next House - robots in disguise!</td>
</tr>

<tr>
<td>12:00am-6:00am</td>
<td>D</td>
<td>Aliens and/or Predators Movie Marathon</td>
<td>Burton-Conner House (W51), TV Lounge</td>
<td>GET TO BURTON-CONNAH! DO IT NOW! It'll be chest-burstingly fun!</td>
</tr>
<tr>
<td>12:17am</td>
<td>D</td>

<td>Midnight Nerf Wars</td>
<td>Random Hall (NW61)</td>
<td>It's too early to sleep! Come shoot other prefrosh with foam darts instead!</td>
</tr>
<tr>
<td>2:00am-4:00am</td>
<td>F</td>
<td>After Party</td>
<td>Phi Sigma Kappa, 487 Commonwealth Ave., Boston</td>
<td>It's late, but you can sleep on the way home. Come grab some food, hang out or watch a movie. 3rd stop on Saferide Boston East.</td>

</tr>
<tr>
<td>2:17am</td>
<td>D</td>
<td>Duct Tape Construction</td>
<td>Random Hall (NW61)</td>
<td>Come make things out of one of the most awesome materials known to man! (and save the world)</td>
</tr>
<tr>
<td>7:00am-10:00am</td>
<td>D</td>

<td>The Last Breakfast</td>
<td>Burton-Conner House (W51), TV Lounge</td>
<td>Wake up in the mornin' feelin' like you're in college. Our events were pretty awesome, this you have to acknowledge. Before you leave, brush your teeth with a sugary snack, 'cuz though you're leavin' right now, you'll be comin' back.</td>
</tr>
<tr>
<td>8:00am-10:00am</td>
<td>D</td>
<td>Breakfast at New House</td>
<td>New House (W70), Arcade</td>
<td>Before Heading home, come enjoy multiple kinds of potatoes, bacon and fruit salad.</td>

</tr>
<tr>
<td>8:00am-2:00pm</td>
<td>*P</td>
<td>CPW Checkout and Evaluations</td>
<td>Student Center (W20), 2nd Floor, La Sala de Puerto Rico</td>
<td>Come say goodbye to your new friends in the admissions office, and fill out a short form to let us know what you thought of your weekend at MIT.</td>
</tr>
<tr>
<td>8:00am-2:00pm</td>
<td>SO</td>

<td>Prom Dress Rugby Tournament</td>
<td>Briggs Field (across from Simmons-W79)</td>
<td>Come cheer for your national championship winning women's rugby team as they face off against other schools: running, passing, tackling, and more...IN PROM DRESSES!</td>
</tr>
<tr>
<td>8:00am-2:00pm</td>
<td>*P</td>
<td>CPW Checkout and Evaluations</td>
<td>Student Center (W20), 2nd Floor, La Sala de Puerto Rico</td>
<td>Come say goodbye to your new friends in the admissions office, and fill out a short form to let us know what you thought of your weekend at MIT. (Returning your meal card completes your checkout.)</td>

</tr>
<tr>
<td>8:59am-11:00am</td>
<td>F</td>
<td>Breakfast of Champions II</td>
<td>Nu Delta Fraternity, 460 Beacon St., Boston</td>
<td>An epic night at Nu Delta's NDurance party calls for a rewarding breakfast. The brothers of Nu Delta welcome you and wish you a safe journey back home with this scrumptious meal. </td>
</tr>
<tr>
<td>9:00am-10:30am</td>
<td>D</td>

<td>Breakfast Tacos</td>
<td>New House (W70), House 3, La Casa Dining Room</td>
<td>Say goodbye to the La Casa family and come hungry, because you'll have your fill and want to take some of our delicious breakfast tacos with you to the airport.</td>
</tr>
<tr>
<td>9:00am-11:00am</td>
<td>D</td>
<td>Farewell Breakfast with the Sponge-Dwellers</td>
<td>Simmons Hall (W79)</td>
<td>We know that you will be sad to leave MIT, so let Simmons bid you a yummy farewell with an exquisite breakfast! After a hectic 3 days, it's also the perfect time to relax and mingle with the Sponge-dwellers!</td>

</tr>
<tr>
<td>9:00am-12:00pm</td>
<td>FP</td>
<td>Parent/Prefrosh Brunch with the Skulls</td>
<td>Phi Kappa Sigma, 530 Beacon St., Boston</td>
<td>Do you have last-minute questions about fraternity life at MIT? Want one last meal before heading home? Either way, drop by Skullhouse before leaving MIT. </td>
</tr>
<tr>
<td>9:17am</td>
<td>D</td>

<td>Zoom Schwartz Profigliano</td>
<td>Random Hall (NW61)</td>
<td>The name of the game is Zoom Schwartz Profigliano Boink Belvidere Meep-meep Quaffle Hedge Wembley Xavier Flesh Volvo Adolph Counter Chan. Would you like to play?</td>
</tr>
<tr>
<td>9:30am-10:30am</td>
<td>PGO</td>
<td>Breakfast and Church Search</td>
<td>Student Center (W20), 3rd floor, Coffeehouse Lounge</td>
<td>Looking to visit churches in Boston? Come for some free breakfast, then we'll head out at 10:30 to morning services at Park Street Church, Cambridgeport Baptist Church, Pentecostal Tabernacle, and Hope Fellowship Church. Sponsored by Campus Crusade for Christ.</td>

</tr>
<tr>
<td>9:30am-11:30am</td>
<td>PGO</td>
<td>Catholic Mass (and breakfast!)</td>
<td>MIT Chapel (W15)</td>
<td>Join the Tech Catholic Community for 9:30 Mass in the chapel. Breakfast will be served in the large dining room of Building W11 immediately afterward.</td>
</tr>
<tr>
<td>9:30am-11:30am</td>
<td>D</td>

<td>Breakfast at Next: All-American breakfast</td>
<td>Next House (W71), Dining</td>
<td>Eat breakfast at Next House and learn more about MIT dorm life! We'll have a hot breakfast featuring eggs, bacon and sausages, fruit, juice, and more! Come enjoy our free food!</td>
</tr>
<tr>
<td>9:45am-10:30am</td>
<td>PGO</td>
<td>Baptist Brunch &amp; Worship</td>
<td>Religious Activities center (W11)</td>

<td>Grab a bite of breakfast with the Baptist Student Fellowship at MIT. Learn about the MIT Christian scene and visit a few local churches with us. Enter W11, go to lower level and enter the Chaplain Suite on the right. </td>
</tr>
<tr>
<td>10:00am</td>
<td>F</td>
<td>Breakfast of Champions</td>
<td>Theta Delta Chi, 372 Memorial Dr., Cambridge</td>
<td>Bagel bagel bagel bagel bagel bagel bagel bagel bagel bagel bagel. MUFFIN! MUFFIN!</td>
</tr>
<tr>
<td>10:00am-11:45am</td>

<td>F</td>
<td>Jigsaw Puzzle</td>
<td>Epsilon Theta, 259 Saint Paul St., Brookline</td>
<td>A 1000 piece puzzle has 4^1000*1000!/4 combinations,  but only 1 right answer! Trying randomly will take you 10^3000 years. We bet a really smart MIT prefrosh can do it in 10^2000! Meet us in Lobby 7 to catch our Big Silver Van to Epsilon Theta.</td>
</tr>
<tr>
<td>10:00am-12:00pm</td>
<td>F</td>
<td>The Last Meal: Brunch at DKE</td>
<td>Delta Kappa Epsilon, 403 Memorial Dr., Cambridge</td>

<td>Don't want CPW to end? Looking to get some food before you take a plane, train, or automobile back home? Come stop by DKE and pick up some delicious brunch before leaving made by our brothers a Sunday morning tradition.</td>
</tr>
<tr>
<td>10:00am-12:00pm</td>
<td>F</td>
<td>Phi Sig Brunch</td>
<td>Phi Sigma Kappa, 487 Commonwealth Ave., Boston</td>
<td>One last meal before we see you again this fall. 3rd stop on Saferide Boston East. </td>
</tr>
<tr>
<td>10:00am-2:00pm</td>

<td>DP</td>
<td>MacGregor House Tours</td>
<td>MacGregor House (W61)</td>
<td>Come and check out our dorm. Our friendly and informative tour guides will show you around our entries and give you some insight into our house and culture.</td>
</tr>
<tr>
<td>10:06am-12:06pm</td>
<td>F</td>
<td>Breakfast at the Club</td>
<td>Number Six Club, 428 Memorial Dr., Cambridge</td>

<td>Tired of eggs and bacon? Come for a less greasy, more delicious breakfast from all corners of the world, prepared by our master Venezuelan, French, Chinese, and Greek chefs.</td>
</tr>
<tr>
<td>10:17am</td>
<td>D</td>
<td>3D Twister</td>
<td>Random Hall (NW61)</td>
<td>We wanted to do it in 4-D, but the Transdimensional Building Committee wouldn't approve. 3 Boards, 3 Dimensions, 5242880 more ways to get tangled up.</td>
</tr>
<tr>
<td>11:00am-1:00pm</td>

<td>D</td>
<td>Brunch</td>
<td>MacGregor House (W61)</td>
<td>Up already? Sounds like a good time for free food with your friends at MacGregor. Come enjoy brunch in our dining room and get a feel for one of our house's traditional study breaks.</td>
</tr>
<tr>
<td>11:00am-1:00pm</td>
<td>PO</td>
<td>Xifan Sunday</td>
<td>McCormick(W4), Country Kitchen</td>

<td>The Association of Taiwanese Students (ATS) invites prefrosh and parents to the special CPW edition of our Xifan Sundays! Join us for a home-cooked traditional Taiwanese breakfast. Chat about life at MIT while enjoying xifan on us. :)</td>
</tr>
<tr>
<td>11:06am-1:06pm</td>
<td>F</td>
<td>Wii on the Wall</td>
<td>Number Six Club, 428 Memorial Dr., Cambridge</td>
<td>Come hang out in our common spaces, and battle with your fellow prefrosh and our members for Wii game supremacy, if you dare...</td>
</tr>
<tr>
<td>11:17am</td>

<td>D</td>
<td>Almost Lunch</td>
<td>Random Hall (NW61)</td>
<td>Three days is plenty of time to pick up some good leftovers. Come and help us get rid of some.</td>
</tr>
<tr>
<td>11:45am-1:00</td>
<td>F</td>
<td>Clam Chowder Lunch</td>
<td>Epsilon Theta, 259 Saint Paul St., Brookline</td>

<td>Experience the taste of New England: clam chowder! We'll also have veggies and freshly baked bread, as well as ice cream. Vegetarian options available (veggie minestrone!). Meet us in Lobby 7 to catch our Big Silver van to ET. </td>
</tr>
<tr>
<td>12:00pm-12:30pm</td>
<td>G</td>
<td>Dhuhr Prayer </td>
<td>Religious Activities Center (W11), Musallah </td>
<td>Come pray with other MIT Muslims.</td>
</tr>
<tr>
<td>12:00pm-1:00pm</td>

<td>D</td>
<td>The Final Breakfast</td>
<td>Senior House (E2)</td>
<td>Celebrate your ultimate victory over CPW. Enjoy breakfast with senior haus.</td>
</tr>
		
EOT;
	for ($i = 0; $i < 100; $i++) {
		preg_match_all("@<tr>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*</tr>@sU", $content, $matches);
		$events = array();
		for ($i = 0; $i < count($matches[1]); $i++) {
			$times = explode("-", $matches[1][$i]);
			$timeStart = date("Y-m-d H:i:s", strtotime("11 April 2010 ".$times[0]));//important
//			print_r($times);
			if (empty($times[1]))
				$duration = 60;
			else {
				$duration = (strtotime("11 April 2010 ".$times[1]) - strtotime("11 April 2010 ".$times[0]))/60;
				if ($duration < 0)
					$duration = (strtotime("12 April 2010 ".$times[1]) - strtotime("11 April 2010 ".$times[0]))/60;
			}
			
			$insertArr = array('Event' =>
				array(
					'title' => $matches[3][$i],
					'location' => $matches[4][$i],
					'description' => $matches[5][$i],
					'event_group_id' => 101,//important
//					'time_start' => $timeStart,
					'duration' => $duration,
					'user_id' => 37,//important
					'tags' => $matches[2][$i],
					'status' => 'confirmed'
				),
				'Other' =>
				array(
					'date_start' => date('Y-m-d', strtotime($timeStart)),
					'time_start' => date('H:i:s', strtotime($timeStart)),
					'date_end' => date('Y-m-d', strtotime($timeStart)+$duration*60),
					'time_end' => date('H:i:s', strtotime($timeStart)+$duration*60)
				)
			);
			$tagList = array(
				'A' => 'Academic',
				'R' => 'Arts',
				'S' => 'Athletic',
				'T' => 'Tour',
				'C' => 'Class',
				'F' => 'fraternity, sorority, living',
				'*' => 'featured',
				'D' => 'Dormitory',
				'P' => 'Parents',
				'G' => 'Religious',
				'O' => 'Student, Oraganization',
				'M' => 'minority',
				'U' => 'UROP'
			
			);
			$tagArr = array();
			for ($j = 0; $j < strlen($insertArr['Event']['tags']); $j++) {
				$tagArr[] = $tagList[substr($insertArr['Event']['tags'], $j, 1)];
			}
			$insertArr['Event']['tags'] = implode(',', $tagArr);
//			pr($insertArr);
			$this->Event->create();
			$this->Event->save($insertArr);
			
			$eventId = $this->Event->getLastInsertId();
			$acoArr = array(
					'model' => 'Event',
					'parent_id' => 101,//important
					'foreign_key' => $eventId
				);
//			print_r($acoArr);
			$this->Acl->Aco->create();
			$this->Acl->Aco->save($acoArr);
		}
	}
//		print_r($events);
//		print_r($matches);
//		echo date("Y-m-d H:i:s", strtotime("8 April 2010 11:00pm"));
//		echo "<br>";
//		echo (strtotime("8 April 2010 11:00pm") - strtotime("8 April 2010 10:00pm"))/60;
	}

}
?>