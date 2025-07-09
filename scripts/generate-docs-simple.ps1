# Script simples para gerar documentação básica

Write-Host "🚀 Gerando documentação básica..." -ForegroundColor Cyan

# Criar estrutura de diretórios
$dirs = @("docs", "docs\api", "docs\coverage", "docs\javadoc")
foreach ($dir in $dirs) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
    }
}

# Gerar página principal
$indexContent = @'
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
            <p><em>Gerada automaticamente</em></p>
        </div>
        
        <div class="grid">
            <div class="card">
                <h3>📖 Documentação da API</h3>
                <ul>
                    <li><a href="../docs/api-testing.html">Centro de Testes Manual</a> <span class="badge">Manual</span></li>
                    <li><a href="api/">Documentação dos Endpoints</a></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>📊 Relatórios de Cobertura</h3>
                <ul>
                    <li><a href="coverage/billing-service/">Billing Service</a></li>
                    <li><a href="coverage/api-gateway/">API Gateway</a></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>🔧 Documentação de Código</h3>
                <ul>
                    <li><a href="javadoc/">JavaDoc - Billing Service</a></li>
                    <li><a href="../README.md">README do projeto</a></li>
                </ul>
            </div>
            
            <div class="card">
                <h3>🏗️ Arquitetura e DevOps</h3>
                <ul>
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
                </ul>
            </div>
            
            <div class="card">
                <h3>🧪 Testes e Qualidade</h3>
                <ul>
                    <li><a href="coverage/">Cobertura de Testes</a></li>
                    <li><a href="http://localhost:9000">SonarQube Quality</a></li>
                    <li><a href="../scripts/run-tests.ps1">Scripts de Teste</a></li>
                </ul>
            </div>
        </div>
        
        <div class="status">
            <h2>✅ Status da Documentação</h2>
            <p><strong>Documentação automática ativa!</strong></p>
            <p>Para regenerar: <code>.\scripts\generate-docs-simple.ps1</code></p>
            <p>Para servir: <code>.\scripts\serve-docs.ps1</code></p>
        </div>
    </div>
</body>
</html>
'@

$indexContent | Out-File -FilePath "docs\index.html" -Encoding UTF8

Write-Host "✅ Documentação básica gerada!" -ForegroundColor Green
Write-Host "📂 Local: .\docs\index.html" -ForegroundColor Yellow
Write-Host "🌐 Para servir: .\scripts\serve-docs.ps1" -ForegroundColor Cyan
