# Script PowerShell para verificar serviços
Write-Host "🚀 Verificando status do Hotel Check-in System..." -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Yellow

function Test-Service {
    param(
        [string]$Url,
        [string]$Name
    )
    
    try {
        $response = Invoke-WebRequest -Uri $Url -TimeoutSec 5 -UseBasicParsing
        if ($response.StatusCode -eq 200 -or $response.StatusCode -eq 302 -or $response.StatusCode -eq 401) {
            Write-Host "✅ $Name está FUNCIONANDO - $Url" -ForegroundColor Green
        } else {
            Write-Host "❌ $Name retornou código $($response.StatusCode) - $Url" -ForegroundColor Red
        }
    }
    catch {
        Write-Host "❌ $Name NÃO está acessível - $Url" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "🏨 SISTEMA PRINCIPAL:" -ForegroundColor Cyan
Test-Service -Url "http://localhost:8080" -Name "API Gateway"

Write-Host ""
Write-Host "📊 MONITORAMENTO:" -ForegroundColor Cyan
Test-Service -Url "http://localhost:3000" -Name "Grafana"
Test-Service -Url "http://localhost:9100/metrics" -Name "Node Exporter"
Test-Service -Url "http://localhost:8081/metrics" -Name "cAdvisor"

Write-Host ""
Write-Host "🔍 QUALIDADE DE CÓDIGO:" -ForegroundColor Cyan
Test-Service -Url "http://localhost:9000" -Name "SonarQube"

Write-Host ""
Write-Host "🗄️ BANCOS DE DADOS:" -ForegroundColor Cyan
Write-Host "📊 MySQL (Booking): localhost:3307" -ForegroundColor Yellow
Write-Host "🔐 PostgreSQL (Auth): localhost:5432" -ForegroundColor Yellow

Write-Host ""
Write-Host "📋 CONTAINERS RODANDO:" -ForegroundColor Cyan
docker ps --format "table {{.Names}}`t{{.Status}}`t{{.Ports}}"

Write-Host ""
Write-Host "=================================================" -ForegroundColor Yellow
Write-Host "🎯 PRÓXIMOS PASSOS:" -ForegroundColor Green
Write-Host "1. Acesse http://localhost:8080 - Sistema Hotel" -ForegroundColor White
Write-Host "2. Acesse http://localhost:3000 - Grafana (admin/admin123)" -ForegroundColor White
Write-Host "3. Acesse http://localhost:9000 - SonarQube (admin/admin)" -ForegroundColor White
Write-Host "=================================================" -ForegroundColor Yellow
