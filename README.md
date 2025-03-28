# Projeto Laravel - Guia de Configuração

Este documento contém um guia passo a passo para configurar e rodar o projeto Laravel em seu ambiente local. Siga as instruções abaixo para garantir que todos os passos sejam executados corretamente.

## Requisitos

Antes de começar, você precisará ter os seguintes programas instalados no seu sistema:

- [PHP 7.3 ou superior](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/) ou qualquer outro banco de dados que você esteja utilizando

## Passos para Configuração

Siga os passos abaixo para configurar e rodar a aplicação localmente.

### 1. **Copiar o arquivo `.env.example` para `.env`**

O arquivo `.env.example` contém as configurações padrão para o projeto, mas você precisará criar uma versão personalizada deste arquivo com as suas configurações de banco de dados e outras variáveis de ambiente.

Execute o seguinte comando para copiar o arquivo de exemplo:

```bash
cp .env.example .env
```

### 2. **Alterar as configurações do banco de dados**

O arquivo `.env.example` contém as configurações padrão para o projeto, mas você precisará criar uma versão personalizada deste arquivo com as suas configurações de banco de dados e outras variáveis de ambiente.

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 3. **Copiar o arquivo `.env.example` para `.env`**

Agora, instale todas as dependências do projeto usando o Composer. Isso irá baixar as bibliotecas necessárias para rodar o Laravel.

Execute o seguinte comando:

```bash
composer install
```

### 4. **Executar as migrações do banco de dados**

Depois de instalar as dependências, o próximo passo é configurar o banco de dados. Execute as migrações para criar as tabelas necessárias na base de dados.

Execute o comando:

```bash
php artisan migrate
```

### 5. **Rodar a aplicação com o PHP Artisan Serve**

Finalmente, você pode rodar a aplicação usando o servidor embutido do Laravel. Execute o seguinte comando para iniciar o servidor:

```bash
php artisan serve
```

Isso irá iniciar o servidor na URL padrão http://127.0.0.1:8000.

Agora, você pode acessar a aplicação no seu navegador!