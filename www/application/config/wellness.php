<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# From Email address
$config['hw_from_email'] = 'hw@example.com';
$config['hw_from_email_name'] = 'ABC Health & Wellness';

# Address to send feedback to
$config['hw_to_email'] = 'hw@example.com';

# Minimum number to generate H&W numbers from
$config['hw_num_min'] = 5005;

# Maximum number to generate H&W numbers from
$config['hw_num_max'] = 5995;

# Monthly consistency point total goal
$config['hw_consistency_goal'] = 500;

# Last day of year goals/activities can be entered by non admins.  month/day format
$config['hw_max_date'] = "11/30";

# Number of days into past non admins can select for activities and goals.
$config['hw_date_past_days'] = '14';

?>
