This script as developed requires an AccountSid and AuthToken for Twilio to send txt messages. You can register for a free trial here:

https://www.twilio.com/try-twilio

Future versions of this script may require Twilio's PHP library. You can download it here:

https://www.twilio.com/docs/libraries

You will also need to find your highways RSS feed from Saskatchewan Highways using this tool:

http://hotline.gov.sk.ca/atom/en.html

This script was tested on Ubuntu Server 12.04 and requires a LAMP server setup. Take a look at the code for guidance on how to design your database. phpMyAdmin is a great tool for this. You can select any entry node in the RSS file with this but SK Highways only guarantees there will ever be 1 entry node per file.

When I get the chance I'll clean this up a bit, add in some more functions and variables to reduce the amount of code. I'm currently running this every 5 minutes through cron on my server.