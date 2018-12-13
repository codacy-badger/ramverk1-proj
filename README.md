# Ramverk1 Examination Project

[![Build Status](https://travis-ci.org/mabn17/ramverk1-proj.svg?branch=master)](https://travis-ci.org/mabn17/ramverk1-proj) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mabn17/ramverk1-proj/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mabn17/ramverk1-proj/?branch=master)

This is my own version of a stackoverflow ish webbsite where the main focus is forum posts, user login/registration and comments. Check the links below for more information, note that the information is in swedish (same as the target audience).

Repo for the [examination project](https://dbwebb.se/kurser/ramverk1-v2/kmom10) in course Ramverk1 @ [BTH](https://www.bth.se/eng/), dbwebb.

*Webpage is built in the [anax](https://github.com/canax) framework*

## Install and setup your own copy
First clone the repo you can use the following command: ```git clone git@github.com:mabn17/ramverk1-proj.git```

### Update pagages and install tools
Make sure you have the latest versions: ```composer update```

Run ```make install``` to get the nessecary tools.

### Set up the database
The database is witten in **MySQL** to set it up run the following command while in the root directory: 
```mysql -u{root user} -p{your password} < sql/ddl/proj_mysql.sql```

Then change the configuration file name from `config/database_sample.php` to `config/database.php` and change the values as you see fit.