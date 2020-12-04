# Traffic Weather Information

## Setup for local developing

```
cp variables-example.php variables.php
```

Fill in your API key from open weather map and from Trafiklab.se

## Deployment on heroku

To deploy on heroku, make sure you have an account and an app.

Follow the directions [here](https://dashboard.heroku.com/new-app). You first have to login:

```
heroku login
```

You deploy the code to heroku when you push to the master or main branch on the heroku origin, e.g.

```
git push heroku master
```

You can set environment variables from the dashboard for the app under "Settings".
Or you can use the command line tool:

```
heroku config:set LIVE=TRUE
heroku config:set RESROBOT_STT2_API_KEY=ABC123
heroku config:set OPEN_WEATHER_MAP_API_KEY=ABC123
```
