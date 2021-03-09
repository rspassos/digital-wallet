# Digital Wallet

  <div style="text-align:center">
    <a href="https://github.com/rspassos/digital-wallet/actions/workflows/laravel.yml">
      <img src="https://github.com/rspassos/digital-wallet/actions/workflows/laravel.yml/badge.svg" />
    </a>
  </div>

# Funcionalidade

Tipos de usuários:
  - Comum: Paga e Recebe
  - Lojista: Recebe

Usuário:
  - Nome
  - E-mail
  - CPF
  - Senha
  - Saldo

Transferência:
  - Precisa validar:
    - Se usuário pode fazer a transferência
    - Se possui saldo disponível
    - Autorizador externo: https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6
  - Precisa ser reversível
  - Precisa notificar: https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04
  
  # Instalação
  ## Tecnologia
    - Docker
    - PHP 7.4
    - Laravel 8
    - MySQL 5.7

## Primeira instalação
  - docker-compose up --build
    
  - Se der problema com permissão:
      ```
      $ make fix-permissions
      ```


  
## Comando úteis:
  - Seeds:
    ```
    $ make seed
    ```

  - Enter Docker bash
    ```
    $ make docker-bash
    ```

  - Runs Tests
    ```
    $ make test
    ```

# Endpoint
- Realiza uma transação

    - ```[POST] /transaction```

        - Body
            ```json
            {
                "value" : 100.00,
                "payer" : 1,
                "payee" : 3
            }
            ```

        - Response:
            ```json
            {
                "id": 1,
                "value": "100.00",
                "payer": 1,
                "payee": 3,
                "status": "approved",
                "created_at": "2021-03-09T12:00:00.000000Z",
                "updated_at": "2021-03-09T12:00:00.000000Z"
            }
            ```