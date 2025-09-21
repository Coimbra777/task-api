API backend para gerenciamento de tarefas com logs, construída em **Laravel Lumen 11**.
A aplicação permite criar, listar, atualizar e deletar tarefas, além de registrar logs das ações realizadas.

---

## Tecnologias Utilizadas

-   PHP 8.3 + Lumen 11
-   MySQL 8.0 (para tarefas)
-   MongoDB 6 (para logs)
-   Docker / Docker Compose
-   PHPUnit (para testes automatizados)

---

## Estrutura de Endpoints

Todos os endpoints estão no prefixo `/api`:

| Método | Endpoint        | Descrição                                                                |
| ------ | --------------- | ------------------------------------------------------------------------ |
| GET    | /api/tasks      | Lista todas as tarefas (com filtro opcional por status)                  |
| GET    | /api/tasks/{id} | Retorna uma tarefa pelo ID                                               |
| POST   | /api/tasks      | Cria uma nova tarefa                                                     |
| PUT    | /api/tasks/{id} | Atualiza uma tarefa                                                      |
| DELETE | /api/tasks/{id} | Remove uma tarefa                                                        |
| GET    | /api/logs       | Lista os últimos 30 logs (ou 1 log se `id` for passado como query param) |

> Status válidos para tarefas: `pending`, `in_progress`, `done`

---

## Instruções para rodar o projeto

### Clonar o repositório

```sh
git clone https://github.com/Coimbra777/task-api
```

### Suba os containers do projeto

```sh
docker-compose up -d --build
```

---

Isso irá criar containers para:

App PHP/Lumen

Nginx

MySQL

MongoDB

PhpMyAdmin (acesso web ao MySQL)

---

### Crie o Arquivo .env

```sh
cp .env.example .env
```

### Acesse o container app

```sh
docker exec -it lumen_app bash
```

### Instale as dependências do projeto

```sh
composer install
```

### Gere a key do projeto Laravel

```sh
php artisan key:generate
```

### Rodar as migrations

```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8989](http://localhost:8989)

### Comando para rodar tests automatizados

```sh
docker exec -it lumen_app vendor/bin/phpunit
```

### Testar a API no Postman

---

1.  Abra o Postman

2.  Importe o arquivo JSON que está na pasta public/task-api.json

3.  Todos os endpoints já estarão configurados para teste

4.  Você pode usar o Postman para:

    -   Criar novas tarefas

    -   Listar tarefas por status

    -   Atualizar ou deletar tarefas

    -   Consultar logs da aplicação

---

### Comando para encerrar os containers

```sh
docker composer down -v
```
