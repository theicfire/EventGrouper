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
<td>9:00am-12:00pm</td>
<td>*P</td>
<td>CPW Registration and Help Desk</td>
<td>Student Center (W20), 2nd Floor, La Sala de Puerto Rico</td>
<td><br></td>
</tr>
<tr>
<td>9:00am-12:00pm</td>
<td>DP</td>
<td>Next House Hospitality Lounge</td>

<td>Next House (W71), Lobby</td>
<td>Nothing says &quot;welcome&quot; like an endless supply of snacks, cookies, and juice! Enjoy Next House's relaxed and friendly atmosphere while basking in the glory of food. Start CPW off right - stop by Next's Hospitality Lounge!</td>
</tr>
<tr>
<td>9:00am-3:00pm</td>
<td>*</td>
<td>UROP Tours Sign-up</td>
<td>Sign up in the Student Center (W20), 2nd Floor, La Sala de Puerto Rico</td>

<td>See first-hand the accessible and cutting edge research opportunities available to MIT undergraduates! A complete list of tour descriptions will be available at registration. Tour sign-up required to participate. Limit one tour per student; first-come, first-served. For general information about the UROP program, come to the UROP discussion panel Friday, April 9th at 12pm in Kresge Auditorium (W16).</td>
</tr>
<tr>
<td>9:00am-5:00pm</td>
<td>*P</td>
<td>Financial Aid Appointments</td>
<td>Sign up in the Student Center, (W20), 2nd Floor, La Sala de Puerto Rico</td>
<td>For questions regarding aid, loans, student employment, and/or billing, please visit the Student Financial Services (SFS) desk in La Sala de Puerto Rico. General questions are answered immediately or you will be advised to schedule a 20-minute appointment. Scheduled appointments are limited and held in 11-120.</td>
</tr>
<tr>
<td>9:00am-5:00pm</td>

<td>*P</td>
<td>Parent Hospitality Lounge</td>
<td>Student Center (W20), 2nd Floor, La Sala de Puerto Rico</td>
<td>Grab a cup of coffee or tea and chat with current MIT parents as well as other parents of MIT prefrosh. Also, learn about the MIT Parents Association and the Parent Connector Network from current volunteers and staff.</td>
</tr>
<tr>
<td>9:00am-5:00pm</td>
<td>GO</td>
<td>Hillel Open House</td>
<td>Religious Activities Center (W11), Basement</td>

<td>Stop by at any time to the Hillel Office (basement of W11) to meet the Hillel Staff. While you're here, you can buy your very own MIT Hillel t-shirt (in Hebrew).</td>
</tr>
<tr>
<td>9:00am-5:00pm</td>
<td>FD</td>
<td>Chocolate City Jukebox</td>
<td>Front Steps of Student Center (W20)</td>
<td>Come join us for an opportunity to listen to hip-hop, r&amp;b, reggae, and dancehall provided by the Brothers of Chocolate City. Stop by to hang out, listen to hot music, and introduce yourself to a chill atmosphere.</td>
</tr>
<tr>

<td>9:00am-5:00pm</td>
<td>D</td>
<td>New House Welcome Lounge</td>
<td>New House (W70)</td>
<td>Come join New House as we welcome you to MIT. We will have snacks and residents around all day so stop by and say hi!</td>
</tr>
<tr>
<td>9:00am-5:00pm</td>
<td>C</td>
<td>Classes</td>

<td>Various Locations</td>
<td>Many MIT classes open their doors to prefrosh during CPW. See your registration packet for the list sorted by date, time and subject. Before sitting in on a class that is not on the list, you <strong>must</strong> receive permission from the department in advance; some classes will be holding exams or do not have space to accommodate visitors.</td>
</tr>
<tr>
<td>9:59am-12:00pm</td>
<td>PGO</td>
<td>Baptist Campus Ministry Open House</td>
<td>Religious Activities Center (W11), Community Room</td>

<td>Come grab a bite of brunch with the Baptist Chaplain, members of Baptist Campus Ministry (BCM) and Baptist Student Fellowship. Learn about the MIT Christian scene and local churches in the area.</td>
</tr>
<tr>
<td>10:00am-11:00am</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>10:30am-11:30am</td>

<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>11:00am-12:00pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>

<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>11:30am-12:30pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>11:30am-2:00pm</td>

<td>F</td>
<td>Lunch at Kappa Sigma</td>
<td>Kappa Sigma, 407 Memorial Dr., Cambridge</td>
<td>Just got to MIT? Stop by our house on campus for some lunch.</td>
</tr>
<tr>
<td>12:00pm-1:00pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>

<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>12:00pm-1:00pm</td>
<td>F</td>
<td>Lunch at DKE!</td>
<td>Delta Kappa Epsilon, 403 Memorial Dr., Cambridge</td>
<td>Tired from activities? Just hungry? Enjoy a fresh, warm meal cooked by our chef Tom and find out why his dishes like Clam Chowda were rated the best by the "Boston Globe."</td>
</tr>
<tr>
<td>12:00pm-5:00pm</td>

<td>F</td>
<td>Chillin' at the House</td>
<td>Alpha Delta Phi, 351 Massachusetts Ave., Cambridge</td>
<td>Come hang out with the brothers of Alpha Delta Phi and see how Greek life differs here at MIT than from anywhere in the world! We're across the street and to the left from Random Hall (NW61).</td>
</tr>
<tr>
<td>12:00pm-5:00pm</td>
<td>F</td>
<td>Video Games at ADP</td>
<td>Alpha Delta Phi, 351 Massachusetts Ave., Cambridge</td>

<td>Come hang out with the brothers of Alpha Delta Phi and see how Greek life differs at MIT than from anywhere in the world! Alpha Delta Phi is across the street and to the left from Random Hall (NW61).</td>
</tr>
<tr>
<td>12:30pm-1:30pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>12:59pm-3:00pm</td>

<td>F</td>
<td>Lunch</td>
<td>Student Center Steps (W20)</td>
<td>Come see how the brothers of Nu Delta make the best of a lunch break. There will be music and jokes to go around.</td>
</tr>
<tr>
<td>1:00pm</td>
<td>F</td>
<td>BBQ at TDC</td>
<td>Theta Delta Chi, 372 Memorial Dr., Cambridge</td>

