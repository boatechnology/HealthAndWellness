# Boa Technology Inc
We created this website to facilitate our health and wellness program. And are now open sourcing it for others to use. 

The website is built using the Codeigniter and Bootstrap frameworks.

https://www.codeigniter.com/

http://getbootstrap.com/

## Website Features
The website tracks points accumulated by users through goals and activities. Every month users are challenged to meet a certain number of points. And their progress is tracked on the homepage by a consistency rating. Which is simply a ratio of how many months out of the year they have reached the point total.
Users are kept mostly anonymous and everything is tracked by a Health and Wellness number. Additionally users can completely hide their goals and activities by making their profile private.

### Administrators
The website requires one or more users to be site administrators. Administrators can see all user data regardless of profile settings. And also have the task of moderating the users of the site. 

### Goals
Goals have start and end dates and optionally allow multiple tiers to be defined.
Example Goal:
Complete the Turkey Trot 5k in my age bracket.
Tier 1: Finish first in my age group
Tier 2: Get top 5
Tier 3: Finish top 10

Site administrators are tasked with approving goals for users and assigning a point value to each goal. If the goal has tiers defined the administrators can assign a point value to each tier as well.
After a goals end date, administrators will confirm if the goal was reached and grant the user their points for that goal by marking it as completed if appropriate.

### Activities
Activities are one time tasks that are assigned a point value. Users track activities in their activity logs and accumulate points. Additional points can be earned depending on the length of the task. 
Example Activities:
* Bike to work - 10 points per mile
* Brush teeth  - 2 points per day
* Eat a Salad  - 2 points per salad
* 30 minutes of yard work  - 20 points

If a user bikes to work for 12 miles. They can record that activity on their log and enter in the total number of miles they rode as the quantity. Earning 120 points for that activity.
Activities can be limited to only 1 per day. For example if they entered brush teeth into their activity log. The quantity is limited to only 1 and cannot be changed.

Site administrators define activities for their users and can assign point values and quantity limits as they see fit. Several example activities have been included if you want to pre-populate the database with them.


# Installation
These instructions assume you have a basic understanding of configuring web servers and databases.

## Database
After creating your database and granting permissions. Execute the sql/create-db.sql to create the DB schema. If you'd like to populate the DB with example activities, execute the sql/add-activities.sql file.

## Website
Installation is identical to the standard Codeigniter instructions followed by a few additional steps. Use the www/ folder as your standard Codeigniter root directory.

### Standard installation 
http://www.codeigniter.com/userguide2/installation/index.html

### LDAP
There is no native authentication programmed into the website. Active Directory is used to authenticate users using the Auth_Ldap library found here: https://github.com/gwojtak/Auth_Ldap
Edit the www/application/config/auth_ldap.php with the appropriate settings for you AD infrastructure.

### Additional
 Edit www/application/config/wellness.php with email addresses and other settings appropriate to your installation.
 

