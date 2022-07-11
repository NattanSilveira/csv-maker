# CSV MAKER

## Instalação

- **Ter a versão mais atual do [Composer](https://getcomposer.org/download/) instalado**
- **Versão do [PHP](https://www.php.net/downloads) 7.2 ou superior.**


### Após realizar o clone do repositório
> - Executar o comando ```composer install```
> - Renomear o ```.env.example``` para ```.env```
> - Executar o comando ```php artisan key:generate```
> - Alterar a conexão no ```.env``` no ```DB_CONNECTION``` de ```mysql``` para ```sqlite```
> - Criar o banco .sqlite ```touch database/database.sqlite```
> - Executar Migration ``` php artisan migrate```
> - Publicar storage na Public para acesso ao arquivo CSV ``` php artisan storage:link```

### Acessando o projeto
> Pode ser usado com o server do próprio artisan; ```php artisan serve```

### Acessando as rotas
> localhost:8000/api/csv-queue
> > envio da requisição no formato json, Metodo POST
```php
{
	"param1": 1,
	"param2": 2,
	...
}
```

> > Após enviar as requisições executar o comando abaixo para executar a fila
```bash
php artisan queue:work --queue=csv-queue
```

> > O Arquivo CSV estará disponível no caminho
```
public/storage
```
