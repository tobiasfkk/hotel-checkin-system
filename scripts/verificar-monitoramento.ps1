# 🔍 Script de Verificação do Sistema de Monitoramento

Write-Host "🏨 Verificando Sistema de Monitoramento Hotel..." -ForegroundColor Cyan
Write-Host ""

# Verificar containers
Write-Host "📋 Verificando Containers:" -ForegroundColor Yellow
$containers = docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
Write-Host $containers

Write-Host ""

# Testar URLs
Write-Host "🌐 Testando Serviços:" -ForegroundColor Yellow

# Teste Prometheus
try {
    $prometheus = Invoke-WebRequest -Uri "http://localhost:9090" -TimeoutSec 5
    Write-Host "✅ Prometheus (9090): FUNCIONANDO" -ForegroundColor Green
} catch {
    Write-Host "❌ Prometheus (9090): ERRO" -ForegroundColor Red
}

# Teste Node Exporter
try {
    $nodeExporter = Invoke-WebRequest -Uri "http://localhost:9100/metrics" -TimeoutSec 5
    Write-Host "✅ Node Exporter (9100): FUNCIONANDO" -ForegroundColor Green
} catch {
    Write-Host "❌ Node Exporter (9100): ERRO" -ForegroundColor Red
}

# Teste Grafana
try {
    $grafana = Invoke-WebRequest -Uri "http://localhost:3000" -TimeoutSec 5
    Write-Host "✅ Grafana (3000): FUNCIONANDO" -ForegroundColor Green
} catch {
    Write-Host "❌ Grafana (3000): ERRO" -ForegroundColor Red
}

Write-Host ""
Write-Host "🎯 Próximos Passos:" -ForegroundColor Cyan
Write-Host "1. Acesse: http://localhost:3000"
Write-Host "2. Login: admin / admin123"
Write-Host "3. Dashboard: Hotel System Overview"
Write-Host "4. Aguarde 1-2 minutos para dados aparecerem"

Write-Host ""
Write-Host "📊 URLs Importantes:" -ForegroundColor Blue
Write-Host "Grafana: http://localhost:3000"
Write-Host "Prometheus: http://localhost:9090"
Write-Host "Node Exporter: http://localhost:9100"
Write-Host ""
