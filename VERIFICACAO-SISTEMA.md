# 🔍 Como Verificar se o Sistema Está Funcionando

## 📋 Checklist Rápido

### ✅ 1. Verificar Containers
```powershell
# Listar todos os containers
docker ps

# Devem estar rodando:
# - API Gateway (porta 8080)
# - Grafana (porta 3000) 
# - Node Exporter (porta 9100)
# - cAdvisor (porta 8081)
```

### ✅ 2. Testar Acessos Web
```
✅ API Gateway: http://localhost:8080
✅ Grafana: http://localhost:3000 (admin/admin123)
✅ Node Exporter: http://localhost:9100/metrics
✅ cAdvisor: http://localhost:8081/containers/
```

### ✅ 3. Verificar Dashboard Grafana
1. Acesse: http://localhost:3000
2. Login: `admin` / `admin123`
3. Vá para: **Dashboards → Hotel System Overview**
4. Deve mostrar gráficos com dados

---

## 🐛 Troubleshooting

### ❌ Problema: Grafana não carrega
```powershell
# Verificar logs
docker logs hotel-monitoring-grafana-1

# Reiniciar serviço
docker-compose -f docker-compose.monitoring.yml restart grafana
```

### ❌ Problema: Dashboard vazio (sem métricas)
```powershell
# Verificar se Node Exporter está funcionando
curl http://localhost:9100/metrics

# Verificar logs do Node Exporter
docker logs hotel-monitoring-node-exporter-1

# Reiniciar monitoramento completo
docker-compose -f docker-compose.monitoring.yml down
docker-compose -f docker-compose.monitoring.yml up -d
```

### ❌ Problema: Containers não sobem
```powershell
# Verificar portas em uso
netstat -an | findstr "3000\|8080\|9100\|8081"

# Parar tudo e recriar
docker-compose -f docker-compose.monitoring.yml down --volumes
docker-compose -f docker-compose.monitoring.yml up --build -d
```

---

## 📊 Como Interpretar as Métricas

### **💻 CPU Usage**
- **0-70%:** ✅ Normal
- **70-85%:** ⚠️ Atenção  
- **85%+:** 🚨 Crítico

### **🧠 Memory Usage**
- **Azul:** Memória usada
- **Verde:** Memória disponível
- **Ação:** Se >90% usado, precisa mais RAM

### **🐳 Docker Containers**
- **Número de containers ativos**
- **CPU por container**
- **Se algum sumir:** Container parou

### **📊 Status dos Serviços**
- **Verde (1):** ✅ Online
- **Vermelho (0):** ❌ Offline

---

## 🎯 Comandos Úteis

### **Verificar Status Geral**
```powershell
# Rodar script de verificação
.\scripts\check-services.ps1

# Ou manualmente:
docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
```

### **Logs dos Serviços**
```powershell
# Logs do Grafana
docker logs hotel-monitoring-grafana-1 -f

# Logs do Node Exporter  
docker logs hotel-monitoring-node-exporter-1 -f

# Logs da API Gateway
docker logs hotel-checkin-system-api-gateway-1 -f
```

### **Reiniciar Serviços**
```powershell
# Reiniciar apenas monitoramento
docker-compose -f docker-compose.monitoring.yml restart

# Reiniciar tudo
docker-compose restart
```

---

## 🚀 Teste de Funcionalidade Completa

### **1. Teste API Gateway**
```powershell
# Deve retornar página web ou JSON
curl http://localhost:8080
```

### **2. Teste Métricas Node Exporter**
```powershell
# Deve retornar muitas linhas de métricas
curl http://localhost:9100/metrics | Select-Object -First 10
```

### **3. Teste Grafana Dashboard**
1. **Acesse:** http://localhost:3000
2. **Login:** admin/admin123
3. **Dashboard:** Hotel System Overview
4. **Verifique:** Gráficos com dados (não vazios)

### **4. Teste Alertas (Opcional)**
1. **Grafana → Alerting → Alert Rules**
2. **Criar regra simples:** CPU > 1%
3. **Verificar se dispara**

---

## ✨ Sinais de que TUDO está funcionando

### ✅ **Containers**
```
hotel-checkin-system-api-gateway-1    Up 5 minutes    0.0.0.0:8080->8080/tcp
hotel-monitoring-grafana-1            Up 5 minutes    0.0.0.0:3000->3000/tcp
hotel-monitoring-node-exporter-1      Up 5 minutes    0.0.0.0:9100->9100/tcp
hotel-monitoring-cadvisor-1           Up 5 minutes    0.0.0.0:8081->8080/tcp
```

### ✅ **URLs Funcionando**
- http://localhost:8080 → API Gateway respondendo
- http://localhost:3000 → Grafana carregando
- http://localhost:9100 → Node Exporter com métricas
- http://localhost:8081 → cAdvisor com containers

### ✅ **Dashboard Grafana**
- Login funciona
- Dashboard "Hotel System Overview" existe
- Gráficos mostram dados (linhas nos gráficos)
- Status dos serviços em verde

### ✅ **Métricas Fluindo**
- CPU Usage mostra percentual real
- Memory Usage mostra dados de memória
- Docker Containers mostra número de containers
- Status Services todos verdes

---

## 🆘 Em caso de dúvidas

1. **Verifique logs:** `docker logs [container-name]`
2. **Reinicie serviços:** `docker-compose restart`
3. **Consulte:** [GUIA-GRAFANA.md](./GUIA-GRAFANA.md)
4. **Verifique portas:** Nada mais usando 3000, 8080, 9100, 8081

**🎉 Se tudo acima está OK, seu sistema de monitoramento está perfeito!**
