# Instrukce

## Struktura

### Api
Obsahuje Symfony appku, která bude sloužit jako API. Zatím se tím nezabýváme.

### Web
Obsahuje klienta. Tohle je úkolem zmního semestru.

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

