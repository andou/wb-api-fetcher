# Running the command line tool

### Technical requirements
Having PHP and [composer](https://getcomposer.org/download/) installed.

### Installation
#### Clone the project
```
git clone git@github.com:andou/wb-api-fetcher.git
```
#### Install the project with composer
```
cd wb-api-fetcher
```
```
composer install
```
### Usage
#### Basic
```
php bin/console app:fetch <uuid>
```
E.g.
```
php bin/console app:fetch 45781018-f9d5-49c6-b8f3-8d3f1f491a11
```
#### Advanced
Some parameters could be provided to the command, for an help, run
```
php bin/console app:fetch --help
```
```
Usage:
  app:fetch <uuid> [<baseurl> [<entity_bundle> [<type> [<first_level> [<mapping> [<api_endpoint>]]]]]]
```
If you want, for example, to retrieve data from the live site you may run
```
php bin/console app:fetch <uuid> https://corporatebe.webuildgroup.com
```
E.g.
```
php bin/console app:fetch 96eea71d-50ac-429a-848a-a47851c2eeb8 https://corporatebe.webuildgroup.com
```
### Environment configs
Some command arguments default values are specified in the `.env` file

```
###> app/env-configs ###
BASE_URL=http://corporatebe-qa.salini-impregilo.doing.com
API_ENDPOINT=it/jsonapi
MAPPING=mapping/modules.yml
FIRST_LEVEL=mapping/first-level.yml
###< app/env-configs ###
```

### Pages

Here are the current pages

| Page | Link | ID |
| ---- | ---- | -- |
| HOMEPAGE | [/it/homepage-app-test](https://www.webuildgroup.com/it/homepage-app-test) | |
| GRUPPO  | [/it/il-gruppo](http://testapp.salini-impregilo.doing.com/it/il-gruppo) | |
| AREA DI BUSINESS  | [/it/progetti/sustainable-mobility](http://testapp.salini-impregilo.doing.com/it/progetti/sustainable-mobility) | |
| SOSTENIBILITA’  | [/it/sostenibilita](http://testapp.salini-impregilo.doing.com/it/sostenibilita) | |
| INVESTITORI  | [/it/investitori](http://testapp.salini-impregilo.doing.com/it/investitori) | |
| STRATEGIA | [/it/investitori/strategia](http://testapp.salini-impregilo.doing.com/it/investitori/strategia) | |
| RISULTATI FINANZIARI  | [/it/investitori/risultati-finanziari](http://testapp.salini-impregilo.doing.com/it/investitori/risultati-finanziari) | |
| COMUNICATI STAMPA  | [/it/media/comunicati-stampa](http://testapp.salini-impregilo.doing.com/it/media/comunicati-stampa) | |
| EVENTI  | [/it/investitori/calendario](http://testapp.salini-impregilo.doing.com/it/investitori/calendario) | |
| PODCAST  | [/it/podcast-webuild-app](https://www.webuildgroup.com/it/podcast-webuild-app) | |
