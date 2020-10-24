# Instalación y despliegue en Heroku

## Requisitos:
- Laravel 8.X - https://laravel.com/docs/8.x
- php >= 7.3
- NodeJs >= 10
- Heroku CLI - https://devcenter.heroku.com/articles/heroku-cli#download-and-install
- Tener una cuenta en Heroku 

## Instalación y despliegue
- Clonar el repositorio https://github.com/jeison130/academy-laravel

- Crear un proyecto de heroku con el siguiente comando

```
heroku create
```

- Inicie sesión con su cuenta de Heroku

- Configurar variables de entorno

```
heroku config:set APP_KEY=base64:Lt2TyyFFTHSAszCMvUoARvZNx1rWsWAl6kqjofNP4mU
heroku config:set DB_CONNECTION=mysql
heroku config:set DB_HOST=dudo-dev.cdn4kfcmb4bl.us-east-2.rds.amazonaws.com
heroku config:set DB_PORT=3306
heroku config:set DB_DATABASE=academy
heroku config:set DB_USERNAME=admin
heroku config:set DB_PASSWORD=uNvPQXBDvQMTMZc9
```

- Desplegar la aplicación

```
git push heroku HEAD:master
```

- Verigicar la url de despliegue para probar el funcionamiento de la aplicación.
