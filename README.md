# Sistema de Check-in e Check-out de Hotel

Link projeto GitHub: [clique aqui](https://github.com/tobiasfkk/hotel-checkin-system)

Link documentação do projeto: [clique aqui](https://docs.google.com/document/d/1m9LEzCmzR_oC7NxS5YKpZn0MdXIGspTrQjg9MrLaiks/edit?usp=sharing)

### Executar o projeto
#### Instalar o Docker e o Docker Compose
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
#### Clonar o repositório
    git clone https://github.com/tobiasfkk/hotel-checkin-system
#### Acessar a pasta do projeto
    cd hotel-checkin-system
#### Executar o comando abaixo para criar os containers
    docker-compose up --build -d

### Containers que serão criados
- **hotel-checkin-system**:
  - **billing-service**: Faz o cálculo de acordo com a regra de negócio;
  - **booking-service**: Mantém pessoas e reservas, e realiza check-in / check-out;
  - **booking-db**: Banco de dados do sistema;
  - **auth-db**: Banco de dados do sistema de autenticação.

#### billing-service
##### Api's disponibilizadas:
###### Cálculo do valor da hospedagem
- **Método**: POST
- **URL**: http://localhost:8080/api/billing
- **Cabeçalhos**:
  - Content-Type: application/json
- **Corpo da requisição (JSON)**:
  ```json
  {
    "pessoaId": 1,
    "dataEntrada": "2023-10-01T14:00:00",
    "dataSaida": "2023-10-03T18:00:00",
    "vagasGaragem": 2
  }
  ```
- **Resposta**:
  - **Status**: 200 OK
  - **Corpo da resposta (JSON)**:
  ```json
  {
    "valorTotal": 570.0
  }
  ```

#### booking-service
##### Api's disponibilizadas:
##### CRUDE Pessoa (hóspede):
###### Cadastrar Pessoa
- **Método**: POST
- **URL**: http://localhost:8080/api/pessoas
- **Cabeçalhos**:
  - Accept: application/json
- **Body (JSON)**: 
  ```json
    {
      "nome": "Jonas da Silva",
      "cpf": "123.456.789-12",
      "telefone": "(11) 91234-5688"
    }
  ```
- **Resposta**:
  - **Status**: 201 CREATED
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Pessoa incluída com sucesso"
    }
  ```

###### Consultar Pessoas
- **Método**: GET
- **URL**: http://localhost:8080/api/pessoas
- **Cabeçalhos**:
  - Accept: application/json
- **Resposta**:
  - **Status**: 200 OK
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "id": 1,
        "nome": "João da Silva",
        "cpf": "123.456.789-00",
        "telefone": "(11) 91234-5678"
    },
    {
        "id": 2,
        "nome": "Gabriel Fernando Doege",
        "cpf": "123.456.789-003",
        "telefone": "(47) 9 9148-4284"
    }
  ```
  - **Status**: 200 OK
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Não existem pessoas cadastradas"
    }
  ```

###### Visualizar Pessoa
- **Método**: GET
- **URL**: http://localhost:8080/api/pessoas/{id}
- **Cabeçalhos**:
  - Accept: application/json
- **Respostas**:
  - **Status**: 200 OK
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "id": 1,
        "nome": "João da Silva",
        "cpf": "123.456.789-00",
        "telefone": "(11) 91234-5678"
    },
  ```
  - **Status**: 404 NOT FOUND
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Pessoa não encontrada"
    }
  ```
  
###### Alterar Pessoa
- **Método**: PUT
- **URL**: http://localhost:8080/api/pessoas/{id}
- **Cabeçalhos**:
  - Accept: application/json
- **Body (JSON)**: 
  ```json
    {
      "telefone": "(47) 99999-9999"
    }
  ```
- **Respostas**:
  - **Status**: 200 OK
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Pessoa alterada com sucesso"
    }
  ```

  - **Status**: 404 NOT FOUND
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Pessoa não encontrada, dados não alterados"
    }
  ```

###### Excluir Pessoa
- **Método**: DELETE
- **URL**: http://localhost:8080/api/pessoas/{id}
- **Cabeçalhos**:
  - Accept: application/json
- **Respostas**:
  - **Status**: 200 OK
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Pessoa excluída com sucesso"
    }
  ```

  - **Status**: 404 NOT FOUND
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Pessoa não encontrada, registro não excluído"
    }
  ```
##### CRUDE Reservas:
###### Cadastrar Reserva  
- **Método**: POST  
- **URL**: http://localhost:8080/api/reservas
- **Cabeçalhos**:
  - Accept: application/json  
- **Body (JSON)**:  
  ```json
  {
    "idPessoa": 1,
    "numeroQuarto": 101,
    "dataHoraInicio": "2025-10-01 14:00:00",
    "dataHoraFim": "2025-10-15 14:00:00"
  }
  ```

###### Consultar Reservas  
- **Método**: GET  
- **URL**: http://localhost:8080/api/reservas  
- **Cabeçalhos**:
  - Accept: application/json
- **Resposta**:  
  - **Status**: 200 OK  
  - **Corpo da resposta (JSON)**:  
  ```json
    {
        "id": 1,
        "idPessoa": 1,
        "numeroQuarto": 101,
        "dataHoraInicio": "2025-10-01 14:00:00",
        "dataHoraFim": "2025-10-15 14:00:00",
        "pessoa": {
            "id": 1,
            "nome": "Jonas da Silva",
            "cpf": "123.456.789-12",
            "telefone": "(11) 91234-5688"
        }
    }
  ```
##### CRUDE Check-in:
###### Cadastrar Check-in  
- **Método**: POST  
- **URL**: http://localhost:8080/api/checkins
- **Cabeçalhos**:
  - Accept: application/json  
- **Body (JSON)**:  
  ```json
  {
    "reserva_id": 1,
    "dataHoraEntrada": "2025-10-01 14:00:00",
    "garagem": 1
  }
  ```

###### Consultar Check-in  
- **Método**: GET  
- **URL**: http://localhost:8080/api/checkins  
- **Cabeçalhos**:
  - Accept: application/json
- **Resposta**:  
  - **Status**: 200 OK  
  - **Corpo da resposta (JSON)**:  
  ```json
    {
        "reserva_id": 1,
        "dataHoraEntrada": "2025-10-01 14:00:00",
        "garagem": 1,
        "reserva": {
            "id": 1,
            "idPessoa": 1,
            "numeroQuarto": 101,
            "dataHoraInicio": "2025-10-01 14:00:00",
            "dataHoraFim": "2025-10-15 14:00:00"
        }
    }
  ```

##### CRUDE Check-out:
###### Cadastrar Check-out 
- **Método**: POST  
- **URL**: http://localhost:8080/api/checkouts
- **Cabeçalhos**:
  - Accept: application/json  
- **Body (JSON)**:  
  ```json
  {
      "checkin_id": 1,
      "dataHoraSaida": "2025-10-15 14:00:00"
  }
  ```

  - **Resposta**:  
  - **Status**: 201 CREATED  
  - **Corpo da resposta (JSON)**:  
  ```json
  {
    "message": "Check-out criado com sucesso",
    "checkout": {
        "checkin_id": 1,
        "dataHoraSaida": "2025-10-15 14:00:00",
        "valor": 2165
    }
  }
  ```

###### Consultar Check-out  
- **Método**: GET  
- **URL**: http://localhost:8080/api/checkouts  
- **Cabeçalhos**:
  - Accept: application/json
- **Resposta**:  
  - **Status**: 200 OK  
  - **Corpo da resposta (JSON)**:  
  ```json
    {
        "checkin_id": 1,
        "dataHoraSaida": "2025-10-15 14:00:00",
        "valor": "2165.00",
        "checkin": {
            "reserva_id": 1,
            "dataHoraEntrada": "2025-10-01 14:00:00",
            "garagem": 1
        }
    }
  ```

### Testar banco de dados bookingdb no DBeaver
- **URL**: jdbc:mysql://localhost:3306/bookingdb?allowPublicKeyRetrieval=true&useSSL=false
- **Usuário**: root
- **Senha**: root
