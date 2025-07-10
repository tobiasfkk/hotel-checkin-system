# Sist## 📚 Documentação Automática (Javadoc)

Este projeto possui **documentação automática** que é gerada dinamicamente a partir do código:

### 🎯 O que é gerado automaticamente:
- **📖 Javadoc** - Documentação completa do código Java (classes, métodos, pa#### 🎯 **#### 🏷️ **Tags das imagens:**
- `hotel-checkin-system/auth-service:latest`
- `hotel-checkin-system/booking-service:latest`
- `hotel-checkin-system/billing-service:latest`
- `hotel-checkin-system/api-gateway:latest`que serve DockerHub:**
- **🌐 Registry público** - Distribuição externa de imagens
- **🚀 Deploy produção** - Pull de imagens em servidores remotos
- **🔄 CI/CD** - Automação de deploy via Jenkins
- **📦 Versionamento** - Tags automáticas por buildros)
- **📋 Interface Web** - Página principal moderna para acessar toda documentação
- **🧪 Centro de Testes** - Interface para testar APIs manualmenteeck-in e Check-out de Hotel

Link projeto GitHub: [clique aqui](https://github.com/tobiasfkk/hotel-checkin-system)

Link documentação do projeto: [clique aqui](https://docs.google.com/document/d/1m9LEzCmzR_oC7NxS5YKpZn0MdXIGspTrQjg9MrLaiks/edit?usp=sharing)

## 📚 Documentação Automática (Javadoc)

Este projeto possui **documentação automática** que é gerada dinamicamente a partir do código:

### 🎯 O que é gerado automaticamente:
- **📖 Javadoc** - Documentação completa do código Java (classes, métodos, parâmetros)
- **� Interface Web** - Página principal moderna para acessar toda documentação
- **🧪 Centro de Testes** - Interface para testar APIs manualmente

### 🚀 Como gerar a documentação:
```bash
# Execute o script de geração automática
.\docs-generate.bat
```

### 🌐 Como visualizar:
```bash
# Abrir automaticamente no navegador
start docs\final\index.html
```

**Ou acesse diretamente:**
- **Página Principal**: `docs/final/index.html`
- **Javadoc**: `docs/final/javadoc/index.html`
- **Centro de Testes**: `docs/api-testing.html`

### ⚙️ Como funciona:
1. **Maven gera Javadoc** automaticamente a partir dos comentários no código
2. **Script copia e organiza** toda documentação em uma interface única
3. **Documentação fica sempre atualizada** com o código atual

### 🔄 Regenerar após mudanças:
Sempre que fizer alterações no código, execute novamente:
```bash
.\docs-generate.bat
```

---

## �📊 Sistema de Monitoramento com Grafana

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

### 🔧 Stack Completo de Monitoramento:
- **📈 Grafana** - Dashboards interativos e visualização
- **📊 Prometheus** - Coleta e armazenamento de métricas
- **🐳 cAdvisor** - Monitoramento de containers Docker
- **💻 Node Exporter** - Métricas do sistema operacional
- **🔔 Alertmanager** - Sistema de alertas automáticos

### 🎯 Métricas Monitoradas:
- **🖥️ Sistema** - CPU, memória, disco, rede
- **🐳 Containers** - Status, recursos, logs
- **☕ Java Apps** - JVM, heap, threads, GC
- **🗄️ Database** - Conexões, queries, performance
- **🌐 APIs** - Tempo resposta, throughput, erros

### 🚀 Iniciar Monitoramento Completo:
```bash
# Ambiente completo (aplicação + monitoramento)
docker-compose -f docker-compose.dev.yml -f docker-compose.monitoring.yml up --build -d

# Apenas ferramentas de monitoramento
docker-compose -f docker-compose.monitoring.yml up --build -d
```

### 🌐 URLs das Ferramentas:

#### 📊 Prometheus - Métricas
```
URL: http://localhost:9090
```

#### 🔔 Alertmanager - Alertas
```
URL: http://localhost:9093
```

### ⚡ Alertas Automáticos:
- **🚨 CPU > 80%** por 5+ minutos
- **💾 RAM > 90%** utilizada
- **💿 Disco > 85%** cheio
- **🐳 Container down** ou não respondendo
- **🌐 API > 2s** tempo de resposta

### 📊 Dashboards Disponíveis:
- **🏨 Hotel Overview** - http://localhost:3000/d/hotel-overview
- **🐳 Docker Status** - http://localhost:3000/d/docker
- **💻 System Resources** - http://localhost:3000/d/system
- **📱 Application Health** - http://localhost:3000/d/apps

### 🔄 Características:
- **⚡ Tempo Real** - Atualizações a cada 15s
- **📈 Histórico** - 30 dias de retenção
- **🔔 Alertas** - Notificações automáticas
- **📊 Dashboards** - Interface responsiva

---

## 🎯 Resumo das Funcionalidades Implementadas

### 📚 Documentação Automática:
- ✅ **Javadoc** - Documentação do código Java gerada automaticamente
- ✅ **Interface Web** - Página centralizada para toda documentação
- ✅ **Centro de Testes** - Interface para testar APIs manualmente
- ✅ **Script automatizado** - `.\docs-generate.bat` para regenerar

### 📊 Monitoramento Profissional:
- ✅ **Grafana** - Dashboards interativos de métricas
- ✅ **Prometheus** - Coleta de métricas em tempo real
- ✅ **Alertas** - Sistema automático de notificações
- ✅ **Multi-layer** - Sistema, containers, aplicações, APIs
- ✅ **Dashboards** - Customizados para hotel (check-ins, reservas)

### 🔧 DevOps & Automação:
- ✅ **Docker Compose** - Múltiplos ambientes (dev, prod, monitoring)
- ✅ **Scripts** - Automatização de deploy e configuração
- ✅ **Jenkins** - Pipeline de CI/CD configurado
- ✅ **SonarQube** - Análise de qualidade de código
- ✅ **DockerHub** - Registry para imagens Docker
- ✅ **Nexus** - Artifact repository management
- ✅ **Multi-ambiente** - Desenvolvimento, produção e análise

---

## 🛠️ DevOps Tools & Artifact Management

### 📦 **Nexus Repository Manager**
Artifact repository **privado** para gerenciamento centralizado de dependências e artefatos internos.

#### 🎯 **Para que serve Nexus:**
- **📦 Cache Maven** - Acelera builds (download de dependências)
- **🏢 Artefatos internos** - JAR/WAR da sua organização
- **🐳 Registry Docker** - Imagens Docker internas/desenvolvimento
- **🔒 Controle acesso** - Repositórios corporativos privados
- **⚡ Performance** - Cache local de dependências externas

#### 🚀 **Iniciar Nexus:**
```bash
# Subir Nexus Repository
docker-compose -f docker-compose.nexus.yml up -d

# Acessar: http://localhost:8081
# Login inicial: admin / (senha em logs)
docker-compose -f docker-compose.nexus.yml logs nexus | findstr password
```

#### 📦 **Repositórios configurados:**
- **Maven Central** (proxy) - Cache do Maven Central
- **Maven Releases** (hosted) - Artefatos finais da empresa
- **Maven Snapshots** (hosted) - Builds desenvolvimento
- **Docker Registry** (hosted) - Imagens Docker internas

#### ⚙️ **Configuração Maven (pom.xml):**
```xml
<!-- Cache de dependências via Nexus -->
<repositories>
    <repository>
        <id>nexus-public</id>
        <url>http://localhost:8081/repository/maven-public/</url>
    </repository>
</repositories>

<!-- Deploy de artefatos internos no Nexus -->
<distributionManagement>
    <repository>
        <id>nexus-releases</id>
        <url>http://localhost:8081/repository/maven-releases/</url>
    </repository>
    <snapshotRepository>
        <id>nexus-snapshots</id>
        <url>http://localhost:8081/repository/maven-snapshots/</url>
    </snapshotRepository>
</distributionManagement>
```

#### 🐳 **Docker Registry no Nexus:**
```bash
# Push imagem para Nexus (desenvolvimento/teste)
docker tag billing-service localhost:8081/hotel/billing-service:dev
docker push localhost:8081/hotel/billing-service:dev

# Pull imagem do Nexus
docker pull localhost:8081/hotel/billing-service:dev
```

---

### 📊 **SonarQube - Code Quality Analysis**
Sistema de análise estática de código para detectar bugs, vulnerabilidades e code smells.

#### 🚀 **Como iniciar SonarQube:**
```bash
# Iniciar SonarQube com PostgreSQL
docker-compose -f docker-compose.sonar.yml up -d

# Verificar se está funcionando
docker logs sonarqube
```

#### 🌐 **Acessar SonarQube:**
```
URL: http://localhost:9000
Usuário: admin
Senha: admin
```

#### 📊 **Executar análise manualmente:**
```bash
# Para projetos Java (billing-service e api-gateway)
cd billing-service-java
mvn sonar:sonar -Dsonar.host.url=http://localhost:9000 -Dsonar.login=admin -Dsonar.password=admin

cd ../api-gateway-java
mvn sonar:sonar -Dsonar.host.url=http://localhost:9000 -Dsonar.login=admin -Dsonar.password=admin
```

#### 🔧 **Configuração automática no pom.xml:**
```xml
<properties>
    <sonar.projectKey>hotel-checkin-billing</sonar.projectKey>
    <sonar.organization>hotel-systems</sonar.organization>
    <sonar.host.url>http://localhost:9000</sonar.host.url>
</properties>
```

---

### 🐳 **DockerHub Integration**
Registry **público** para armazenamento e distribuição de imagens Docker.

#### � **Para que serve DockerHub:**
- **🌐 Registry público** - Distribuição externa de imagens
- **🚀 Deploy produção** - Pull de imagens em servidores remotos
- **🔄 CI/CD** - Automação de deploy via Jenkins
- **📦 Versionamento** - Tags automáticas por build

#### �🏷️ **Tags das imagens:**
- `hotel-checkin-system/auth-service:latest`
- `hotel-checkin-system/booking-service:latest`
- `hotel-checkin-system/billing-service:latest`
- `hotel-checkin-system/api-gateway:latest`

#### 📤 **Push manual para DockerHub:**
```bash
# Build e push da imagem
docker build -t hotel-checkin-system/billing-service:latest ./billing-service-java
docker push hotel-checkin-system/billing-service:latest

# Para todos os serviços
docker-compose build
docker-compose push
```

#### ⚙️ **Jenkins Pipeline:**
O Jenkinsfile já está configurado para:
- ✅ Build automático das imagens
- ✅ Push para DockerHub em branches main/develop
- ✅ Versionamento automático (BUILD_NUMBER-GIT_COMMIT)
- ✅ Tag 'latest' para branch main

---

## 🔄 **Nexus vs DockerHub - Diferenças e Quando Usar**

### 📊 **Comparação Detalhada:**

| Característica | 🏛️ **Nexus Repository** | 🐳 **DockerHub** |
|---|---|---|
| **🎯 Propósito** | Artifact Repository **Privado** | Registry Docker **Público** |
| **📦 Artefatos** | JAR, WAR, ZIP, Docker, NPM, NuGet | **Apenas** imagens Docker |
| **🔒 Acesso** | **Interno** (empresa/projeto) | **Externo** (distribuição) |
| **💰 Custo** | **Gratuito** (self-hosted) | Limitações no plano gratuito |
| **🏢 Ambiente** | **Desenvolvimento/Corporativo** | **Produção/Deploy** |
| **🔐 Privacidade** | **100% Privado** | Repositórios públicos/privados |

### 🎯 **Quando usar NEXUS:**
```
✅ Desenvolvimento interno
✅ Artefatos Maven (JAR/WAR)
✅ Cache de dependências
✅ Repositórios corporativos
✅ Controle total de acesso
✅ Imagens Docker internas/teste
```

### 🎯 **Quando usar DOCKERHUB:**
```
✅ Deploy em produção
✅ Distribuição externa
✅ CI/CD automático
✅ Pull em servidores remotos
✅ Versionamento público
✅ Integração com orquestradores
```

### 🏗️ **Fluxo Recomendado (AMBOS):**
```
1. 🔧 Desenvolvimento → Nexus (artefatos internos)
2. 🏗️ Build Maven → Nexus (JAR/WAR)
3. 🐳 Build Docker → Nexus (teste interno)
4. ✅ CI/CD Pipeline → DockerHub (produção)
5. 🚀 Deploy Produção → Pull do DockerHub
```

### ⚙️ **Configuração COMPLEMENTAR:**
```bash
# 1. Maven artifacts → Nexus (desenvolvimento)
mvn deploy  # → http://localhost:8081/repository/maven-releases/

# 2. Docker images → Nexus (teste interno)
docker tag billing-service localhost:8081/hotel/billing-service:dev
docker push localhost:8081/hotel/billing-service:dev

# 3. Docker images → DockerHub (produção)
docker tag billing-service hotel-checkin-system/billing-service:latest
docker push hotel-checkin-system/billing-service:latest
```

---

## 🏭 **Cenários Práticos de Uso - DevOps Pipeline**

### 🎯 **Cenário 1: Desenvolvimento Local**
```bash
# Desenvolvedor trabalhando localmente
1. mvn clean compile → Cache dependências do Nexus
2. docker build → Imagem local para teste
3. docker tag → localhost:8081/hotel/service:dev
4. docker push → Nexus (compartilhar com equipe)
```

### 🎯 **Cenário 2: Pipeline CI/CD (Jenkins)**
```bash
# Build automático no Jenkins
1. git push → Trigger Jenkins
2. mvn test → SonarQube analysis
3. mvn package → Deploy JAR no Nexus
4. docker build → Criar imagem Docker
5. docker push → DockerHub (produção)
```

### 🎯 **Cenário 3: Deploy Produção**
```bash
# Servidor de produção
1. docker pull hotel-checkin-system/billing-service:latest
2. docker run → Execução em produção
3. Grafana → Monitoramento em tempo real
```

### 🎯 **Cenário 4: Análise de Qualidade**
```bash
# Code Review e Quality Gates
1. SonarQube → Análise automática
2. Quality Gate → Aprovação/Rejeição
3. Métricas → Coverage, Bugs, Vulnerabilities
```

### 📋 **RECOMENDAÇÃO para seu projeto:**
```
📋 MANTENHA TODAS AS FERRAMENTAS - são complementares!

🏛️ Nexus: Cache Maven + Artefatos internos + Docker dev
🐳 DockerHub: Deploy produção + Distribuição externa
📊 SonarQube: Qualidade código + Security + Coverage
📈 Grafana: Monitoramento + Métricas + Alertas

📖 **Para mais detalhes:** [DevOps Guide Completo](docs/DEVOPS-GUIDE.md)
```

---

### 🔄 **Ambiente Completo DevOps (Branch DEV):**
```bash
# No branch DEV, um comando só inicia TUDO:
git checkout dev
docker-compose -f docker-compose.dev.yml up -d

# Inclui automaticamente todas as ferramentas:
# 🏨 Aplicação completa
# 📊 Monitoramento (Grafana + Prometheus)  
# 🔍 Qualidade (SonarQube)
# 📦 Artefatos (Nexus)
```

### 📊 **URLs das Ferramentas DevOps (Branch DEV):**

#### 🏨 **Aplicação Principal**
```
URL: http://localhost:8080
API Gateway: Entrada principal para todos os serviços
```

#### 📊 **Monitoramento**
```
Grafana: http://localhost:3000 (admin/admin123)
Prometheus: http://localhost:9090
Node Exporter: http://localhost:9100
```

#### 🔍 **Qualidade de Código**
```
SonarQube: http://localhost:9000 (admin/admin)
```

#### 📦 **Repositório de Artefatos**
```
Nexus: http://localhost:8081 (admin/senha nos logs)
```

#### 🗄️ **Bancos de Dados**
```
MySQL (Booking): localhost:3307 (root/root)
PostgreSQL (Auth): localhost:5432 (postgres/root)
```

#### 🐳 **DockerHub**
```
Registry: docker.io/hotel-checkin-system/
Imagens: auth-service, booking-service, billing-service, api-gateway
```

### 🎯 **Portas por Ambiente:**

#### 🔧 **DEV** (Branch dev):
- **8080** - API Gateway
- **3000** - Grafana  
- **9000** - SonarQube
- **9090** - Prometheus
- **9100** - Node Exporter
- **8081** - Nexus
- **3307** - MySQL
- **5432** - PostgreSQL

#### 🧪 **STAGING** (Branch staging):
- **8080** - API Gateway
- **3000** - Grafana
- **9090** - Prometheus
- **3308** - MySQL (porta diferente)
- **5433** - PostgreSQL (porta diferente)

#### 🚀 **PROD** (Branch prod):
- **8080** - API Gateway
- **3000** - Grafana
- **9090** - Prometheus
- **3309** - MySQL (porta diferente)
- **5434** - PostgreSQL (porta diferente)

---

## 🛠️ Executar o projeto

### Ambientes disponíveis e estrutura:

#### 🔧 **Branch DEV** (Desenvolvimento - Ambiente Completo)
- **Arquivo único consolidado:** `docker-compose.dev.yml`
- **Inclui TUDO necessário para desenvolvimento:**
  - 🏨 **Aplicações principais** (auth, booking, billing, gateway)
  - 📊 **Monitoramento completo** (Grafana, Prometheus, Node Exporter)
  - 🔍 **Análise de qualidade** (SonarQube + PostgreSQL)
  - 📦 **Repositório de artefatos** (Nexus Repository)

#### 🧪 **Branch STAGING** (Homologação)
- **Arquivo único consolidado:** `docker-compose.staging.yml`
- **Inclui:** Aplicações + Monitoramento (configurações otimizadas para staging)

#### 🚀 **Branch PROD** (Produção)
- **Arquivo único consolidado:** `docker-compose.prod.yml`
- **Inclui:** Aplicações + Monitoramento essencial (configurações de produção)

#### 📚 **Branch MASTER** (Documentação e referência)
- **Mantém todos os arquivos separados** para referência e documentação
- Arquivos individuais: `docker-compose.dev.yml`, `docker-compose.monitoring.yml`, `docker-compose.sonar.yml`, `docker-compose.nexus.yml`

### Instalação
#### Pré-requisitos
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

#### Clonar o repositório
```bash
git clone https://github.com/tobiasfkk/hotel-checkin-system
cd hotel-checkin-system
```

#### Executar ambiente de desenvolvimento (RECOMENDADO - Branch DEV)
```bash
# Mudar para branch de desenvolvimento
git checkout dev

# Iniciar ambiente COMPLETO com um comando só
docker-compose -f docker-compose.dev.yml up --build -d

# Inclui automaticamente:
# ✅ Aplicações principais (auth, booking, billing, gateway)
# ✅ Monitoramento (Grafana, Prometheus, Node Exporter)  
# ✅ Análise de qualidade (SonarQube + PostgreSQL)
# ✅ Repositório de artefatos (Nexus Repository)
```

#### Executar ambiente de staging
```bash
# Mudar para branch de staging
git checkout staging

# Iniciar ambiente de homologação
docker-compose -f docker-compose.staging.yml up --build -d
```

#### Executar ambiente de produção
```bash
# Mudar para branch de produção
git checkout prod

# Iniciar ambiente de produção
docker-compose -f docker-compose.prod.yml up --build -d
```

#### ⚡ **Vantagens da nova estrutura:**
- **🎯 Um comando só**: Não precisa mais gerenciar múltiplos arquivos docker-compose
- **🔧 Ambiente completo**: Tudo que você precisa em cada branch específica
- **📋 Gestão simplificada**: Cada ambiente tem seu arquivo consolidado
- **🚀 Deploy otimizado**: Configurações específicas para cada ambiente
- **📚 Documentação clara**: Master branch mantém arquivos separados para referência

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
    docker run -d --name jenkins -p 8081:8080 -v jenkins_home:/var/jenkins_home -v /var/run/docker.sock:/var/run/docker.sock --user root jenkins/jenkins:lts
#### Permitir uso do Docker no Jenkins
    docker exec -u root -it jenkins apt-get update
    docker exec -u root -it jenkins apt-get install -y docker.io
    docker exec -u root -it jenkins usermod -aG docker jenkins
    docker restart jenkins
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

---

## 🔄 **Como alternar entre ambientes**

### 📋 **Workflow recomendado:**

#### 1. **🔧 Desenvolvimento (Branch DEV)**
```bash
# Parar ambiente atual (se houver)
docker-compose down

# Mudar para branch de desenvolvimento  
git checkout dev

# Iniciar ambiente completo de desenvolvimento
docker-compose -f docker-compose.dev.yml up --build -d

# Acessar: http://localhost:8080
# Monitoramento: http://localhost:3000
# Qualidade: http://localhost:9000
# Artefatos: http://localhost:8081
```

#### 2. **🧪 Testes em Staging (Branch STAGING)**
```bash
# Parar ambiente de desenvolvimento
docker-compose -f docker-compose.dev.yml down

# Mudar para branch de staging
git checkout staging

# Iniciar ambiente de homologação
docker-compose -f docker-compose.staging.yml up --build -d

# Acessar: http://localhost:8080 (configurações de staging)
```

#### 3. **🚀 Deploy em Produção (Branch PROD)**
```bash
# Parar ambiente de staging
docker-compose -f docker-compose.staging.yml down

# Mudar para branch de produção
git checkout prod

# Iniciar ambiente de produção
docker-compose -f docker-compose.prod.yml up --build -d

# Acessar: http://localhost:8080 (configurações de produção)
```

### 🎯 **Diferenças entre ambientes:**

| Característica | 🔧 **DEV** | 🧪 **STAGING** | 🚀 **PROD** |
|---|---|---|---|
| **🔍 SonarQube** | ✅ Incluído | ❌ Não | ❌ Não |
| **📦 Nexus** | ✅ Incluído | ❌ Não | ❌ Não |
| **📊 Monitoramento** | ✅ Completo | ✅ Essencial | ✅ Essencial |
| **🗄️ Portas DB** | 3307/5432 | 3308/5433 | 3309/5434 |
| **🔧 Hot Reload** | ✅ Sim | ❌ Não | ❌ Não |
| **📋 Logs** | ✅ Verboso | ⚠️ Moderado | ❌ Mínimo |
| **🚀 Performance** | ⚠️ Desenvolvimento | ✅ Otimizado | ✅ Máximo |
