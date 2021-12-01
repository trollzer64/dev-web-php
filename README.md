# dev-web-php

Trabalho semestral da disciplina de Desenvolvimento de Sistemas Web

## Objetivo

Implementação de classes em PHP, banco de dados (modelo lógico das tabelas e script), funcionando.

## Descrição

Considere um sistema web para cantinas de escolas. De uma maneira geral a cantina gerencia os produtos vendidos. Para comprar um lanche o aluno possui uma conta gerenciada pelo seu responsável. Nessa conta o responsável pode depositar valores que os alunos gastam comprando os lanches. Desta forma não é necessário que o aluno leve dinheiro para a escola. O responsável poderá fazer depósitos quando desejar. ~~Além disso ele pode também bloquear o consumo de produtos (ex. refrigerantes) impedindo que o aluno possa comprar e visualizar o que o aluno consome todos os dias.~~ Uma especificação mais detalhada é apresentada a seguir.

O sistema será utilizado por três perfis de usuários e terá módulos diferentes um para cada perfil: a cantina, os responsáveis (ex. pais de aluno) e os alunos. O módulo utilizado pela cantina possibilita manter produtos, cadastrar pais e consultar o saldo dos alunos. O módulo utilizado pelos responsáveis permite cadastrar alunos, realizar depósitos para um aluno, consultar o saldo de um aluno, ~~bloquear/desbloquear consumo de produtos pelo aluno~~ e consultar o histórico de consumo de aluno. O módulo do aluno permite que ele compre produtos na cantina e consulte o seu saldo.

### Modelos

-   **Escola**
    -   Nome (string)
    -   Endereço (string)
    -   Telefone (string)
    -   Email (string)
    -   Login (string)
    -   Senha (string)
-   **Responsável**
    -   CPF (string)
    -   Nome (string)
    -   Telefone (string)
    -   Email (string)
    -   Login (string)
    -   Senha (string)
-   **Aluno**
    -   Responsável (fk)
    -   Escola (fk)
    -   Matrícula (string)
    -   Turma (string)
    -   Turno (enum: matutino/vespertino/noturno)
    -   Nome (string)
    -   Telefone (string)
    -   Email (string)
    -   Login (string)
    -   Senha (string)
    -   Saldo (big integer) <!-- Centavos -->
-   **Produto**
    -   Código (string)
    -   Nome (string)
    -   Foto (binary)
    -   Preço (decimal)
    -   Disponível (bool)
    -   **Bebida**
        -   Fornecedor (string)
    -   **Comida**
        -   Ingredientes (string)
-   **Transações**
    -   Aluno (fk)
    -   Quantia (decimal)
    -   Data (date)
-   **Consumo**
    -   Transação (fk)
    -   Produto (fk)

### Funcionalidades

-   **Escola**
    -   CRUD produtos
    -   Disponibilizar produtos
-   **Responsável**
    -   CRUD Ele mesmo
    -   CRUD de aluno
    -   Depositar dinheiro pro aluno
    -   Consultar extrato do aluno
    -   Consultar consumo do aluno
-   **Aluno**
    -   Comprar produto
    -   Consultar o próprio extrato
-   **Produto**
    -   **Bebida**
    -   **Comida**

## Implementação

### Banco

#### Subir banco

```bash
sudo service postgresql start
```

### Modelagem

#### Criação do modelo

```bash
php artisan make:model Student -m
```

#### Migração

```bash
php artisan migrate
```
