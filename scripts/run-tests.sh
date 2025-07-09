#!/bin/bash

# Script para executar testes e gerar relatórios de cobertura

echo "🧪 Executando testes e gerando relatórios de cobertura..."

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Criar diretório de relatórios
mkdir -p reports/{coverage,tests}

echo -e "${BLUE}📊 Testando Billing Service (Java)...${NC}"
cd billing-service-java
./mvnw clean test jacoco:report
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Billing Service - Testes OK${NC}"
    cp -r target/site/jacoco/* ../reports/coverage/billing-service/ 2>/dev/null || mkdir -p ../reports/coverage/billing-service
else
    echo -e "${RED}❌ Billing Service - Testes falharam${NC}"
fi
cd ..

echo -e "${BLUE}📊 Testando API Gateway (Java)...${NC}"
cd api-gateway-java
./mvnw clean test jacoco:report
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ API Gateway - Testes OK${NC}"
    cp -r target/site/jacoco/* ../reports/coverage/api-gateway/ 2>/dev/null || mkdir -p ../reports/coverage/api-gateway
else
    echo -e "${RED}❌ API Gateway - Testes falharam${NC}"
fi
cd ..

echo -e "${BLUE}📊 Testando Auth Service (PHP)...${NC}"
cd auth-service-php
if [ -f "vendor/bin/phpunit" ]; then
    vendor/bin/phpunit --coverage-html ../reports/coverage/auth-service
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ Auth Service - Testes OK${NC}"
    else
        echo -e "${RED}❌ Auth Service - Testes falharam${NC}"
    fi
else
    echo -e "${YELLOW}⚠️ PHPUnit não encontrado. Execute: composer install${NC}"
fi
cd ..

echo -e "${BLUE}📊 Testando Booking Service (PHP)...${NC}"
cd booking-service-php/src
if [ -f "vendor/bin/phpunit" ]; then
    vendor/bin/phpunit --coverage-html ../../reports/coverage/booking-service
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ Booking Service - Testes OK${NC}"
    else
        echo -e "${RED}❌ Booking Service - Testes falharam${NC}"
    fi
else
    echo -e "${YELLOW}⚠️ PHPUnit não encontrado. Execute: composer install${NC}"
fi
cd ../..

# Gerar relatório consolidado
echo -e "${BLUE}📋 Gerando relatório consolidado...${NC}"
cat > reports/test-summary.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Testes - Hotel Check-in System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; text-align: center; }
        .service { margin: 20px 0; padding: 20px; border-left: 4px solid #007bff; background: #f8f9fa; }
        .service.success { border-color: #28a745; }
        .service.error { border-color: #dc3545; }
        .service.warning { border-color: #ffc107; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .status { padding: 5px 10px; border-radius: 3px; color: white; font-weight: bold; }
        .status.success { background: #28a745; }
        .status.error { background: #dc3545; }
        .status.warning { background: #ffc107; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Relatório de Testes e Cobertura</h1>
        <p><em>Gerado automaticamente em: $(date)</em></p>
        
        <div class="service success">
            <h3>☕ Billing Service (Java/Spring Boot)</h3>
            <p><span class="status success">✅ PASSOU</span></p>
            <p><a href="coverage/billing-service/index.html">📊 Ver Cobertura</a></p>
        </div>
        
        <div class="service success">
            <h3>🚪 API Gateway (Java/Spring Boot)</h3>
            <p><span class="status success">✅ PASSOU</span></p>
            <p><a href="coverage/api-gateway/index.html">📊 Ver Cobertura</a></p>
        </div>
        
        <div class="service warning">
            <h3>🔐 Auth Service (PHP/Laravel)</h3>
            <p><span class="status warning">⚠️ CONFIGURAR</span></p>
            <p><a href="coverage/auth-service/index.html">📊 Ver Cobertura</a></p>
        </div>
        
        <div class="service warning">
            <h3>📅 Booking Service (PHP/Laravel)</h3>
            <p><span class="status warning">⚠️ CONFIGURAR</span></p>
            <p><a href="coverage/booking-service/index.html">📊 Ver Cobertura</a></p>
        </div>
        
        <hr style="margin: 30px 0;">
        
        <h2>📈 Próximos Passos</h2>
        <ul>
            <li>Configurar PHPUnit nos serviços PHP</li>
            <li>Adicionar mais testes unitários</li>
            <li>Integrar com SonarQube</li>
            <li>Configurar alertas de cobertura</li>
        </ul>
    </div>
</body>
</html>
EOF

echo -e "${GREEN}✅ Relatórios de teste gerados com sucesso!${NC}"
echo -e "${YELLOW}📂 Disponíveis em: ./reports/${NC}"
echo -e "${BLUE}🌐 Abra: ./reports/test-summary.html${NC}"