<td>It's like summer, only colder!</td>
</tr>
<tr>
<td>1:00pm-2:00pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>1:00pm-2:00pm</td>

<td>AP</td>
<td>Ocean Engineering Open House</td>
<td>Room 3-270</td>
<td>Discover the exciting possibilities of course 2-OE. Learn about the curriculum and labs, plus meet our faculty that lead the field in underwater robotics, ocean modeling, ship design, acoustic sensing, ocean energy and more. 2-OE students will be answering questions about their academics and post-MIT careers.</td>
</tr>
<tr>
<td>1:00pm-4:00pm</td>
<td>D</td>
<td>HEY YOU GUYS!</td>
<td>Burton-Conner House (W51), TV Lounge</td>

<td>Come meet the dorm and its residents. Get a tour of our dorm, ask some questions about what to do this weekend, or just hang out with some cool people.</td>
</tr>
<tr>
<td>1:30pm-2:30pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>1:30pm-3:30pm</td>

<td>D</td>
<td>Back to Kindergarten</td>
<td>Next House (W71), Dining</td>
<td>Nervous about college? Relax and return to your kindergarten days, where your biggest worry was your favorite crayon breaking. Come finger paint, play with playdoh, and enjoy goldfish and juice boxes with current students and other prefrosh!</td>
</tr>
<tr>
<td>2:00pm-3:00pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>

<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>2:00pm-3:00pm</td>
<td>*DP</td>
<td>Residential Life Information Session</td>
<td>Kresge Auditorium (W16)</td>
<td>Karen Nilsson, Senior Associate Dean for Residential Life, will lead a discussion covering life in residences, residential support in the halls, activities, dining options, the freshmen housing assignment process and more. We'll equip you with the answers to your most important questions pertaining to your student's residential experience at MIT.</td>
</tr>
<tr>
<td>2:00pm-4:00pm</td>

<td>PGO</td>
<td>Cookies and Christianity</td>
<td>Religious Activities Center (W11), Christian Fellowship Lounge in Basement</td>
<td>Do you have questions about Christianity at MIT? Need information about Christian student groups and activities during CPW and next fall? Just want a place to relax and have some cookies? Drop by!</td>
</tr>
<tr>
<td>2:00pm-4:00pm</td>
<td>F</td>
<td>Rock Band!</td>
<td>Alpha Delta Phi, 351 Massachusetts Ave., Cambridge</td>

<td>Come play Rock Band at Eran Egozy's (founder of Harmonix) old house! Come play on our massive 80Ó projector screen with surround sound!</td>
</tr>
<tr>
<td>2:00pm-5:00pm</td>
<td>F</td>
<td>Academics and Life: How to Balance</td>
<td>Delta Kappa Epsilon, 403 Memorial Dr., Cambridge</td>
<td>Interested in finding out about classes, UROPs, jobs, opportunities and teams at MIT? Come ask our brothers how they balance school and sports, attend a class with us, or inquire about anything that's on your mind.</td>
</tr>
<tr>
<td>2:00pm-8:00pm</td>

<td>*</td>
<td>CPW Prefrosh Lounge</td>
<td>Student Center (W20), 3rd Floor, Coffeehouse</td>
<td>Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!</td>
</tr>
<tr>
<td>2:30pm-3:30pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>

<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>2:30pm-5:30pm</td>
<td>F</td>
<td>Grillin' on Kresge</td>
<td>Kresge BBQ Pits (behind Kresge Auditorium, W16)</td>
<td>The brothers of Beta Theta Pi are grilling on campus.  Come grab something to eat - we'll have burgers, veggie burgers, and over 20 of the hottest hot sauces.</td>
</tr>
<tr>
<td>3:00pm-4:00pm</td>

<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>3:00pm-4:00pm</td>
<td>AP</td>
<td>Opportunities for Aerospace Engineers in the Future of Space Explorations</td>
<td>Room 4-163</td>

<td>Dr. Jeffrey Hoffman, a former NASA astronaut, flew five shuttle missions and was inducted into the U.S. Astronaut Hall of Fame in 2007. Hoffman is now a Professor of the Practice in the Department of Aeronautics and Astronautics but still has close ties with NASA. Among courses taught by Prof. Hoffman is the popular project-based course, 16.00 - Introduction of Aerospace and Design, which meets in the spring and is open to freshmen. Refreshments will be served.</td>
</tr>
<tr>
<td>3:00pm-4:00pm</td>
<td>*P</td>
<td>The Urban Campus - Safety and Security</td>
<td>Kresge Auditorium (W16)</td>
<td>What does MIT do to ensure the safety of its students both on and off campus? How does MIT integrate into the urban landscape of Boston and Cambridge? John DiFava, Chief of MIT Police, and others will address these issues and answer your questions.</td>
</tr>
<tr>
<td>3:00pm-8:00pm</td>

<td>*</td>
<td>CPW Prefrosh Lounge</td>
<td>Student Center (W20), 3rd Floor, Coffeehouse</td>
<td>Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!</td>
</tr>
<tr>
<td>3:00pm-9:00pm</td>
<td>D</td>
<td>Courtyard Antics</td>
<td>East Campus Courtyard (between Buildings 62 and 64)</td>

<td>Hang out in our courtyard! Get your hair dyed, build wooden contraptions, and get classy tours of East Campus.</td>
</tr>
<tr>
<td>3:17pm</td>
<td>D</td>
<td>Truffles!</td>
<td>Random Hall (NW61)</td>
<td>Come to Random Hall and make your own delicious truffles! Dark chocolate with raspberry, milk chocolate with lemon and ginger, white chocolate with wasabi (for the brave of heart). Are your taste buds up to the challenge?</td>
</tr>
<tr>
<td>3:30pm-4:30pm</td>

<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>3:30pm-5:00pm</td>
<td>AP</td>
<td>Chemical Engineering Open House </td>
<td>Room 66-201</td>

<td>Chemical engineering is about transformation. It's about gaining fundamental knowledge about a substance, then using that knowledge to synthesize a solution to an important medical, mechanical, or societal need. MIT offers the largest chem-e program in the nation. Come tour our labs and learn from faculty &amp; students about how we're changing the world! </td>
</tr>
<tr>
<td>3:30pm-5:30pm</td>
<td>DP</td>
<td>Next House Dorm Tours</td>
<td>leaves from Next House (W71), Lobby</td>
<td>Come on a tour of one of the friendliest dorms on campus! Our eight wings all have their own subcultures, joining together to form the warm community that is Next House.</td>
</tr>

