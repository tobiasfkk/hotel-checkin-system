#!/usr/bin/env pwsh
# Script PowerShell para iniciar o Billing Service

Write-Host "🔧 Iniciando Billing Service..." -ForegroundColor Green
Write-Host "📂 Diretório: $(Get-Location)" -ForegroundColor Yellow
Write-Host ""
Write-Host "🌐 URLs importantes:" -ForegroundColor Cyan
Write-Host "   - API Health: http://localhost:8080/api/billing/health" -ForegroundColor White
Write-Host "   - API Base: http://localhost:8080/api/billing" -ForegroundColor White
Write-Host ""

# Verificar se Maven está disponível
if (Get-Command mvn -ErrorAction SilentlyContinue) {
    Write-Host "✅ Maven encontrado. Iniciando aplicação..." -ForegroundColor Green
    Write-Host ""
    & mvn spring-boot:run
} elseif (Test-Path ".\mvnw.cmd") {
    Write-Host "✅ Maven Wrapper encontrado. Iniciando aplicação..." -ForegroundColor Green
    Write-Host ""
    & .\mvnw.cmd spring-boot:run
} else {
    Write-Host "❌ Maven não encontrado. Instale Maven ou use o Maven Wrapper." -ForegroundColor Red
    exit 1
}
