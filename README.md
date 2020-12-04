# Traffic Weather Information

## Setup for local developing

```
cp variables-example.php variables.php
```

Fill in your API key from open weather map.

## Deployment on heroku

To deploy on heroku, make sure ypu

```
heroku login
heroku config:set LIVE=TRUE
heroku config:set RESROBOT_STT2_API_KEY=ABC123
heroku config:set OPEN_WEATHER_MAP_API_KEY=ABC123
```
