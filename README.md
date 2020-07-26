# TBRPG
A **T**urn-**B**ased **RPG** system made with an API connected to a cloud MongoDB database.

## Documentation

### List of technologies we use

- Made with PHP 7.3+ with MongoDB Extension 1.7.5;
- [Lumen 6.x](https://lumen.laravel.com/docs/6.x) to build a powerful REST API;
- [Atlas MongoDB](https://cloud.mongodb.com/) to keep game changes and progress saving. We connected Mongo with Lumen 
throughout [Laravel MongoDB](https://github.com/jenssegers/laravel-mongodb), a great package made by 
[Jens Segers](https://github.com/jenssegers);
- [Ajax](https://github.com/fdaciuk/ajax) a Vanilla JS package to easily call the API from front-end. Made by 
[Fernando Daciuk](https://github.com/fdaciuk);

### Diagrams

All system diagrams can be found 
[here](https://viewer.diagrams.net/?page-id=wlv48fsyCahMGWaBArmx&title=TBRPG%20Diagrams.drawio#R%3Cmxfile%3E%3Cdiagram%20id%3D%22QUwYEdzhh4WQ27PpGiZF%22%20name%3D%22Page-1%22%3EdZE9D4IwEIZ%2FTXdoFXFGxMWJwbmhJ21SOFJqQH%2B9kFKxQZfm%2Btx734RlzVgY3skrCtCERmIk7EQoTZN0emfwdGC3jxyojRIOxSso1QsW6GUPJaAPhBZRW9WFsMK2hcoGjBuDQyi7ow6rdryGDSgrrrf0poSVy1j0sPILqFr6ynFydJ6Ge%2FEySS%2B5wOELsZywzCBaZzVjBnrend%2BLizv%2F8X4aM9DaHwGTseaePsGBWP4G%3C%2Fdiagram%3E%3Cdiagram%20id%3D%22wlv48fsyCahMGWaBArmx%22%20name%3D%22Page-2%22%3ElZFND4IwDIZ%2FzY4kwEDxjF8XTxyUk1lYgSWDkjkj%2BuuFjIkLF70s3bO37d6W0LTpD4p19Qk5SBL6vCd0S8IwWSXDOYKnAVHsG1ApwQ0KZpCJF0zQyu6Cw80RakSpRefCAtsWCu0wphQ%2BXFmJ0u3asQoWICuYXNKz4LqebIXrmR9BVLXtHKw25qVhVjw5udWM4%2BML0R2hqULUJmr6FOQ4OzuXa5%2F4gCpPI1XGvsi97HzxTLH9PykfCwpa%2FWvpIZi%2FNlyc%2FdLdGw%3D%3D%3C%2Fdiagram%3E%3C%2Fmxfile%3E) 
(all made with [draw.io](https://app.diagrams.net/)).

### Installing Project

After cloning this repository, run `composer install` inside `api` folder.

#### Adding code autocompletion (for developers)

To ease development we use [Laravel IDE Helper package](https://github.com/barryvdh/laravel-ide-helper), to create the 
helper files run the following commands inside `api` folder:

```
php artisan ide-helper:generate
php artisan ide-helper:meta
php artisan ide-helper:eloquent
```

#### Running project

You can just run `php -S localhost:8000 -t public` into your terminal and keeping it opened open your browser and go 
to http://localhost:8000/.

### API Endpoints

You can check (and test) all API routes using [Insomnia](https://insomnia.rest/download/) and importing 
Insomnia_date.json file to it.
