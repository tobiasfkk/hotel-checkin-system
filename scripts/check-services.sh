#!/bin/bash

echo "🚀 Verificando status do Hotel Check-in System..."
echo "================================================="

# Função para verificar se um serviço está rodando
check_service() {
    local url=$1
    local name=$2
    
    if curl -s -o /dev/null -w "%{http_code}" "$url" | grep -q "200\|302\|401"; then
        echo "✅ $name está FUNCIONANDO - $url"
    else
        echo "❌ $name NÃO está acessível - $url"
    fi
}

echo ""
echo "🏨 SISTEMA PRINCIPAL:"
check_service "http://localhost:8080" "API Gateway"

echo ""
echo "📊 MONITORAMENTO:"
check_service "http://localhost:3000" "Grafana"
check_service "http://localhost:9100/metrics" "Node Exporter"
check_service "http://localhost:8081/metrics" "cAdvisor"

echo ""
echo "🔍 QUALIDADE DE CÓDIGO:"
check_service "http://localhost:9000" "SonarQube"

echo ""
echo "🗄️ BANCOS DE DADOS:"
echo "📊 MySQL (Booking): localhost:3307"
echo "🔐 PostgreSQL (Auth): localhost:5432"
echo "🔍 SonarQube DB: localhost:5432"

echo ""
echo "📋 CONTAINERS RODANDO:"
docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"

echo ""
echo "================================================="
echo "🎯 PRÓXIMOS PASSOS:"
echo "1. Acesse http://localhost:8080 - Sistema Hotel"
echo "2. Acesse http://localhost:3000 - Grafana (admin/admin123)"
echo "3. Acesse http://localhost:9000 - SonarQube (admin/admin)"
echo "================================================="
