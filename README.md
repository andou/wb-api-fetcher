# Running the command line tool

## Install composer
Run these commands if composer is not yet installed
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
```
```
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
```
```
php composer-setup.php
```
```
php -r "unlink('composer-setup.php');"
```
## Clone the project
```
git clone git@github.com:andou/wb-api-fetcher.git
```
## Install the project
```
cd wb-api-fetcher
```
```
composer install
```
## Call the API
```
php bin/console app:fetch <uuid>
```
E.g.
```
php bin/console app:fetch 45781018-f9d5-49c6-b8f3-8d3f1f491a11
```

