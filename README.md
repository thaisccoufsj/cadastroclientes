#Cadastro de Clientes

#Technologies
- Docker
- Laravel
- Bootstrap
- MySQL
- jQuery

#How to test
- Clone the repository
- Access the project directory
- Grant permission to the directory `chmod -R 777 ./`
- Rename the `app/.env.example` file to `app/.env`
- Start Docker and run `docker-compose --env-file ./app/.env up`
- Access the application container `docker exec -it Cadastro bash`
- Generate application key `php artisan key:generate`
- Run the migrations `php artisan migrate`
- Access `localhost` in browser

#Result
![Home](/screenshot/customers-home.png "Home")

![New](/screenshot/customer-new.png "New")

![Edit](/screenshot/customer-edir.png "Edit")