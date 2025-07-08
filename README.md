# Sistema de Check-in e Check-out de Hotel

Link projeto GitHub: [clique aqui](https://github.com/tobiasfkk/hotel-checkin-system)

Link documentação do projeto: [clique aqui](https://docs.google.com/document/d/1m9LEzCmzR_oC7NxS5YKpZn0MdXIGspTrQjg9MrLaiks/edit?usp=sharing)

## 📊 Sistema de Monitoramento com Grafana

Este projeto inclui um **sistema de monitoramento profissional** usando Grafana, que permite visualizar em tempo real a performance e saúde dos serviços.

### 🎯 Para que serve o Grafana?
- **📈 Monitoramento em tempo real** - CPU, memória, containers
- **🔍 Análise de performance** - Detecta gargalos e problemas
- **🚨 Alertas automáticos** - Notifica quando algo está errado
- **📋 Dashboards interativos** - Gráficos e métricas personalizáveis

### 🚀 Como acessar o Grafana
```
URL: http://localhost:3000
Usuário: admin
Senha: admin123
```

### 📊 Dashboard Principal
- **Hotel Overview:** http://localhost:3000/d/hotel-overview
- **Métricas disponíveis:** CPU, Memória, Status dos serviços, Containers Docker
- **Atualizações:** Automáticas a cada 30 segundos

> **📖 Guia Completo:** Veja o arquivo [GUIA-GRAFANA.md](./GUIA-GRAFANA.md) para instruções detalhadas de uso.

---

## 🛠️ Executar o projeto

### Ambientes disponíveis:
- **Desenvolvimento:** `docker-compose.dev.yml`
- **Produção:** `docker-compose.prod.yml` 
- **Monitoramento:** `docker-compose.monitoring.yml`
- **Análise de código:** `docker-compose.sonar.yml`

### Instalação
#### Pré-requisitos
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

#### Clonar o repositório
```bash
git clone https://github.com/tobiasfkk/hotel-checkin-system
cd hotel-checkin-system
```

#### Executar ambiente completo (recomendado)
```bash
# Ambiente de desenvolvimento com monitoramento
docker-compose -f docker-compose.dev.yml -f docker-compose.monitoring.yml up --build -d
```

#### Ou executar apenas os serviços principais
```bash
docker-compose up --build -d
```

### Containers que serão criados
- **hotel-checkin-system**:
  - **billing-service**: Faz o cálculo de acordo com a regra de negócio;
  - **auth-service**: Permite registrar usuário e realizar login;
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

#### auth-service
##### Api's disponibilizadas:
###### Registrar Usuário
- **Método**: POST
- **URL**: http://localhost:8080/api/register
- **Cabeçalhos**:
  - Accept: application/json
- **Body (JSON)**: 
  ```json
    {
      "name": "Gabriel",
      "email": "gabrieladmin@gmail.com",
      "password": "123456",
      "role": "admin"
    }
  ```
  ```json
    {
      "name": "Gabriel",
      "email": "gabrielnormal@gmail.com",
      "password": "123456",
      "role": "normal"
    }
  ```
- **Resposta**:
  - **Status**: 201 CREATED
  - **Corpo da resposta (JSON)**:
  ```json
    {
        "message": "Usuário criado com sucesso"
    }
  ```
###### Realizar Login
- **Método**: POST
- **URL**: http://localhost:8080/api/login
- **Cabeçalhos**:
  - Accept: application/json
- **Body (JSON)**: 
  ```json
    {
        "email": "gabrieladmin@gmail.com",
        "password": "123456"
    }
  ```
- **Resposta**:
  - **Status**: 200 OK
  - **Corpo da resposta (JSON)**:
  ```json
    {
      "token": "token",
      "token_type": "bearer",
      "expires_in": 3600
    }
  ```

#### booking-service
##### Api's disponibilizadas:
##### CRUDE Pessoa (hóspede):
###### Cadastrar Pessoa
- **Disponível para**: admin
- **Método**: POST
- **URL**: http://localhost:8080/api/pessoas
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin e normal
- **Método**: GET
- **URL**: http://localhost:8080/api/pessoas
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin e normal
- **Método**: GET
- **URL**: http://localhost:8080/api/pessoas/{id}
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin
- **Método**: PUT
- **URL**: http://localhost:8080/api/pessoas/{id}
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin
- **Método**: DELETE
- **URL**: http://localhost:8080/api/pessoas/{id}
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin
- **Método**: POST  
- **URL**: http://localhost:8080/api/reservas
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin e normal
- **Método**: GET  
- **URL**: http://localhost:8080/api/reservas  
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin
- **Método**: POST  
- **URL**: http://localhost:8080/api/checkins
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token  
- **Body (JSON)**:  
  ```json
  {
    "reserva_id": 1,
    "dataHoraEntrada": "2025-10-01 14:00:00",
    "garagem": 1
  }
  ```

###### Consultar Check-in  
- **Disponível para**: admin e normal
- **Método**: GET  
- **URL**: http://localhost:8080/api/checkins  
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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
- **Disponível para**: admin
- **Método**: POST  
- **URL**: http://localhost:8080/api/checkouts
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token  
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
- **Disponível para**: admin e normal
- **Método**: GET  
- **URL**: http://localhost:8080/api/checkouts  
- **Cabeçalhos**:
  - Accept: application/json
  - Authorization: Bearer login_token
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

### Testar Jenkins
#### Rodar conteiner Docker com Jenkins
    docker run -d --name jenkins -p 8081:8080 -v jenkins_home:/var/jenkins_home jenkins/jenkins:lts
#### Obter senha Jenkins
    docker exec -it jenkins cat /var/jenkins_home/secrets/initialAdminPassword
### Após isso:
 - Acessar http://localhost:8081/
 - Informar a senha obtida
 - Instalar as extensões sugeridas
 - Criar conta
### Adicionar credencial Docker Hub
 - Na interface do Jenkins, acessar Gerenciar Jenkins > Credentials > (global) > Add Credentials;
 - Preencher conforme abaixo:
    - **Username**: Nome de usuário do Docker Hub
    - **Password**: Senha ou token do Docker Hub
    - **ID**: dockerhub-credentials-id
