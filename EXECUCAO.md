# 🚀 GUIA COMPLETO DE EXECUÇÃO

## ⚡ COMANDOS PARA EXECUTAR TUDO

### 1️⃣ **Subir Sistema Principal**
```bash
# No diretório do projeto
docker-compose up -d
```

### 2️⃣ **Subir Monitoramento**
```bash
docker-compose -f docker-compose.monitoring.yml up -d
```

### 3️⃣ **Subir SonarQube (Opcional)**
```bash
docker-compose -f docker-compose.sonar.yml up -d
```

### 4️⃣ **Verificar Status**
```bash
docker ps
```

---

## 🌐 ACESSAR OS SERVIÇOS

| Serviço | URL | Credenciais | Descrição |
|---------|-----|-------------|-----------|
| **🏨 Sistema Hotel** | http://localhost:8080 | - | APIs do hotel |
| **📊 Grafana** | http://localhost:3000 | admin/admin123 | Dashboards |
| **🔍 SonarQube** | http://localhost:9000 | admin/admin | Qualidade código |
| **📈 Node Exporter** | http://localhost:9100 | - | Métricas sistema |
| **🐳 cAdvisor** | http://localhost:8081 | - | Métricas containers |

---

## 🧪 TESTAR AS APIs

### **Registrar Usuário**
```bash
curl -X POST http://localhost:8080/api/register \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Admin User",
    "email": "admin@hotel.com",
    "password": "123456",
    "role": "admin"
  }'
```

### **Login**
```bash
curl -X POST http://localhost:8080/api/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@hotel.com",
    "password": "123456"
  }'
```

### **Listar Pessoas (precisa do token)**
```bash
curl -X GET http://localhost:8080/api/pessoas \
  -H "Accept: application/json" \
  -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

---

## 📊 CONFIGURAR GRAFANA

### 1. **Acesse**: http://localhost:3000
### 2. **Login**: admin / admin123
### 3. **Dashboards disponíveis**:
   - Hotel System Overview (já configurado)
   - Docker Container Metrics
   - System Resources

### 4. **Adicionar novos dashboards**:
   - Vá em "+" → Import
   - Use IDs prontos:
     - **893** - Docker and System Monitoring
     - **1860** - Node Exporter Full
     - **179** - Docker Host & Container Overview

---

## 🔍 CONFIGURAR SONARQUBE

### 1. **Acesse**: http://localhost:9000
### 2. **Login inicial**: admin / admin
### 3. **Criar token**:
   - User → My Account → Security → Generate Token
### 4. **Analisar código Java**:
```bash
cd billing-service-java
./mvnw sonar:sonar \
  -Dsonar.token=SEU_TOKEN \
  -Dsonar.host.url=http://localhost:9000 \
  -Dsonar.projectKey=hotel-billing
```

---

## 🗄️ CONECTAR BANCOS

### **MySQL (Booking)**
- **Host**: localhost:3307
- **Database**: bookingdb
- **User**: root
- **Password**: root

### **PostgreSQL (Auth)**
- **Host**: localhost:5432
- **Database**: authdb
- **User**: postgres
- **Password**: root

---

## 🐛 SOLUÇÃO DE PROBLEMAS

### **Containers não sobem**
```bash
# Ver logs
docker-compose logs

# Recriar containers
docker-compose down
docker-compose up -d --build
```

### **Porta ocupada**
```bash
# Ver o que está usando a porta
netstat -ano | findstr :8080

# Matar processo
taskkill /PID NUMERO_PID /F
```

### **Limpar tudo e recomeçar**
```bash
# Para todos containers
docker-compose down
docker-compose -f docker-compose.monitoring.yml down
docker-compose -f docker-compose.sonar.yml down

# Remove volumes (CUIDADO: apaga dados)
docker volume prune

# Sobe tudo novamente
docker-compose up -d
docker-compose -f docker-compose.monitoring.yml up -d
```

---

## 🎯 PIPELINE JENKINS

### **1. Configurar Jenkins**
```bash
# Subir Jenkins
docker run -d --name jenkins -p 8081:8080 -v jenkins_home:/var/jenkins_home jenkins/jenkins:lts

# Obter senha inicial
docker exec jenkins cat /var/jenkins_home/secrets/initialAdminPassword
```

### **2. Configurar Credenciais**
- DockerHub: `dockerhub-credentials-id`
- SonarQube: `sonar-token`

### **3. Criar Pipeline**
- New Item → Pipeline
- Pipeline script from SCM
- Git: seu repositório
- Script Path: Jenkinsfile

---

## ✅ CHECKLIST DE VERIFICAÇÃO

- [ ] Docker está instalado e rodando
- [ ] Containers principais estão UP
- [ ] API Gateway responde em :8080
- [ ] Grafana acessível em :3000
- [ ] SonarQube acessível em :9000
- [ ] APIs retornam dados corretos
- [ ] Dashboards mostram métricas
- [ ] Bancos de dados conectáveis

---

## 🎉 PARABÉNS!

Se tudo estiver funcionando, você agora tem:

✅ **Sistema de hotel completo**
✅ **Monitoramento profissional**
✅ **Análise de qualidade de código**
✅ **Pipeline CI/CD configurada**
✅ **Múltiplos ambientes**
✅ **Documentação automática**
✅ **Infraestrutura como código**

**Seu projeto está PRONTO para produção!** 🚀
