# Script PowerShell para gerar documentação automaticamente

Write-Host "🚀 Gerando documentação do projeto..." -ForegroundColor Cyan

# Criar diretório de documentação
if (-not (Test-Path "docs")) {
    New-Item -ItemType Directory -Path "docs" -Force
}

@("api", "coverage", "javadoc", "php-docs") | ForEach-Object {
    if (-not (Test-Path "docs\$_")) {
        New-Item -ItemType Directory -Path "docs\$_" -Force
    }
}

Write-Host "📚 Gerando JavaDoc para billing-service..." -ForegroundColor Green
Set-Location billing-service-java
& ./mvnw.cmd javadoc:javadoc
& ./mvnw.cmd jacoco:report
if (Test-Path "target\site\apidocs") {
    Copy-Item -Path "target\site\apidocs\*" -Destination "..\docs\javadoc\" -Recurse -Force
}
if (Test-Path "target\site\jacoco") {
    Copy-Item -Path "target\site\jacoco\*" -Destination "..\docs\coverage\billing-service\" -Recurse -Force
}
Set-Location ..

Write-Host "📚 Gerando JavaDoc para api-gateway..." -ForegroundColor Green
Set-Location api-gateway-java
& ./mvnw.cmd javadoc:javadoc
if (Test-Path "target\site\apidocs") {
    Copy-Item -Path "target\site\apidocs\*" -Destination "..\docs\javadoc\api-gateway\" -Recurse -Force
}
Set-Location ..

Write-Host "📊 Gerando documentação PHP..." -ForegroundColor Green
# Auth Service PHP
Set-Location auth-service-php
if (Test-Path "vendor\bin\phpdoc") {
    & vendor\bin\phpdoc -d app -t ..\docs\php-docs\auth-service --template responsive-twig
} else {
    Write-Host "⚠️ PHPDocumentor não encontrado. Execute: composer require --dev phpdocumentor/phpdocumentor" -ForegroundColor Yellow
}
Set-Location ..

# Booking Service PHP
Set-Location booking-service-php\src
if (Test-Path "vendor\bin\phpdoc") {
    & vendor\bin\phpdoc -d app -t ..\..\docs\php-docs\booking-service --template responsive-twig
} else {
    Write-Host "⚠️ PHPDocumentor não encontrado. Execute: composer require --dev phpdocumentor/phpdocumentor" -ForegroundColor Yellow
}
Set-Location ..\..

Write-Host "📋 Copiando relatórios de cobertura..." -ForegroundColor Green
# PHP Services
if (Test-Path "auth-service-php\coverage-html") {
    Copy-Item -Path "auth-service-php\coverage-html\*" -Destination "docs\coverage\auth-service\" -Recurse -Force
}

if (Test-Path "booking-service-php\src\coverage-html") {
    Copy-Item -Path "booking-service-php\src\coverage-html\*" -Destination "docs\coverage\booking-service\" -Recurse -Force
}

