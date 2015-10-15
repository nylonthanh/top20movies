# top20movies

Purpose of this app is to show the top 20 movies of 2015 by revenue, where 1 is the highest grossing movie.

About the app:

This was written to pull from the cache file for the data. The data is updated via a cron (/cron). The app was designed
using Grunt to minimize the CSS and Javascript files, PHP for the backend, Twig for the templating engine, JQuery for
DOM manipulation, and Bootstrap for the basic HTML framework and UI. If caching is unavailable, it will be slow to
initially load but all resources are loaded.

I found the themoviedb.org API to be slow, so doing an AJAX call when you click on a movie to see its details was
cumbersome and a bad UI experience.


In order to run this,

1) you will need to update the /App/config.php with appropriate API keys, email, etc.

2) run a php capable web server

3) open /index.php

4) create a cron job to execute cron/update_movie_details.php once a day or to your preference,

5) adjust the /App/CACHE_TIME appropriately, otherwise you'll be waiting a long time to retrieve and process the data


To create a cron in Linux:

run:

  crontab -e

add:

  MAILTO="youremail@asdf.org"
  01 03 * * * /usr/bin/php /cron/update_movie_details.php

  this will run at 3:01AM every day


  http://www.cyberciti.biz/faq/how-do-i-add-jobs-to-cron-under-linux-or-unix-oses/
  http://stackoverflow.com/questions/14157827/run-a-php-script-with-cron-in-mac
