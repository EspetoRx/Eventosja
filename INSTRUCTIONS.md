## Introdução

- Utilize um virtualizador de Aplicações Web;
- Se estiver utilizando o Windows recomendo o [Laragon Full Apache](https://laragon.org/download.html#Apache);
- Continuarei, com a certeza que o Laragon foi baixado e instalado corretamente;
- Clone este repositório em `C:/laragon/www`;
- Crie um Schema no seu SGBD preferido com o nome de "eventosja" e Latin 1 - Default Colation;
- Execute `composer install`. Se não tiver o gerenciador de pacotes PHP Composer, recomendo o [download](https://getcomposer.org/);
- Crie uma cópia do `.env.example` em um arquivo `.env` e configure o acesso ao seu banco de dados, bem como a configuração do `DB_DATABASE=eventosja`;
- Execute `php artisan key:generate`;
- Execute `php artisan migrate`;
- Se você instalou o Laragon, clique no link de Reload que o mesmo se encarregará de gerar uma PrettyURL para você;
- Abra a aplicação através do Menu de Contexto (Clique com botão direito sobre uma area em branco) do Laragon, submenu "www", item "Eventosja". Ela já se encontra com o Front-End em modo de produção;
