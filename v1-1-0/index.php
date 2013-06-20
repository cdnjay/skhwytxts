<?php

// Get the XML file
$feed = simplexml_load_file('changeme.xml');

// Database details
$con=mysqli_connect("127.0.0.1","username","password","database");

function checkstatus() {	
	// Connect to database and get the current row value
	$result = mysqli_query($GLOBALS['con'],"SELECT `status` FROM `hwy`");
	
	// Set the row value and return it
	while($row = mysqli_fetch_array($result))
	  {
	  $status = $row['status'];
	  return $status;
	  }
	
	mysqli_close($GLOBALS['con']);
}

function updatestatus($num) {
	// Connect to database and update the row value
	$result = mysqli_query($GLOBALS['con'],"UPDATE `hwy` SET status=$num WHERE pID=1");
	
	mysqli_close($GLOBALS['con']);
}

require "Services/Twilio.php";
     
    // Set your Twilio AccountSid and AuthToken here
    $AccountSid = "{AccountSid}";
    $AuthToken = "{AuthToken}";
 
    // Instantiate a new Twilio Rest Client
    $client = new Services_Twilio($AccountSid, $AuthToken);
 
    // Your Twilio Number or Outgoing Caller ID
    $from = '##########';
 
    // Make an associative array with a phone number and a name.
    $people = array(
        "##########" => "user1",
        "##########" => "user2",
        "##########" => "user3",
    );

// Pull the first entry node from the xml array
foreach ($feed->{'entry'}->{'content'}->children('xhtml', true)->{'div'}->{'div'} as $conditions) {
	// Pull the first 4 characters of the condition and find a match
	$current = substr($conditions,0,4);
	switch ($current) {
		case "Trav":
			if ((checkstatus() == 0) || (checkstatus() == 2)) {
				// Iterate over everyone in the $people array. $to is the phone number, $name is the user's name
			    foreach ($people as $to => $name) {
			        // Send a new outgoing SMS
			        $body = "Hi $name, the status of your segment of SK Hwy has changed to Travel Not Recommended. I'll let you know when it's safe to travel again.";
			        $client->account->sms_messages->create($from, $to, $body);
			    }
				// Update database row
				updatestatus(1);
			}
			break;
		case "Road":
			if ((checkstatus() == 0) || (checkstatus() == 1)) {
				// Iterate over everyone in the $people array. $to is the phone number, $name is the user's name
			    foreach ($people as $to => $name) {
			        // Send a new outgoing SMS
			        $body = "Hi $name, your segment of SK Hwy is now closed. I'll let you know when it's safe to travel again.";
			        $client->account->sms_messages->create($from, $to, $body);
			    }
				// Update database row
				updatestatus(2);
			}
			break;
		default:
			if ((checkstatus() == 1) || (checkstatus() == 2)) {
				// Iterate over everyone in the $people array. $to is the phone number, $name is the user's name
			    foreach ($people as $to => $name) {
			        // Send a new outgoing SMS
			        $body = "Hi $name, your segment of SK Hwy is now safe to travel on again.";
			        $client->account->sms_messages->create($from, $to, $body);
			    }
				// Update database row
				updatestatus(0);
			}			
	}
// Prevent looping to next entry node in array
break; }

?>