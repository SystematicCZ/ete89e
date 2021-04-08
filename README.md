# Instrukce
[Vue.js dokumentace](https://vuejs.org/v2/guide/) <br>
[BoostrapVue dokumentace](https://bootstrap-vue.org/)

## Struktura

### Api
Obsahuje Symfony appku, která bude sloužit jako API.

#### Nutne
PHP 7.4 nebo PHP 8 \
composer https://getcomposer.org/

```bash
$ cd api
$ composer install
$ bin/console doc:database:create
$ bin/console doc:schema:create
$ bin/console doc:fixtures:load
$ symfony server:start -d
```
V konzoli je videt adresa aplikace po provedení posledního příkazu.

### Web
Obsahuje klienta. Tohle je úkolem zimního semestru.

## Co je potřeba
* git - https://git-scm.com/
* Symfony CLI - https://symfony.com/download
* npm- https://www.npmjs.com/get-npm

## Jak to pustím
```bash
$ git clone git@github.com:SystematicCZ/ete89e.git
$ cd web
$ npm install
$ npm run dev
$ symfony server:start -d
```
Klient poběží na http://localhost:8000. <br>
`npm run dev` udělá build projektu. Při vývoji doporučuji pustit `npm run watch`. Pak bude npm sledovat změny v souborech a bude dělat build automaticky.
