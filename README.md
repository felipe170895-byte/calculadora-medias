# Calculadora de Médias Laravel

Projeto desenvolvido para a **Atividade 3 - Calculadora de Médias Laravel**.

O objetivo do sistema é cadastrar turmas, cadastrar alunos, lançar quatro notas, calcular a média automaticamente, exibir a situação do aluno e permitir o lançamento de nota de recuperação quando necessário.

O projeto foi desenvolvido utilizando **Laravel, PHP, MySQL e Bootstrap**.

---

## Funcionalidades

- Cadastro de turmas
- Edição de turmas
- Exclusão de turmas
- Fechamento de turmas
- Reabertura de turmas
- Cadastro de alunos
- Edição de alunos
- Exclusão de alunos
- Alunos vinculados a uma turma
- Lançamento de quatro notas por aluno
- Cálculo automático da média
- Exibição da mensagem de acordo com a média
- Recuperação para alunos que se enquadram nessa situação
- Cálculo da recuperação
- Salvamento das notas para edição futura
- Bloqueio de alterações quando a turma estiver fechada
- Consulta dos alunos e resultados mesmo com a turma fechada
- Interface visual utilizando Bootstrap

---

## Regras do Sistema

O sistema lê quatro notas do aluno e calcula a média final.

A média é calculada da seguinte forma:

```text
(nota1 + nota2 + nota3 + nota4) / 4
```

De acordo com a média, o sistema exibe uma mensagem para o aluno:

| Média | Mensagem |
|------|----------|
| Acima de 9 | Aprovado com Louvor |
| Acima de 7 | Aluno Aprovado |
| Acima de 4 | Recuperação, sua chance de passar |
| Demais médias | Poxa vida, vamos tentar novamente ano que vem |

---

## Regra da Recuperação

Para alunos em recuperação, o sistema permite lançar uma nota de recuperação.

O aluno será aprovado na recuperação quando:

```text
média + nota da recuperação >= 10
```

Exemplo:

```text
Média: 5,0
Nota da recuperação: 7,3
Resultado: 12,3
Situação: Aprovado na recuperação
```

Outro exemplo:

```text
Média: 4,8
Nota da recuperação: 5,0
Resultado: 9,8
Situação: Reprovado na recuperação
```

---

## Tecnologias Utilizadas

- PHP
- Laravel
- MySQL
- Blade
- Bootstrap
- XAMPP
- Composer
- Git e GitHub

---

## Estrutura do Projeto

```text
app/
 ├── Http/
 │   └── Controllers/
 │       ├── TurmaController.php
 │       ├── AlunoController.php
 │       └── NotaController.php
 │
 └── Models/
     ├── Turma.php
     ├── Aluno.php
     └── Nota.php

database/
 └── migrations/
     ├── create_turmas_table.php
     ├── create_alunos_table.php
     └── create_notas_table.php

resources/
 └── views/
     ├── layouts/
     │   └── app.blade.php
     ├── turmas/
     ├── alunos/
     └── notas/

routes/
 └── web.php
```

---

## Principais Telas

O sistema possui as seguintes telas:

- Listagem de turmas
- Cadastro de turma
- Edição de turma
- Listagem de alunos por turma
- Cadastro de aluno
- Edição de aluno
- Lançamento de notas
- Resultado do aluno
- Recuperação do aluno

---

## Controle de Turmas

Cada turma pode estar em dois estados:

| Status | Descrição |
|--------|-----------|
| Aberta | Permite cadastrar, editar e excluir dados |
| Fechada | Permite apenas consulta dos dados |

Quando a turma é fechada, o sistema bloqueia alterações nos alunos e nas notas.

Também foi implementada a opção de **reabrir turma**, caso o fechamento tenha sido feito por engano.

---

## Como Executar o Projeto

### 1. Clonar o repositório

```bash
git clone LINK_DO_REPOSITORIO
```

### 2. Entrar na pasta do projeto

```bash
cd calculadora-medias
```

### 3. Instalar as dependências

```bash
composer install
```

### 4. Copiar o arquivo de configuração

```bash
copy .env.example .env
```

### 5. Gerar a chave da aplicação

```bash
php artisan key:generate
```

### 6. Criar o banco de dados

No phpMyAdmin, crie um banco com o nome:

```text
calculadora_medias
```

### 7. Configurar o arquivo `.env`

No arquivo `.env`, configure o banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=calculadora_medias
DB_USERNAME=root
DB_PASSWORD=
```

Caso o MySQL tenha senha, preencha o campo:

```env
DB_PASSWORD=sua_senha
```

### 8. Rodar as migrations

```bash
php artisan migrate
```

### 9. Iniciar o servidor

```bash
php artisan serve
```

### 10. Acessar o sistema

Abra no navegador:

```text
http://127.0.0.1:8000
```

---

## Como Usar o Sistema

1. Cadastre uma turma.
2. Acesse a opção de alunos da turma.
3. Cadastre os alunos.
4. Lance as quatro notas do aluno.
5. O sistema calculará a média automaticamente.
6. O resultado será exibido com a mensagem correspondente.
7. Caso o aluno esteja em recuperação, será exibido o formulário para lançar a nota de recuperação.
8. Após finalizar os lançamentos, é possível fechar a turma.
9. Com a turma fechada, os dados ficam apenas para consulta.

---

## Validações Implementadas

- As notas devem estar entre 0 e 10.
- O aluno deve pertencer a uma turma.
- Turmas fechadas não permitem alterações.
- Cada aluno possui apenas um registro de notas.
- A recuperação só é permitida para alunos que precisam dela.
- Não é possível alterar notas de uma turma fechada.

---

## Comandos Úteis

Limpar cache de configuração:

```bash
php artisan config:clear
```

Limpar cache das views:

```bash
php artisan view:clear
```

Listar rotas:

```bash
php artisan route:list
```

Rodar migrations novamente apagando os dados:

```bash
php artisan migrate:fresh
```

---

## Desenvolvedores

- Felipe Motta
- Gabriel Denke Machado

---

## Observação

A interface foi construída com Bootstrap para melhorar a apresentação dos formulários, tabelas, cards e resultados.