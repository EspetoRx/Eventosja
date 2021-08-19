# Eventosja

## Passo à passo da instalação

- Estou utilizando o ambiente de desenvolvimento Windows 10 64-bits;
- Como container de inicialização estou utilizando o [Laragon Full 64-bits](https://laragon.org/download/index.html);
- Uma vez o Laragon instalado, clique em Iniciar Tudo. Dica: Não se esqueça das suas configuraçõe de banco de dados!
- Abra o menu de contexto clicando em qualquer área em branco do programa e vá em Criar Rapidamente um Website e escolha Laravel.
- Insira o nome Eventosjá e crie o projeto.
- Se por ventura seu Laragon der um erro de "Allowed memory size", utilize o menu de contexto do Laragon, no submenu PHP, o atalho para o php.ini. Modifique o atributo "memory_limit" para -1. Rode composer install novamente no diretório do Eventosjá. 
- O Laragon se encarregou de rodar o comando de criação do projeto e do Schema no banco de dados;
- O nome do Schema no banco de dados não pode possuir acento. Se você não possui um software de Gerenciamento de Banco de Dados recomendo fortemente a utilização do [MySQL Workbench](https://dev.mysql.com/downloads/workbench/). Contudo, um PhpMyAdmin deva servir ao propósito.
- Droparemos o Schema com nome acentuado e continuaremos criando um Schema com um nome sem acento (criado schema "eventosja"). Use latin1 - default collation como a Collation.
- Configuraremos o .env:
- - Defina BD_DATABASE=eventosja
- Rode o comando: php artisan key:generate para gerar a chave única de identificação da aplicação.
- Abra o menu de contexto do Laragon novamente, submenu www, e escolha o Eventosjá para abrir a aplicação. Se você ver uma tela do Laravel está tudo certo. Podemos dar continuidade na construção da aplicação.
- Execute o comando npm install para que possamos instalar o NPM.
- Uma vez instalado o NPM rode o comando mix watch --hot para executar o live reload e começarmos a trabalhar no projeto.
- Limparei toda a wellcome.blade.php, para comportar nossos arquivos CSS e JS.
- Neste ponto acho que vou dar mais um commit, o chamarei de "Alpha 0.0.1".




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[CMS Max](https://www.cmsmax.com/)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
