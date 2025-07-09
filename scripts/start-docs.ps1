# Script para iniciar serviços com documentação Javadoc

Write-Host "🚀 Iniciando sistema completo com documentação..." -ForegroundColor Cyan

# Verificar se Docker está rodando
try {
    docker ps | Out-Null
    Write-Host "✅ Docker está rodando" -ForegroundColor Green
} catch {
    Write-Host "❌ Docker não está rodando. Por favor, inicie o Docker primeiro." -ForegroundColor Red
    exit 1
}

Write-Host "📚 Iniciando Billing Service..." -ForegroundColor Yellow
Set-Location billing-service-java
Start-Process powershell -ArgumentList "-NoExit", "-Command", "mvn spring-boot:run"
Set-Location ..

Write-Host "🌐 Iniciando API Gateway..." -ForegroundColor Yellow
Set-Location api-gateway-java
Start-Process powershell -ArgumentList "-NoExit", "-Command", "mvn spring-boot:run -Dspring-boot.run.arguments='--server.port=8081'"
Set-Location ..

Write-Host "⏳ Aguardando serviços iniciarem (30 segundos)..." -ForegroundColor Yellow
Start-Sleep -Seconds 30

Write-Host "🌐 Iniciando servidor de documentação..." -ForegroundColor Cyan
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd docs; npx http-server -p 8090"

Write-Host "🔍 Verificando se serviços estão online..." -ForegroundColor Cyan

# Verificar Billing Service
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8080/api/billing/health" -TimeoutSec 5
    Write-Host "✅ Billing Service está online" -ForegroundColor Green
} catch {
    Write-Host "⚠️ Billing Service ainda não está online" -ForegroundColor Yellow
}

# Verificar API Gateway
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8081/actuator/health" -TimeoutSec 5
    Write-Host "✅ API Gateway está online" -ForegroundColor Green
} catch {
    Write-Host "⚠️ API Gateway ainda não está online" -ForegroundColor Yellow
}

Write-Host "`n🎉 Sistema iniciado! Abrindo documentação..." -ForegroundColor Green

# Abrir URLs no navegador
$urls = @(
    "http://localhost:8090",                                    # Documentação principal
    "http://localhost:3000"                                     # Grafana (se estiver rodando)
)

foreach ($url in $urls) {
    try {
        Start-Process $url
        Write-Host "🌐 Abrindo: $url" -ForegroundColor Cyan
        Start-Sleep -Seconds 2
    } catch {
        Write-Host "⚠️ Não foi possível abrir: $url" -ForegroundColor Yellow
    }
}

Write-Host "`n📊 URLs importantes:" -ForegroundColor Green
Write-Host "📚 Documentação Geral: http://localhost:8090" -ForegroundColor White
Write-Host "🧪 Centro de Testes: docs/api-testing.html" -ForegroundColor White
Write-Host "� Javadoc: docs/final/javadoc/index.html" -ForegroundColor White
Write-Host "📈 Grafana: http://localhost:3000" -ForegroundColor White
Write-Host "🔍 SonarQube: http://localhost:9000" -ForegroundColor White

Write-Host "`n✨ Tudo pronto! A documentação Javadoc está sendo gerada automaticamente!" -ForegroundColor Green
