Getting started:
==============

Software to download:
--------------------

Google app engine SDK
https://developers.google.com/appengine/docs/php/gettingstarted/installing
This will allow you to run the app in a local environment with minimal setup. 

After you clone the repo, you can simply drag/drop it into the SDK and launch a copy of the site locally.

Note: When you do this, you won’t be able to reach the database. Here is how to fix that (and if you have alternative methods, please let me know).

1. Install the MySQL server http://dev.mysql.com/downloads/mysql/5.6.html

2. If you don't have it already, get mySQL workbench http://dev.mysql.com/downloads/tools/workbench/

3. Set up a local instance of the DB which can be found in the root of the repo (DB_schma.sql). Note, that DB has no user information in it, you may need to set up a test user account manually.  For me, I created a new local DB and imported the information from DB_Schma.sql to get started. I did all of this through mysQL workbench.

4. Comment out line 74 in webapp/protected/config/main.php and uncomment line# 76. 
Note: after your final commit, please revert this so I can push the code to the server without any issue.

That’s it, you now have a local copy of the program to edit. 
Before pushing your final commit, please make sure it works locally. 

Notes for those trying to use curl. 
---------------------------------
GAE doesn't allow curl on their servers, instead you can use URLfetch. See more information here
https://developers.google.com/appengine/docs/php/urlfetch/


When you are done with your project
----------------
1. Review it locally and make sure it works. 
2. Make sure your codebase is up to date, I've had a lot of conflicts and it takes time to fix them. 
3. Push the code to github 
3. In trello, move your project from "doing" to "Pending review"
4. Choose a new project to start working on, assign it to yourself, and move it to "doing"

Live version: 
-------------
To login to stirplate.io, use the following info:
http://1.stirplateio.appspot.com/
userid: delme1@omnisci.org
password: t3h1s1saw3som