<tr>
<td>4:00pm-5:00pm</td>
<td>*TP</td>
<td>Campus Tour</td>
<td>Student Center (W20), 2nd Floor</td>
<td>Departing on the hour and the half hour from Wiesner Student Art Gallery.</td>
</tr>
<tr>
<td>4:00pm-5:00pm</td>
<td>*APM</td>

<td>Introduction to OME and Interphase</td>
<td>Room 32-155 (Stata Center, 1st Floor)</td>
<td>The staff of the Office of Minority Education (OME), along with past Interphase participants, will provide an overview of the office's programs and services, and discuss the benefits of attending the 2010 Interphase Program. Parents are encouraged to attend. </td>
</tr>
<tr>
<td>4:00pm-5:00pm</td>
<td>AP</td>
<td>Marvelous Molecules in Play</td>
<td>Room 4-370</td>
<td>A selection of live chemical reactions followed by explanation, with Dr. John Dolhun, Department of Chemistry. Includes audience participation. </td>

</tr>
<tr>
<td>4:00pm-5:00pm</td>
<td>D</td>
<td>Ashdown House Dorm Tour</td>
<td>Meet at Student Center (W20)</td>
<td>Meet at the Student Center (W20) to walk over to New Ashdown (NW35). See for yourself what life is like in the newest dorm on campus! Then come chill with us, and have your questions about MIT answered by Phoenix Group members. </td>
</tr>
<tr>
<td>4:00pm-5:00pm</td>
<td>*AP</td>

<td>Student Opportunities to Go Global</td>
<td>Room 26-100</td>
<td>This panel of administrators, faculty, and students will help you understand the range of international opportunities available to students to go global and the resources they can utilize to pursue their interests. The panel will also answer questions about specific programs, scheduling an experience abroad, safety and funding.<br></td>
</tr>
<tr>
<td>4:00pm-5:30pm</td>
<td>D</td>
<td>Ice Cream Social</td>
<td>Burton-Conner House (W51), Barbecue Pits</td>
<td>You LOVE ice cream. You cannot resist the ice cream. To resist is hopeless. Your existence is meaningless without ice cream.</td>

</tr>
<tr>
<td>4:00pm-6:00pm</td>
<td>F</td>
<td>Ultimate Frisbee</td>
<td>Kappa Sigma, 407 Memorial Dr., Cambridge</td>
<td>Come relax and play a friendly game of ultimate with the brothers and female friends of Kappa Sigma. We'll meet up at our house at 4pm and head out from there.</td>
</tr>
<tr>
<td>4:00pm-6:15pm</td>
<td>D</td>

<td>Faire La Cuisine avec La Maison Francaise!</td>
<td>New House (W70), House 6 (French House), 5th floor kitchen</td>
<td>Help La Maison Francaise prepare a scrumptious meal from scratch. Cooking at French House is always fun whether we're making pizza or coq au vin. Stick around until dinnertime, quand nous mangerons. No kitchen experience required!</td>
</tr>
<tr>
<td>4:00pm-8:00pm</td>
<td>*</td>
<td>CPW Prefrosh Lounge</td>
<td>Student Center (W20), 3rd Floor, Coffeehouse</td>
<td>Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!</td>

</tr>
<tr>
<td>4:15pm-5:15pm</td>
<td>F</td>
<td>Chainmail</td>
<td>Epsilon Theta, 259 Saint Paul St., Brookline</td>
<td>Learn how to protect yourselves and your loved ones against impending doom! Next time you find yourself in a medieval pitched battle, you'll be all set. Meet us in Lobby 7 to catch our Big Silver Van to Epsilon Theta.</td>
</tr>
<tr>
<td>4:17pm</td>
<td>D</td>

<td>Bubble Wrap Room</td>
<td>Random Hall (NW61)</td>
<td>Bubble wrap: it goes pop. We have an entire room of it. Come bounce off the walls!</td>
</tr>
<tr>
<td>4:30pm-7:30pm</td>
<td>F</td>
<td>Welcome BBQ at Alpha Epsilon Pi</td>
<td>Alpha Epsilon Pi, 155 Bay State Rd., Boston</td>
<td>Meat is what's for dinner in Back Bay Boston. Come enjoy good food, good music, great people, and a beautiful view of Cambridge and the Charles River... Call us for ride: 847-902-0863</td>

</tr>
<tr>
<td>5:00pm-6:00pm</td>
<td>RPO</td>
<td>Community Sing!</td>
<td>Lobby 10</td>
<td>Singing in the shower just not cutting it? Come sing some of the most famous and best-loved pieces from the choral tradition with the MIT Concert Choir - MIT's largest vocal performing group! Stop by for a few minutes or stay the whole time!</td>
</tr>
<tr>
<td>5:00pm-8:00pm</td>
<td>RFP</td>

<td>Dinner and Cafe Thursday</td>
<td>Alpha Delta Phi, 351 Massachusetts Ave., Cambridge</td>
<td>Come view our signature literary event: Cafe Thursday! Eat dinner with us while viewing a showcase of talent ranging from music, art, comedy, and more.</td>
</tr>
<tr>
<td>5:00pm-8:00pm</td>
<td>F</td>
<td>Chill and Grill</td>
<td>Theta Xi, 64 Bay State Rd., Boston</td>
<td>You chill, we grill. We'll be cooking up a storm on the historic Bay State Road and relaxing in and around our beautiful brownstone house. You can't miss us - we're right under the CITGO sign!</td>

</tr>
<tr>
<td>5:00pm-8:00pm</td>
<td>*</td>
<td>CPW Prefrosh Lounge</td>
<td>Student Center (W20), 3rd Floor, Coffeehouse</td>
<td>Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!</td>
</tr>
<tr>
<td>5:00pm-8:30pm</td>
<td>P</td>

<td>Featured House Dining for Parents</td>
<td>Various Locations</td>
<td>Check out MIT's house dining options in Ashdown House (NW35) - 5:30-8:30pm; Baker House (W7-100) - 5:30-8:30pm; McCormick Hall (W4-100) - 5:00-8:00pm; Next House (W71-100) - 5:30-8:30pm; and Simmons Hall (W79-100) - 5:00-8:00pm. Bring your CPW parent meal voucher (available at registration) and your meal is free!</td>
</tr>
<tr>
<td>5:15pm-7:00pm</td>
<td>F</td>
<td>Wiki Racing &amp; Dinner</td>
<td>Epsilon Theta, 259 Saint Paul St., Brookline</td>

