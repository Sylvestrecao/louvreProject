[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://github.com/Sylvestrecao/louvreProject)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/45afb680-d4e6-4e66-93ea-bcfa79eb8a87.svg)](https://github.com/Sylvestrecao/louvreProject)
[![Travis](https://img.shields.io/travis/rust-lang/rust.svg)](https://github.com/Sylvestrecao/louvreProject)
# louvreProject
This is my online booking and ticket management system using Symfony 3. I used this project to learn the framework.

Installation
---------
```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:run
```