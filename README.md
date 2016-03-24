# G2A price alert
![Screenshot](screenshot.png)

## Features
- sends you notification emails when a game is available for a specific price or cheaper with informations about the seller (after sending that email the alert for this game is disabled and can be enabled again from the overview page)
- overview website for adding and deleting games

## Requirements
- PHP
- a webserver
- a way to execute a script regularly (like cron or runwhen)

## Setup
1. Change the config in `config.php` according to your needs.
2. Create a cronjob or something similar to execute `notifications_check.php` e.g. every day.
3. Enjoy!

## Powered by
g2a API, [REST Countries](https://restcountries.eu), [Bootstrap](http://getbootstrap.com)

----
This software is not in any way affiliated with g2a.com.  
Author: lx4r <https://l3r.de>

If you have a question regarding g2a-price-alert or if you want to give me feedback about my code please don't hesitate to contact me [via Twitter](https://twitter.com/lx4r) or [in some other way](https://l3r.de/en/contact).

The code of this project is 100% biodegradable and was written on happy keyboards.