<td>Race through cyberspace from "Bananas" to "Communism" then enjoy a delicious home-cooked meal with honey mustard chicken, spinach salad, and cherry crisp! Vegetarian options always available. Meet us in Lobby 7 to catch our Big Silver van to ET.</td>
</tr>
<tr>
<td>5:17pm-7:17pm</td>
<td>D</td>
<td>Dumpling Hylomorphism</td>
<td>Random Hall (NW61)</td>
<td>Anamorphism: the building up of a structure. Catamorphism: the consumption of a structure. Hylomorphism: both an anamorphism and a catamorphism. This event? A hylomorphism on dumplings. Come learn the basic fold, or just perform a metabolic reduction on food.</td>
</tr>
<tr>
<td>5:30pm-6:30pm</td>

<td>O</td>
<td>Global Poverty Initiative General Body Meeting</td>
<td>Room 1-150</td>
<td>Come learn about the Global Poverty Initiative at MIT and see what we do on campus, in the community, and around the world. Food will be provided, and students will be making stethoscopes out of simple materials. </td>
</tr>
<tr>
<td>5:30pm-7:00pm</td>
<td>R</td>
<td>Toons at Dinner!</td>
<td>Campus dining halls</td>

<td>Experience a cappella like never before! The MIT/Wellesley Toons, MIT's only cross-campus a cappella group, will be performing through all the campus dining halls, starting with McCormick and ending with Simmons. What could be better? Dorm food, good music, and PRIZES!</td>
</tr>
<tr>
<td>5:30pm-7:15pm</td>
<td>*M</td>
<td>Minority Student Dinner &amp; Discussion</td>
<td>Walker Memorial (50), Morss Hall</td>
<td>Enjoy great food and meet students from the African American, Latino, and Native American communities. Hear about clubs, events, and organizations with which you could be involved, as well as personal stories of life as a student of color at the Institute.</td>
</tr>

<tr>
<td>5:30pm-7:15pm</td>
<td>*PM</td>
<td>Minority Parent Reception</td>
<td>Stata Center (32), 4th Floor, The R and D</td>
<td>MIT welcomes parents to its African American, Latino, and Native American communities. You are invited to join campus administrators, faculty, current students, and parents to learn more about the campus, student resources, and support services. Guest speakers from throughout the community will share their insight and experiences.</td>
</tr>
<tr>
<td>5:30pm-7:30pm</td>
<td>D</td>

<td>NALGAS Fiesta</td>
<td>Next House Dining (W71)</td>
<td>Come spice up your day with the Next Association of Latinos Giving Alltimate Satisfaction (NALGAS)! Taste incredible hispanic food and break an authentic pinata. Throw all your cares to the wind to the sound of Latino Music and real mariachi!</td>
</tr>
<tr>
<td>5:30pm-7:30pm</td>
<td>D</td>
<td>Absorb Ice Cream Like a Sponge!</td>
<td>Simmons Hall (W79)</td>
<td>Come join the fun and create the most extravagant ice cream sundae possible with a selection of hot fudge, whipped cream, sprinkles and more - all while meeting other prefrosh and friendly Simmons residents!</td>

</tr>
<tr>
<td>5:30pm-8:00pm</td>
<td>F</td>
<td>Come Check Out the Beta House</td>
<td>Beta Theta Pi, 119 Bay State Rd., Boston</td>
<td>Check out our house, jam with some of the brothers in our stage room, play hacky sack, skateboard out in front, we like all of the above.</td>
</tr>
<tr>
<td>6:00pm-12:00am</td>
<td>RO</td>

<td>Design a page in tomorrow's issue of The Tech!</td>
<td>Room W20-483</td>
<td>Interested in writing, taking photos, or helping lay out the paper? We are devoting several pages to YOU: your content and skills! Come in and have fun, and get your work distributed across campus the next day.</td>
</tr>
<tr>
<td>6:00pm-2:00am</td>
<td>RO</td>
<td>The Tech's Open Newsroom</td>
<td>Room W20-483</td>
<td>Watch as we put together tomorrow's issue of "The Tech", featuring a special section about you, our visiting prefrosh! Find out how you can be part of it - if you stop by early enough, you might grab a byline!</td>

</tr>
<tr>
<td>6:00pm-7:00pm</td>
<td>F</td>
<td>Dinner at DKE!</td>
<td>Delta Kappa Epsilon, 403 Memorial Dr., Cambridge</td>
<td>Looking for a hearty meal after a long day of exploring campus?  Come join the brothers of DKE and enjoy a fresh, warm meal cooked by our chef Tom as we unwind after the day.</td>
</tr>
<tr>
<td>6:00pm-7:00pm</td>
<td>D</td>

<td>Baking With Pumpkins</td>
<td>New House (W70), German House (House 6), 2nd Floor</td>
<td>Here at German House, we love to bake. Our residential expert on pumpkin baking will be creating delicious combinations of cinammon, nutmeg, and ginger into cookies, brownies and cakes. Come bake or just eat!</td>
</tr>
<tr>
<td>6:00pm-7:30pm</td>
<td>F</td>
<td>Dinner</td>
<td>Zeta Beta Tau, 58 Manchester Rd., Brookline</td>
<td>Come enjoy dinner with the brothers of Zeta Beta Tau and hear brothers speak about their MIT experiences - call Rick at 617-232-3257 for a ride.</td>

</tr>
<tr>
<td>6:00pm-8:00pm</td>
<td>F</td>
<td>Gerry's World Famous Fried Chicken</td>
<td>Phi Kappa Sigma, 530 Beacon St., Boston</td>
<td>Come to Phi Kappa Sigma (Skullhouse) for chef extraordinaire Gerry Martinez's world famous delicious fried chicken, with corn and mashed potatoes. You haven't tried chicken until you've tried Gerry's fried chicken. </td>
</tr>
<tr>
<td>6:00pm-8:00pm</td>
<td>F</td>

