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
  - **hotel-checkin-system-billing-service-1**: Faz o cálculo de acordo com a regra de negócio;
  - **booking-db**: Banco de dados do sistema;
  - **auth-db**: Banco de dados do sistema de autenticação.

### Testar banco de dados bookingdb no DBeaver
- **URL**: jdbc:mysql://localhost:3306/bookingdb?allowPublicKeyRetrieval=true&useSSL=false
- **Usuário**: root
- **Senha**: root
