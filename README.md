notes
---
### start a development server

1. make sure you have composer and npm installed
```
$ composer install
$ npm install
```

2. create a .env file from the example file and fill in your credentials

3. generate an application key
```
$ php artisan key:generate
```

3. make sure you have docker-compose installed
```
$ docker-compose up
```

4. start the Vite dev server for hot reloading the vue parts (or `npm run build` for production assets)
```
$ npm run dev
```

5. run a migration inside the correct container
```
$ docker-compose exec app php artisan migrate:fresh --seed
```

The app will be on port 80