Write-Host "🎯 Criando índice da documentação..." -ForegroundColor Green
$indexContent = @"
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Check-in System - Documentação</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 10px; margin-bottom: 30px; text-align: center; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 10px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease; }
        .card:hover { transform: translateY(-5px); }
        .card h3 { color: #333; margin-bottom: 15px; display: flex; align-items: center; }
        .card h3::before { content: '📚'; margin-right: 10px; font-size: 1.2em; }
        .card ul { list-style: none; }
        .card li { margin: 10px 0; }
        .card a { color: #667eea; text-decoration: none; padding: 8px 12px; display: block; border-radius: 5px; transition: background 0.3s ease; }
        .card a:hover { background: #f0f2ff; }
        .status { text-align: center; margin-top: 30px; padding: 20px; background: #e8f5e8; border-radius: 10px; }
        .badge { display: inline-block; background: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8em; margin-left: 8px; }
        .badge.warning { background: #ffc107; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏨 Hotel Check-in System</h1>
            <p>Documentação Técnica Completa</p>
            <p><em>Gerada automaticamente em: $(Get-Date -Format "dd/MM/yyyy HH:mm:ss")</em></p>
        </div>
        
        <div class="grid">
            <div class="card">
                <h3>📖 Documentação da API</h3>
                <ul>
                    <li><a href="api/">Centro de Testes Manual</a> <span class="badge">Manual</span></li>
                    <li><a href="api/">Documentação dos Endpoints</a></li>
                    <li><a href="../postman/">Collections Postman</a> <span class="badge warning">Manual</span></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>📊 Relatórios de Cobertura</h3>
                <ul>
                    <li><a href="coverage/auth-service/">Auth Service (PHP)</a> <span class="badge">Auto</span></li>
                    <li><a href="coverage/booking-service/">Booking Service (PHP)</a> <span class="badge">Auto</span></li>
                    <li><a href="coverage/billing-service/">Billing Service (Java)</a> <span class="badge">Auto</span></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>🔧 Documentação de Código</h3>
                <ul>
                    <li><a href="javadoc/">JavaDoc - Billing Service</a> <span class="badge">Auto</span></li>
                    <li><a href="javadoc/api-gateway/">JavaDoc - API Gateway</a> <span class="badge">Auto</span></li>
                    <li><a href="php-docs/auth-service/">PHPDoc - Auth Service</a> <span class="badge">Auto</span></li>
                    <li><a href="php-docs/booking-service/">PHPDoc - Booking Service</a> <span class="badge">Auto</span></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>🏗️ Arquitetura e DevOps</h3>
                <ul>
                    <li><a href="../README.md">README Principal</a></li>
                    <li><a href="../docker-compose.yml">Docker Compose - Dev</a></li>
                    <li><a href="../docker-compose.prod.yml">Docker Compose - Prod</a></li>
                    <li><a href="../k8s/">Manifests Kubernetes</a></li>
                    <li><a href="../Jenkinsfile">Pipeline CI/CD</a></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>📈 Monitoramento</h3>
                <ul>
                    <li><a href="http://localhost:3000">Grafana Dashboard</a></li>
                    <li><a href="http://localhost:9090">Prometheus Metrics</a></li>
                    <li><a href="http://localhost:9000">SonarQube Reports</a></li>
                    <li><a href="../monitoring/">Configurações</a></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>🧪 Testes e Qualidade</h3>
                <ul>
                    <li><a href="coverage/">Cobertura de Testes</a> <span class="badge">Auto</span></li>
                    <li><a href="http://localhost:9000">SonarQube Quality</a> <span class="badge">Auto</span></li>
                    <li><a href="../phpunit.xml">Configuração PHPUnit</a></li>
                    <li><a href="../scripts/run-tests.ps1">Scripts de Teste</a></li>
                </ul>
            </div>
        </div>
        
        <div class="status">
            <h2>✅ Status da Documentação</h2>
            <p><strong>Documentação automática ativa!</strong> A documentação é gerada automaticamente a cada build via Jenkins.</p>
            <p>Para regenerar manualmente: <code>.\scripts\generate-docs.ps1</code></p>
        </div>
    </div>
</body>
</html>
"@

$indexContent | Out-File -FilePath "docs\index.html" -Encoding UTF8

Write-Host "🌐 Gerando servidor de documentação local..." -ForegroundColor Green
$serverScript = @"
# Servidor HTTP simples para documentação
`$port = 8090
`$path = (Get-Location).Path + '\docs'

Write-Host "🌐 Iniciando servidor de documentação..." -ForegroundColor Cyan
Write-Host "📂 Pasta: `$path" -ForegroundColor Yellow
Write-Host "🔗 URL: http://localhost:`$port" -ForegroundColor Green
Write-Host "⏹️ Para parar: Ctrl+C" -ForegroundColor Red

Set-Location "`$path"
python -m http.server `$port
"@

$serverScript | Out-File -FilePath "scripts\serve-docs.ps1" -Encoding UTF8

Write-Host "✅ Documentação gerada com sucesso!" -ForegroundColor Green
Write-Host "📂 Arquivos disponíveis em: .\docs\" -ForegroundColor Yellow
Write-Host "🌐 Para servir: .\scripts\serve-docs.ps1" -ForegroundColor Cyan
Write-Host "🔗 URL local: http://localhost:8090" -ForegroundColor Green