<td>Dinner with Kappa Sigma</td>
<td>Kappa Sigma, 407 Memorial Dr., Cambridge</td>
<td>Stop by our on-campus location to grab some dinner and play some table-hockey, ping-pong and more.</td>
</tr>
<tr>
<td>6:00pm-8:00pm</td>
<td>D</td>
<td>East Campus Grilling</td>
<td>East Campus Courtyard (between Buildings 62 and 64)</td>
<td>Stuff your face with hot beef (and veggie burgers if storing dead animals is none of your stomach's business).</td>

</tr>
<tr>
<td>6:00pm-8:00pm</td>
<td>*</td>
<td>CPW Prefrosh Lounge</td>
<td>Student Center (W20), 3rd Floor, Coffeehouse</td>
<td>Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!</td>
</tr>
<tr>
<td>6:00pm-8:30pm</td>
<td>P</td>

<td>Featured House Dining for Parents</td>
<td>Various Locations</td>
<td>Check out MIT's house dining options in Ashdown House (NW35) - 5:30-8:30pm; Baker House (W7-100) - open until 8:30pm; McCormick Hall (W4-100) - open until 8:00pm; Next House (W71-100) - open until 8:30pm; and Simmons Hall (W79-100) - open until 8:00pm. Bring your CPW parent meal Voucher (available at registration) and your meal is free!</td>
</tr>
<tr>
<td>6:00pm-10:00pm</td>
<td>F</td>
<td>Chillin With Delts</td>
<td>Delta Tau Delta, 416 Beacon St., Boston</td>
<td>Come kick it at DTD. We'll be shooting pool, playing foosball, maybe some poker, and eating a dope turkey dinner.</td>

</tr>
<tr>
<td>6:00pm-10:30pm</td>
<td>D</td>
<td>Game Show Night</td>
<td>Burton-Conner House (W51), TV Lounge</td>
<td>Team up with your peers and show off your MIT knowledge in jeopardy, family feud or find your perfect match in the dating game.</td>
</tr>
<tr>
<td>6:15pm-7:15pm</td>
<td>O</td>

<td>China Care Dumpling Dinner</td>
<td>McCormick Hall (W4), Country Kitchen</td>
<td>Wanna have some dumplings? Learn more about helping orphans in China and making a difference? Or just hang out with your fellow pre-froshes? The China Care Dumpling Dinner will be a perfect event for you!!</td>
</tr>
<tr>
<td>6:15pm-7:15pm</td>
<td>D</td>
<td>Diner a La Maison Francaise</td>
<td>New House (W70), House 6 (French House), 5th floor kitchen</td>
<td>Come eat a home-cooked dinner on la maison!</td>

</tr>
<tr>
<td>6:15pm-7:30pm</td>
<td>SPO</td>
<td>Meet the Men's Ultimate Frisbee Team</td>
<td>Briggs Field (grass across from MacGregor House-W61)</td>
<td>Catch the end of our last practice before the Championship Series. Come meet the team and see what college Ultimate is all about. We'll be available after practice to answer any questions or just to toss some plastic around.</td>
</tr>
<tr>
<td>6:17pm</td>
<td>D</td>

<td>Liquid Nitrogen Ice Cream</td>
<td>Random Hall (NW61)</td>
<td>Colder than the heart of a freshman physics professor. This event has one-in-three chance of being Deep Fried Liquid Nitrogen Ice Cream in disguise!</td>
</tr>
<tr>
<td>6:30pm</td>
<td>F</td>
<td>Indian Dinner at pika</td>
<td>pika, 69 Chestnut St., Cambridge</td>
<td>Authentic. Homemade. Delicious. Vegan. Gluten Free. Meet a pikan at lobby 7 at 6:00pm to be walked over or just follow the little orange flags from Simmons to pika.</td>

</tr>
<tr>
<td>6:30pm</td>
<td>F</td>
<td>Teriyaki!</td>
<td>Theta Delta Chi, 372 Memorial Dr., Cambridge</td>
<td>Beef teriyaki for dinner! Who could want more?</td>
</tr>
<tr>
<td>7:00pm-8:00pm</td>
<td>AP</td>

<td>Biology Open House</td>
<td>Room 68-181</td>
<td>Are you a prospective course VII major? Are you thinking about a double major with VII/VIIA? Are you interested in the minor in Biology Program? Are you considering premed? Get the information you need! After 6pm, enter Bldg 68 across from the Stata Center parking lot at the door closest to Building 66.</td>
</tr>
<tr>
<td>7:00pm-8:00pm</td>
<td>F</td>
<td>Sundaes on Thursday</td>
<td>Kappa Sigma, 407 Memorial Dr., Cambridge</td>
<td>You'll be gone by Sunday, so enjoy some ice cream now. Make your perfect sundae at our top-notch sundae bar or have our distinguished sundae chef make one for you. Fun is guaranteed.</td>

</tr>
<tr>
<td>7:00pm-8:00pm</td>
<td>D</td>
<td>Dinner With German House</td>
<td>New House (W70), German House (House 6), 2nd Floor</td>
<td>What makes German House the best place to live on campus? Our delicious dinners! Come experience first-hand the great chefs living here.</td>
</tr>
<tr>
<td>7:00pm-8:00pm</td>
<td>RO</td>

<td>Meet the Musicians</td>
<td>Kresge Auditorium, Rehearsal Room B</td>
<td>Come meet the musicians of the MIT Symphony Orchestra! Find out about the music the group plays and the events we hold all year long. Mingle with fellow musicians and stay to hear us prepare for our next concert!</td>
</tr>
<tr>
<td>7:00pm-8:00pm</td>
<td>*</td>
<td>CPW Prefrosh Lounge</td>
<td>Student Center (W20), 3rd Floor, Coffeehouse</td>
<td>Looking for a place to relax between events? Have a question only an MIT student can answer? Just drop by!</td>

</tr>
<tr>
<td>7:00pm-8:15pm</td>
<td>F</td>
<td>Improv</td>
<td>Epsilon Theta, 259 Saint Paul St., Brookline</td>
<td>It's surprising how easily a group of people can entertain themselves with nothing but their wits and a stick of celery. Meet us in Lobby 7 to catch our Big Silver Van to Epsilon Theta.</td>
</tr>
<tr>
<td>7:00pm-8:30pm</td>
<td>GO</td>

<td>Super FHE</td>
<td>McCormick Hall (W4), East Penthouse</td>
<td>MIT LDS students guarantee a message, fun activity, treats, and the opportunity to meet new friends with shared values. You'll leave inspired for the official Class of 2014 Student Welcome, just as weekly Family Home Evening (FHE) inspires us.</td>
</tr>
<tr>
<td>7:00pm-8:30pm</td>
<td>P</td>
<td>Featured House Dining for Parents</td>
<td>Various Locations</td>
<td>Check out MIT's house dining options in Ashdown House (NW35) - open until 8:30pm; Baker House (W7-100) - open until 8:30pm; McCormick Hall (W4-100) - open until 8:00pm; Next House (W71-100) - open until 8:30pm; and Simmons Hall (W79-100) - open until 8:00pm. Bring your CPW parent meal Voucher (available at registration) and your meal is free!</td>

</tr>
<tr>
<td>7:00pm-9:00pm</td>
<td>F</td>
<td>Bridge Building Competition</td>
<td>Theta Delta Chi, 372 Memorial Dr., Cambridge</td>
<td>Think you have what it takes to build the best bridge? Then prove it in head-to-head competition for the grand prize! Snacks will be available.</td>
</tr>
<tr>
<td>7:00pm-9:00pm</td>
<td>D</td>

<td>International Feast </td>
<td>New House (W70), iHouse </td>
<td>Take your taste buds on an international journey around the world. Come and help us cook our multicultural dinner. Then enjoy a celebration of our meal with games, lively discussion, and huge cards.</td>
</tr>
<tr>
<td>7:00pm-9:00pm</td>
<td>O</td>
<td>Quiz Bowl!</td>
<td>Room 4-144</td>
<td>If you like books, reading, random trivia, SCIENCE!, music, and knowledge, come to practice! Old-timers and first-timers to quiz bowl welcome; we love you either way.</td>

</tr>
<tr>
<td>7:00pm-9:00pm</td>
<td>D</td>
<td>Food Event, Part I</td>
<td>Senior House (E2)</td>
<td>You're hungry. You want to eat all of our delicious foods. Come to Senior Haus, building E2. Across Ames Street and into your heart.</td>
</tr>
<tr>
<td>7:00pm-9:00pm</td>
<td>D</td>

<td>NONLINEAR CHAOS (Games Night!!!)</td>
<td>McCormick Hall (W4), East Penthouse</td>
<td>Come by for a night of karaoke, fun games, and tons of FOOD!</td>
</tr>
<tr>
<td>7:15pm-8:15pm</td>
<td>O</td>
<td>Printing Press Tour</td>
<td>Student Center (W20), 4th floor, Room W20-415</td>
<td>What does an early 1900s printing press look like and why does MIT have one? Tours of our letter press start every 15 minutes.</td>

</tr>
<tr>
<td>7:17pm</td>
<td>D</td>
<td>Juggling in Enclosed Spaces</td>
<td>Random Hall (NW61)</td>
<td>What's more fun than throwing brightly colored objects at people? Doing it at the same time as fifteen other people all packed into a small lounge. Come juggle with us! Don't know how? We're happy to teach you! </td>
</tr>
<tr>
<td>7:17pm</td>
<td>D</td>

<td>Tea and Math</td>
<td>Random Hall (NW61)</td>
<td>Drink tea, eat biscuits, and learn math! No purchase necessary.</td>
</tr>
<tr>
<td>7:30pm-8:15pm</td>
<td>F</td>
<td>Dinner at DU</td>
<td>Delta Upsilon, 526 Beacon St., Boston</td>
<td>Enjoy a dinner cooked by our very own chef. We are just across the Mass. Ave. Bridge and to the right at 526 Beacon Street (we're the house with a putting green for a front lawn).</td>

</tr>
<tr>
<td>7:30pm-8:30pm</td>
<td>F</td>
<td>pika House Tours</td>
<td>pika, 69 Chestnut St., Cambridge</td>
<td>Learn where we got the door to our upstairs bathroom and why pika is never capitalized. Guaranteed to be one of the most interesting house tours you ever take. The secret of this event is that it will happen every night of CPW.</td>
</tr>
<tr>
<td>7:30pm-8:30pm</td>
<td>F</td>

<td>Dinner at Zeta Psi</td>
<td>Zeta Psi, 233 Massachusetts Ave., Cambridge</td>
<td>Looking for a warm, home-cooked meal? Come enjoy a delicious family-style dinner prepared by the brothers of Zeta Psi.</td>
</tr>
<tr>
<td>7:30pm-8:45pm</td>
<td>*P</td>
<td>Parent Welcome</td>
<td>Room 26-100</td>
<td>Stu Schmill, Dean of Admissions and Donald Sadoway, John F. Elliott Professor of Materials Chemistry, welcome the Class of 2014 parents to Campus Preview Weekend.</td>

</tr>
<tr>
<td>8:00pm-10:00pm</td>
<td>RDPO</td>
<td>Next Act Presents &quot;Urinetown&quot;!</td>
<td>Next House (W71), Tastefully Furnished Lounge</td>
<td>Next Act presents a hilarious musical comedy about what it's like when people can't pee free! Remember, you better go before the show, because there often is a line! Tickets are FREE and will be available at the door. Also shows Fri. and Sat.</td>
</tr>
<tr>
<td>8:00pm-10:00pm</td>

<td>F</td>
<td>Analog Game Night</td>
<td>Theta Xi, 64 Bay State Rd., Boston</td>
<td>Good old-fashioned fun! Hop on Saferide and join us for a night full of board games, pool, foosball, and other things you can do without electronics, all while snacking on foods made in-house on our famous Frialator.</td>
</tr>
<tr>
<td>8:00pm-11:00pm</td>
<td>D</td>
<td>French Films</td>
<td>New House (W70), House 6 (French House), 5th floor kitchen</td>

<td>Traveling garden gnomes, a musical saw, guys who can scale tall buildings...French movies have it all!</td>
</tr>
<tr>
<td>8:15pm-9:15pm</td>
<td>F</td>
<td>Speed Games</td>
<td>Epsilon Theta, 259 Saint Paul St., Brookline</td>
<td>FallingSpeedscrabbleGalaxytruckerRicochetrobots! <br>Not your grandpa's game of chess! Meet us in Lobby 7 to catch our Big Silver Van to Epsilon Theta.</td>
</tr>
<tr>

<td>8:17pm</td>
<td>D</td>
<td>Pillow Wars</td>
<td>Random Hall (NW61)</td>
<td>Come get out some extra energy and test your skills in our pillow fight tournament.  </td>
</tr>
<tr>
<td>8:30pm-9:30pm</td>
<td>*</td>
<td>CPW Student Welcome and Prefrosh Icebreaker</td>

<td>Rockwell Cage (W33)</td>
<td>The official welcome for the Class of 2014 - this will be the first time that all of your prospective MIT classmates will be together!</td>
</tr>
<tr>
<td>9:00pm-12:00am</td>
<td>F</td>
<td>Rock Band Tournament</td>
<td>Delta Kappa Epsilon, 403 Memorial Dr., Cambridge</td>
<td>Come join the brothers of DKE as we battle it out rock band style. Food, video games, and fun are all included. Come show off your skills and you just might win a prize.</td>
</tr>

<tr>
<td>9:00pm-11:00pm</td>
<td>F</td>
<td>Indian Movie Night</td>
<td>Alpha Delta Phi, 351 Massachusetts Ave., Cambridge</td>
<td>Come watch "Diwali Dulhania Le Jayenge" with us in our own in-house theater! A great first introduction to Indian movies, and a classic for lovers of the genre.</td>
</tr>
<tr>
<td>9:30pm-12:00am</td>
<td>*</td>

<td>CPW Festival</td>
<td>Johnson Athletics Center (W34)</td>
<td>MIT students welcome you to the community. Experience what makes us unique and what MIT students do for fun.</td>
</tr>
<tr>
<td>10:00pm-12:00am</td>
<td>D</td>
<td>Chick Flick Night</td>
<td>New House (W70), House 3</td>
<td>Wondering where you can be really girly at MIT? Look no further. This is a really casual event: movies, popcorn, nail painting, hair braiding, and a chance to meet friends you can hang out with for the rest of CPW.</td>

</tr>
<tr>
<td>10:00pm-1:00am</td>
<td>F</td>
<td>Party at DU</td>
<td>Delta Upsilon, 526 Beacon St., Boston</td>
<td>Start the weekend early with a great party. Mingle with coeds from MIT and the greater Boston area - we're just across the Mass. Ave. Bridge and to the right.</td>
</tr>
<tr>
<td>10:00pm-1:00am</td>
<td>RD</td>

<td>Baker House presents HORIZON</td>
<td>Baker House (W7), Rooftop </td>
<td>Come kick off CPW with the hottest party of the evening! Enjoy the Boston skyline while dancing the night away to the beats of DJ NITE. Rising hip-hop artists E-Jeezy and MiKO will make an appearance. Refreshments will be served.</td>
</tr>
<tr>
<td>10:00pm-1:00am</td>
<td>F</td>
<td>Rock Band Showdown</td>
<td>Theta Xi, 64 Bay State Rd., Boston</td>
<td>Think you and your friends have what it takes to beat our Rock Band champions? Bring 'em all and bring it... if you can.  </td>

</tr>
<tr>
<td>10:00pm-2:00am</td>
<td>D</td>
<td>Simmons Movie Theater Mania</td>
<td>Simmons Hall (W70), Multi-purpose Room</td>
<td>Action. Comedy. Crime. Drama. Fantasy. Horror. Mystery. Romance. Sci-Fi. Thriller. Pick a genre, choose the movie and we'll play it in our movie theater on a 10-FOOT SCREEN with BOSE SURROUND SOUND! There will be plenty of popular movie snacks.</td>
</tr>
<tr>
<td>10:00pm-11:00pm</td>
<td>D</td>

<td>Molecular Gastronomy</td>
<td>New House (W70), House 6 (French House), 5th floor kitchen</td>
<td>Caviar that tastes like blueberry? Lemons (no sweeteners added) that taste like lemon candy? Chocolate mousse that disappears in your mouth, leaving only the delicious flavor behind? Come make some, eat some, and learn about the science behind these treats!</td>
</tr>
<tr>
<td>10:30pm-12:00am</td>
<td>D</td>
<td>Dessert Night: S'mores</td>
<td>Next House (W71), Courtyard</td>
<td>Join us in the Next House courtyard to toast s'mores! Come enjoy the chocolate-marshmallow-graham cracker goodness as we share some entertaining MIT tales.</td>

</tr>
<tr>
<td>10:30pm-12:00am</td>
<td>F</td>
<td>Poker Tournament</td>
<td>Lambda Chi Alpha, 99 Baystate Rd., Boston</td>
<td>Come relax and play poker at LCA for a prize. Take Boston West saferide to the 3rd stop, or call 516-503-2875 for a ride from campus.</td>
</tr>
<tr>
<td>10:30pm-12:00am</td>
<td>D</td>

<td>Ice Cream Social</td>
<td>New House (W70), House 4, 5th floor south</td>
<td>Ice Cream, Ice Cream, Ice Cream! Who could resist this deliciousness? Enjoy a night of tasty ice cream with everyone as you settle in for CPW! </td>
</tr>
<tr>
<td>10:30pm-12:00am</td>
<td>D</td>
<td>Painting, Fondue, and Star Gazing</td>
<td>Simmons Hall (W79), 4C Hallway</td>
<td>Come join us for &quot;wall&quot; painting, star gazing, and an expensive cheeses study break!</td>

</tr>
<tr>
<td>10:30pm-2:00am</td>
<td>D</td>
<td>SUGAR HIGH DANCE PARTY</td>
<td>Burton-Conner House (W51), Porter Room</td>
<td>Can you feel the bass? Come dance it up with your future classmates. We have enough sugar to power you through the rest of this crazy weekend. And did we mention glow sticks? Check out http://tinyurl.com/bc-sugarhigh for updates.</td>
</tr>
<tr>
<td>11:00pm-12:00am</td>
<td>ACO</td>

<td>FIREHOSE: Duct-Tape Mania</td>
<td>6th floor of building 24</td>
<td>Want to make a duct tape wallet? Sandals? A fire hydrant? Come make awesome things out of duct tape! Duct tape provided. PRETTY COLORS. Come hang out, eat food, and take classes until stupid late.</td>
</tr>
<tr>
<td>11:00pm-12:00am</td>
<td>ACO</td>
<td>FIREHOUSE: Burnside's Lemma</td>
<td>6th floor of building 24</td>
<td>Want to know how many ways you can paint the faces of a cube with n colors? Abstract algebra can help you--but be warned, this is not the algebra everybody did in high school! </td>

</tr>
<tr>
<td>11:00pm-12:30am</td>
<td>D</td>
<td>La Casa Study Break</td>
<td>New House (W70), House 3, Spanish House Dining Room</td>
<td>Come after the CPW festival and join us for our weekly study break Thursday night. Our study breaks consist of good food and serve as a fun break from homework and responsibilities. Make new friends and get to know the La Casa familia.</td>
</tr>
<tr>
<td>11:00pm-1:00am</td>
<td>ACO</td>

<td>FIREHOSE: Your Art Teacher LIED to You!</td>
<td>6th floor of building 24</td>
<td>Come see your art teacher's claims fall at the hand of experimental science: the science of human vision. This class is part of ESP's FIREHOSE Event! Come hang out, eat our food, and take classes until stupid late. </td>
</tr>
<tr>
<td>11:00pm-1:00am</td>
<td>D</td>
<td>Cocoa and Stories </td>
<td>East Campus (64), Fourth East</td>
<td>Come join Fourth East for an extended version of our nightly cocoa tradition. We provide the hot chocolate, dessert, and MIT stories. Meet in the East Campus courtyard by the ugly modern art.</td>

</tr>
<tr>
<td>11:00pm-2:00am</td>
<td>F</td>
<td>AEPi Cidernight</td>
<td>Alpha Epsilon Pi, 155 Bay State Rd., Boston</td>
<td>Hot apple cider, homemade banana bread, lots of other baked goodies, and some fun games make this late night event a can't-miss... 5th stop on Saferide Boston West, or call us at 847-902-0863 for a ride.</td>
</tr>
<tr>
<td>11:00pm-2:00am</td>
<td>F</td>

<td>Nightmare</td>
<td>Phi Kappa Sigma, 530 Beacon St., Boston</td>
<td>We're bringing back our favorite holiday, like Jason and Freddy from the grave. Let your inner monster loose on the dancefloor at Skullhouse. </td>
</tr>
<tr>
<td>11:00pm-3:30am</td>
<td>F</td>
<td>The 3 P's: Pizza, Poker, Pool</td>
<td>Sigma Phi Epsilon (the big red door), 518 Beacon St., Boston</td>
<td>CPW has begun: it is time to put on your poker face. Win cool MIT prizes, eat delicious pizza, and test your pool skillz. By the way, no counting cards!</td>

</tr>
<tr>
<td>11:30pm-1:00am</td>
<td>F</td>
<td>Midnight Buffet</td>
<td>Kappa Sigma, 407 Memorial Dr., Cambridge</td>
<td>Not thinking about calling it a night, were you? Drop by the Kappa Sig stoop instead for a late-night snack, some pick-up basketball or that last game of Wii Olympics.</td>
</tr>
<tr>
<td>11:30pm-2:00am</td>
<td>D</td>

<td>Room For One More</td>
<td>Senior House (E2), Third HNC</td>
<td>Watch the modern cult movie "The Room" with the residents of the Third HNC. Idolize Tommy Wisseau, and marvel at the intricate twists of the subplots.</td>
</tr>
<tr>
<td>11:45pm-2:00am</td>
<td>F</td>
<td>Movie on the Roof</td>
<td>Phi Sigma Kappa, 487 Commonwealth Ave., Boston</td>
<td>Enjoy a movie on our roof deck overlooking the heart of Kenmore Square, the famous CITGO sign, and Fenway Park. Third stop Saferide Boston East.</td>

</tr>
<tr>
<td>11:59pm</td>
<td>F</td>
<td>Late-Night Snack</td>
<td>Theta Delta Chi, 372 Memorial Dr., Cambridge</td>
<td>Got the midnight munchies? Stop by TDC for some late-night grub.</td>
</tr>
<tr>
<td>11:59pm</td>
<td>F</td>

<td>Midnight Frisbee</td>
<td>Briggs Field</td>
<td>Come join the brothers of Alpha Delta Phi and hordes of your newfound friends playing glow-in-the-dark frisbee! Meet on Briggs Field, between MacGregor (W61)and Simmons (W79).</td>
</tr>
<tr>
<td>11:59pm-2:00am</td>
<td>F</td>
<td>Midnight Snack</td>
<td>Theta Chi, 528 Beacon St., Boston</td>
<td>Come eat french toast sticks, bacon, wings, pot stickers and other tasty fried snacks with the guys at Theta Chi.</td>

</tr>
EOT;
		preg_match_all("@<tr>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*<td>(.*)</td>.*</tr>@sU", $content, $matches);
		$events = array();
		for ($i = 0; $i < count($matches[1]); $i++) {
			$times = explode("-", $matches[1][$i]);
			$timeStart = date("Y-m-d H:i:s", strtotime("8 April 2010 ".$times[0]));
//			print_r($times);
			if (empty($times[1]))
				$duration = 60;
			else {
				$duration = (strtotime("8 April 2010 ".$times[1]) - strtotime("8 April 2010 ".$times[0]))/60;
				if ($duration < 0)
					$duration = (strtotime("9 April 2010 ".$times[1]) - strtotime("8 April 2010 ".$times[0]))/60;
			}
			
			$insertArr = array('Event' =>
				array(
					'title' => $matches[3][$i],
					'location' => $matches[4][$i],
					'description' => $matches[5][$i],
					'event_group_id' => 7,
					'time_start' => $timeStart,
					'duration' => $duration,
					'user_id' => 6
				)
			);
			print_r($insertArr);
			$this->Event->create();
			$this->Event->save($insertArr);
			
			$eventId = $this->Event->getLastInsertId();
			$acoArr = array(
					'model' => 'Event',
					'parent_id' => 7,
					'foreign_key' => $eventId
				);
			print_r($acoArr);
			$this->Acl->Aco->create();
			$this->Acl->Aco->save($acoArr);
		}
//		print_r($events);
//		print_r($matches);
//		echo date("Y-m-d H:i:s", strtotime("8 April 2010 11:00pm"));
//		echo "<br>";
//		echo (strtotime("8 April 2010 11:00pm") - strtotime("8 April 2010 10:00pm"))/60;
	}

}
?>