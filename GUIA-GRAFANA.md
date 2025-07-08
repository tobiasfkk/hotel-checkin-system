# 📊 Guia Completo do Grafana - Sistema Hotel Check-in

## 🎯 O que é o Grafana?

O **Grafana** é uma plataforma de visualização e análise de dados que permite criar dashboards interativos e alertas em tempo real. No seu sistema de hotel, ele serve como o "painel de controle" que mostra a saúde e performance de todos os serviços.

---

## 🚀 Para que serve o Grafana no seu projeto?

### 1. **📈 Monitoramento em Tempo Real**
- Visualiza CPU, memória e rede do servidor
- Monitora status dos containers Docker
- Acompanha performance da API Gateway
- Detecta problemas antes que afetem os usuários

### 2. **🔍 Análise de Performance**
- Identifica gargalos de performance
- Monitora tempo de resposta das APIs
- Analisa padrões de uso do sistema
- Otimiza recursos baseado em dados reais

### 3. **🚨 Alertas Inteligentes**
- Notifica quando CPU/memória estão altos
- Alerta sobre falhas de serviços
- Avisa sobre indisponibilidade de containers
- Envia notificações via email/Slack/Discord

### 4. **📋 Relatórios e Insights**
- Gera relatórios de uptime
- Analisa tendências de uso
- Documenta incidentes
- Ajuda na tomada de decisões

---

## 🎮 Como usar o Grafana

### **Acesso Inicial**
```
URL: http://localhost:3000
Usuário: admin
Senha: admin123
```

### **1. 🏠 Dashboard Principal (Hotel Overview)**
- **Localização:** http://localhost:3000/d/hotel-overview
- **Função:** Visão geral do sistema
- **O que mostra:**
  - Status dos serviços
  - Uso de CPU e memória
  - Containers Docker ativos
  - Guias de uso

### **2. 🔍 Explore (Consultas Dinâmicas)**
- **Como acessar:** Menu lateral → Explore
- **Função:** Fazer consultas personalizadas
- **Exemplos de consultas:**
  ```
  # CPU do sistema
  100 - (avg(rate(node_cpu_seconds_total{mode="idle"}[5m])) * 100)
  
  # Memória usada
  (1 - (node_memory_MemAvailable_bytes / node_memory_MemTotal_bytes)) * 100
  
  # Containers ativos
  count(container_last_seen)
  ```

### **3. 🚨 Alerting (Configurar Alertas)**
- **Como acessar:** Menu lateral → Alerting
- **Configurações básicas:**
  1. **Contact Points** → Onde enviar alertas (email, Slack)
  2. **Notification Policies** → Quando e como alertar
  3. **Alert Rules** → Regras de quando disparar

### **4. ⚙️ Data Sources (Fontes de Dados)**
- **Prometheus:** Já configurado automaticamente
- **URL:** http://prometheus:9090
- **Função:** Coleta métricas do sistema

---

## 📊 Entendendo os Gráficos

### **💻 CPU Usage**
- **Verde (0-70%):** Normal
- **Amarelo (70-85%):** Atenção
- **Vermelho (85%+):** Crítico
- **Ação:** Se ficar alto, verificar processos

### **🧠 Memory Usage**
- **Azul:** Memória usada
- **Verde:** Memória disponível
- **Ação:** Se usar >90%, adicionar mais RAM

### **🐳 Docker Containers**
- **Linha por container:** Cada serviço
- **Picos:** Momentos de alta atividade
- **Ação:** Identificar containers problemáticos

### **📊 Status dos Serviços**
- **Verde:** Serviço online
- **Vermelho:** Serviço offline
- **Ação:** Investigar serviços offline

---

## 🛠️ Personalizações Avançadas

### **Criar Novo Dashboard**
1. **Dashboards** → **New** → **New dashboard**
2. **Add visualization** → Escolher tipo de gráfico
3. **Configure query** → Escrever consulta Prometheus
4. **Save dashboard** → Dar nome e salvar

### **Adicionar Alertas**
1. Entrar em um painel
2. **Edit** → **Alert** → **Create alert rule**
3. Definir condição (ex: CPU > 80%)
4. Escolher contact point
5. **Save rule**

### **Importar Dashboards Prontos**
1. **Dashboards** → **New** → **Import**
2. **Grafana.com ID:** 1860 (Node Exporter)
3. **Load** → **Import**

---

## 🎯 Cenários Práticos de Uso

### **Scenario 1: Sistema Lento**
1. **Verificar CPU:** Está alto?
2. **Verificar Memória:** Está esgotada?
3. **Verificar Containers:** Algum travado?
4. **Ação:** Reiniciar container ou adicionar recursos

### **Scenario 2: API não responde**
1. **Status dos Serviços:** API Gateway está verde?
2. **Docker Containers:** Container da API está ativo?
3. **Logs:** Verificar logs do container
4. **Ação:** Reiniciar serviço ou investigar código

### **Scenario 3: Preparar para alta demanda**
1. **Histórico:** Analisar padrões passados
2. **Tendências:** Ver crescimento de uso
3. **Alertas:** Configurar para picos
4. **Ação:** Escalar recursos preventivamente

---

## 🔧 Comandos Úteis

### **Verificar Serviços**
```powershell
# Status dos containers
docker ps

# Logs do Grafana
docker logs hotel-monitoring-grafana-1

# Reiniciar Grafana
docker-compose -f docker-compose.monitoring.yml restart grafana
```

### **Troubleshooting**
```powershell
# Se Grafana não carregar
docker-compose -f docker-compose.monitoring.yml down
docker-compose -f docker-compose.monitoring.yml up -d

# Verificar conectividade Prometheus
curl http://localhost:9090/api/v1/query?query=up
```

---

## 📱 Próximos Passos

### **🎨 Melhorias de Dashboard**
- [ ] Adicionar gráficos de rede
- [ ] Incluir métricas de disk I/O
- [ ] Criar dashboard específico para cada serviço
- [ ] Adicionar variáveis de template

### **🚨 Alertas Avançados**
- [ ] Configurar Slack/Discord
- [ ] Criar escalação de alertas
- [ ] Implementar alertas preditivos
- [ ] Dashboard de incidents

### **📊 Métricas de Negócio**
- [ ] Contador de check-ins por hora
- [ ] Tempo médio de resposta das APIs
- [ ] Taxa de erro das requisições
- [ ] Métricas de usuário logado

---

## 🆘 Links Úteis

- **Grafana Dashboard:** http://localhost:3000
- **Prometheus Metrics:** http://localhost:9090
- **Node Exporter:** http://localhost:9100
- **cAdvisor:** http://localhost:8081
- **API Gateway:** http://localhost:8080

### **Documentação**
- [Grafana Documentation](https://grafana.com/docs/)
- [Prometheus Queries](https://prometheus.io/docs/prometheus/latest/querying/)
- [Dashboard Best Practices](https://grafana.com/docs/grafana/latest/best-practices/)

---

## 💡 Dicas Profissionais

1. **🔄 Refresh automático:** Use 30s-5min para dashboards de produção
2. **📋 Organize painéis:** Agrupe por função (sistema, aplicação, negócio)
3. **🎨 Use cores consistentes:** Verde=ok, Amarelo=atenção, Vermelho=crítico
4. **📱 Mobile friendly:** Configure para visualizar no celular
5. **🔐 Permissions:** Configure usuários com acesso limitado
6. **💾 Backup:** Exporte dashboards importantes regularmente

**🚀 Agora você tem um sistema de monitoramento profissional para seu hotel!**
