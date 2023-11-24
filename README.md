# Para rodar o projeto após clonar

Use os seguintes comandos no terminal do VScode na pasta do projeto:
- composer install
- npm install

Em seguida crie um arquivo '.env' e configure com base no arquivo '.env.example'. 
Então crie um banco de dados para o projeto. Não precisa criar as tabelas porque elas já vão ser geradas com o comando: php artisan migrate
Caso queira usar os seeders do projeto, verifique o que está comentado no arquivo 'DatabaseSeeder.php' e decide o que vai deixar assim ou não.
Por fim, para rodar o projeto, utilize este comando: php artisan serve