#!/bin/bash

# Script para gerar documentação automaticamente

echo "🚀 Gerando documentação do projeto..."

# Criar diretório de documentação
mkdir -p docs/{api,coverage,javadoc,swagger}

echo "📚 Gerando JavaDoc para billing-service..."
cd billing-service-java
./mvnw javadoc:javadoc
cp -r target/site/apidocs/* ../docs/javadoc/
cd ..

echo "📊 Copiando relatórios de cobertura..."
# PHP Services
if [ -d "auth-service-php/coverage-html" ]; then
    cp -r auth-service-php/coverage-html docs/coverage/auth-service/
fi

if [ -d "booking-service-php/coverage-html" ]; then
    cp -r booking-service-php/coverage-html docs/coverage/booking-service/
fi

# Java Service
if [ -d "billing-service-java/target/site/jacoco" ]; then
    cp -r billing-service-java/target/site/jacoco docs/coverage/billing-service/
fi

echo "📋 Gerando documentação da API..."
# Aqui você pode adicionar ferramentas como swagger-codegen
# ou scripts que extraem documentação das suas APIs

echo "🎯 Criando índice da documentação..."
cat > docs/index.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>Hotel Check-in System - Documentação</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #333; }
        .section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>🏨 Hotel Check-in System - Documentação</h1>
    
    <div class="section">
        <h2>📖 Documentação da API</h2>
        <ul>
            <li><a href="swagger/">Swagger UI</a> - Documentação interativa da API</li>
            <li><a href="api/">Documentação detalhada dos endpoints</a></li>
        </ul>
    </div>
    
    <div class="section">
        <h2>📊 Relatórios de Cobertura</h2>
        <ul>
            <li><a href="coverage/auth-service/">Auth Service</a> - Cobertura de testes</li>
            <li><a href="coverage/booking-service/">Booking Service</a> - Cobertura de testes</li>
            <li><a href="coverage/billing-service/">Billing Service</a> - Cobertura de testes</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>🔧 Documentação Técnica</h2>
        <ul>
            <li><a href="javadoc/">JavaDoc - Billing Service</a></li>
            <li><a href="../README.md">README do projeto</a></li>
        </ul>
    </div>
    
    <div class="section">
        <h2>🏗️ Arquitetura</h2>
        <ul>
            <li><a href="../docker-compose.yml">Docker Compose - Desenvolvimento</a></li>
            <li><a href="../docker-compose.prod.yml">Docker Compose - Produção</a></li>
            <li><a href="../k8s/">Arquivos Kubernetes</a></li>
        </ul>
    </div>
    
    <p><em>Documentação gerada automaticamente em: $(date)</em></p>
</body>
</html>
EOF

echo "✅ Documentação gerada com sucesso!"
echo "📂 Arquivos disponíveis em: ./docs/"
echo "🌐 Abra o arquivo docs/index.html no navegador"
