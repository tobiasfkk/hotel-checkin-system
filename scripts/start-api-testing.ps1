# Script para iniciar serviços e testar APIs

Write-Host "🚀 Iniciando serviços para testes de API..." -ForegroundColor Cyan

# Verificar se as dependências estão instaladas
Write-Host "📦 Verificando dependências..." -ForegroundColor Yellow

# Billing Service
Write-Host "⚡ Iniciando Billing Service (porta 8080)..." -ForegroundColor Green
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd 'billing-service-java'; ./mvnw.cmd spring-boot:run"

Start-Sleep -Seconds 3

# API Gateway
Write-Host "⚡ Iniciando API Gateway (porta 8081)..." -ForegroundColor Green
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd 'api-gateway-java'; ./mvnw.cmd spring-boot:run"

Write-Host "⏳ Aguardando serviços iniciarem (30 segundos)..." -ForegroundColor Yellow
Start-Sleep -Seconds 30

Write-Host "🌐 Testando APIs..." -ForegroundColor Cyan

# Testar se os serviços estão respondendo
try {
    $billingHealth = Invoke-RestMethod -Uri "http://localhost:8080/api/billing/health" -Method GET
    Write-Host "✅ Billing Service: $($billingHealth.status)" -ForegroundColor Green
} catch {
    Write-Host "❌ Billing Service não está respondendo" -ForegroundColor Red
}

try {
    $gatewayHealth = Invoke-RestMethod -Uri "http://localhost:8081/api/gateway/health" -Method GET
    Write-Host "✅ API Gateway: $($gatewayHealth.status)" -ForegroundColor Green
} catch {
    Write-Host "❌ API Gateway não está respondendo" -ForegroundColor Red
}

Write-Host ""
Write-Host "🧪 Centro de Testes disponível:" -ForegroundColor Cyan
Write-Host "� API Testing: docs/api-testing.html" -ForegroundColor Yellow
Write-Host ""
Write-Host "� Documentação:" -ForegroundColor Cyan
Write-Host "� Javadoc: docs/final/javadoc/index.html" -ForegroundColor Yellow
Write-Host "🏠 Principal: docs/final/index.html" -ForegroundColor Yellow
Write-Host ""
Write-Host "📊 Documentação completa: http://localhost:8090" -ForegroundColor Green

# Abrir centro de testes no navegador
Write-Host "🌐 Abrindo centro de testes no navegador..." -ForegroundColor Green
$testingFile = (Get-Location).Path + "\docs\api-testing.html"
Start-Process $testingFile
