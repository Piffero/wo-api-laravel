<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# <p align="center"> Teste Seleção de Candidatos API </p>

## Ambiente dev/local (docker)
---

### **Primeira vez (Iniciar)**
**Passos:** 
- Clonar repositório
- Criar variáveis de usuario e grupo
- Criar/subir containers(build)
- Dependencias e configurações
- URL de acesso

### **Outras vezes (Dia-dia)**
**Passos:** 
- Criar variáveis de usuario e grupo
- Criar/subir containers(sem build)
- URL de acesso
---

### Clonar repositório
```sh
mrdir projeto.wo
cd projeto.wo
git clone https://github.com/Piffero/wo-api-laravel.git Backend
cd Backend
```
### Criar variáveis de usuario e grupo
```sh
export USUID=$(id -u) && export GRPID=$(id -g)
```

### Criar/subir containers(build)
```sh
docker-compose up --build -d
```

### Criar/subir containers(sem build)
```sh
docker-compose up -d
```

### Dependencias e configurações
```sh
docker-compose exec api composer install
docker-compose exec api php artisan key:generate
``` 
<br>

### URL de acesso
http://localhost:3000 <br><br>


### MySQL Configurações
```sh
docker exec -ti db-wo /bin/bash
mysql -u root -p
Enter password:root123
mysql> CREATE DATABASE IF NOT EXISTS project_wo_local_docker;
mysql> exit
exit
```

- - - -
## **QUER UTILIZAR** Gerenciador de Banco de Dados
### Configuração de conexão ao Banco de Dados
```sh
HOST = localhost
PORT = 33376
USER = ROOT
PASS = ROOT123
```

Ao conectar de **DBeaver** Você terá que ir para guia "Connection settings" -> "SSL" e depois
<br><br><img src="https://i.stack.imgur.com/mbL65.png">

### Outros Gerenciadores de Banco de Dados.
Ao conectar de **Client JAVA** Você terá que verificar suas configurações junto ao mesmo.
```sh
jdbc:mysql://localhost:33376/db?allowPublicKeyRetrieval=true&useSSL=false
```
<br><br>
- - - -

## OUTRAS FUNCIONALIDADES

### Primeria vez com Migrate
```sh
docker-compose exec api php artisan app:migrate-in-order
docker-compose exec api php artisan migrate
```

### Nas outras Migrate
```sh
docker-compose exec api php artisan migrate
```

### Rodar o Seeder
```sh
docker-compose exec api php artisan db:seed
```

### URL para documentação publicada
https://documenter.getpostman.com/view/2594547/2s93eVWYku <br><br>


### Rodar os testes
```sh
docker-compose exec api php artisan test
```
