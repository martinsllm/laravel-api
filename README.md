# Student Course API

API desenvolvida em **Laravel** para gerenciamento de **estudantes** e **cursos**, onde um estudante pode se matricular em vários cursos.

## Descrição

A API permite:

- Criar, listar, atualizar e remover estudantes
- Criar, listar, atualizar e remover cursos
- Matricular estudantes em cursos

A relação entre estudantes e cursos é **many-to-many**.

## Tecnologias

- PHP
- Laravel
- MySQL

## Instalação

Clone o repositório:

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
````

Entre na pasta do projeto:

```bash
cd seu-repositorio
```

Instale as dependências:

```bash
composer install
```

Copie o arquivo `.env`:

```bash
cp .env.example .env
```

Configure o banco de dados no arquivo `.env`.

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Execute as migrations:

```bash
php artisan migrate
```

## Executar o projeto

Inicie o servidor:

```bash
php artisan serve
```

A API ficará disponível em:

```
http://localhost:8000
```

## Licença

MIT

```
```
