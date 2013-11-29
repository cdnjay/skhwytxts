# SK Hwy Txt's

This script as developed requires an AccountSid and AuthToken for Twilio to send txt messages. You can register for a free trial here:

https://www.twilio.com/try-twilio

Version 1.1 of this script requires Twilio's PHP library. You can download it here:

https://www.twilio.com/docs/libraries

If you prefer using cURL please select version 1.0. If you're running a Linux or Mac OS cURL is probably included, if not or if you're running Windows you'll find that the latest version of the cURL executable can be downloaded here:

http://curl.haxx.se/dlwiz/

You will also need to find your highways RSS feed from Saskatchewan Highways using this tool:

http://hotline.gov.sk.ca/atom/en.html

This script was tested on Ubuntu Server 12.04 and requires a LAMP server setup. Take a look at the code for guidance on how to design your database. phpMyAdmin is a great tool for this. You can select any entry node in the RSS file with this but SK Highways only guarantees there will ever be 1 entry node per file.

I'm currently running this every 5 minutes through cron on my server. Updates in version 1.1 include using Twilio's PHP library for sending txt messages to make it easier to send updates to multiple phone numbers. It also reduces the reuse of code for connecting to the database and allows updates to be sent when transitioning between "Road Closed" and "Travel Not Recommended" statuses.

## License

I'm changing my preferred license to the MIT License. Feel free to use it or the included license as you see fit.
