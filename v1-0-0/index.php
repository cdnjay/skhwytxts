<?php

// Get the XML file
$feed = simplexml_load_file('changeme.xml');

function checkstatus() {
	// Database details
	$con=mysqli_connect("127.0.0.1","username","password","database");
	
	// Check connection
	if (mysqli_connect_errno($con))
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	
	// Connect to database and get the current row value
	$result = mysqli_query($con,"SELECT `status` FROM `hwy`");
	
	// Set the row value and return it
	while($row = mysqli_fetch_array($result))
	  {
	  $status = $row['status'];
	  return $status;
	  }
	
	mysqli_close($con);
}

function updatestatus($num) {
	// Database details
	$con=mysqli_connect("127.0.0.1","username","password","database");
	
	// Check connection
	if (mysqli_connect_errno($con))
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	
	// Connect to database and update the row value
	$result = mysqli_query($con,"UPDATE `hwy` SET status=$num WHERE pID=1");
	
	mysqli_close($con);
}

// Pull the first entry node from the array
foreach ($feed->{'entry'}[0]->{'content'}->children('xhtml', true)->{'div'}->{'div'} as $conditions) {
	// Pull the first 4 characters of the condition and find a match
	$current = substr($conditions,0,4);
	switch ($current) {
		case "Trav":
			if (checkstatus() == 0) {
				// Tell User
				shell_exec('/usr/bin/curl -X POST https://api.twilio.com/2010-04-01/Accounts/{AccountSid}/SMS/Messages -d "To=+1306#######" -d "From=+1306#######" -d "Body=Hwy Travel Not Recommended" -u {AccountSid}:{AuthToken}');
				// Update database row
				updatestatus(1);
			}
			break;
		case "Road":
			if (checkstatus() == 0) {
				// Tell User
				shell_exec('/usr/bin/curl -X POST https://api.twilio.com/2010-04-01/Accounts/{AccountSid}/SMS/Messages -d "To=+1306#######" -d "From=+1306#######" -d "Body=Hwy Closed" -u {AccountSid}:{AuthToken}');
				// Update database row
				updatestatus(1);
			}
			break;
		default:
			if (checkstatus() == 1) {
				// Tell User
				shell_exec('/usr/bin/curl -X POST https://api.twilio.com/2010-04-01/Accounts/{AccountSid}/SMS/Messages -d "To=+1306#######" -d "From=+1306#######" -d "Body=Hwy Normal" -u {AccountSid}:{AuthToken}');
				// Update database row
				updatestatus(0);
			}			
	}
// Prevent looping to next entry node in array
break; }

?>