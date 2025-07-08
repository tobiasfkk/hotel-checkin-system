# 📊 Monitoramento com Grafana

## O que foi implementado?

### **Grafana Only** - Solução Simplificada ✨

Optamos por usar **apenas o Grafana** porque:

✅ **Mais simples de configurar**
✅ **Interface visual excelente** 
✅ **Dashboards prontos e personalizáveis**
✅ **Alertas visuais integrados**
✅ **Coleta dados diretamente dos exporters**

## 🚀 Como executar?

```bash
# Subir o monitoramento
docker-compose -f docker-compose.monitoring.yml up -d

# Acessar Grafana
# URL: http://localhost:3000
# User: admin
# Password: admin123
```

## 📊 O que está sendo monitorado?

### **1. Node Exporter (Sistema)**
- **CPU Usage**: Uso do processador
- **Memory Usage**: Uso da memória RAM
- **Disk Usage**: Espaço em disco
- **Network Traffic**: Tráfego de rede

### **2. cAdvisor (Containers)**
- **Container CPU**: CPU por container
- **Container Memory**: Memória por container
- **Container Status**: Status dos containers
- **Container Restart**: Quantas vezes reiniciou

## 🎯 Dashboards Disponíveis

### **Hotel System Overview**
Dashboard principal com:
- Status geral do sistema
- Gráficos de CPU e Memória
- Alertas visuais

## ⚡ Portas Utilizadas

| Serviço | Porta | Descrição |
|---------|-------|-----------|
| Grafana | 3000 | Interface principal |
| Node Exporter | 9100 | Métricas do sistema |
| cAdvisor | 8081 | Métricas dos containers |

## 🔧 Configuração

### **Data Sources (Fontes de Dados)**
- **NodeExporter**: http://node-exporter:9100
- **cAdvisor**: http://cadvisor:8080

### **Dashboards**
- Localização: `monitoring/grafana/dashboards/`
- Auto-carregamento: ✅ Ativado
- Personalizáveis: ✅ Sim

## 📈 Benefícios desta Configuração

1. **Simplicidade**: Menos componentes = menos problemas
2. **Visual**: Dashboards bonitos e informativos
3. **Alertas**: Notificações quando algo está errado
4. **Performance**: Monitoramento em tempo real
5. **Escalabilidade**: Fácil adicionar novas métricas

## 🎨 Customização

Para adicionar novos dashboards:
1. Acesse http://localhost:3000
2. Crie/importe dashboards
3. Salve na pasta `monitoring/grafana/dashboards/`

## 🚨 Alertas

O Grafana pode enviar alertas para:
- **Email**
- **Slack** 
- **Discord**
- **Webhook personalizado**

---

**💡 Dica**: O Grafana já vem com templates prontos para Docker, Kubernetes e aplicações web!
