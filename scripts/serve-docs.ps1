# Servidor HTTP simples para documentação
$port = 8090
$path = (Get-Location).Path + '\docs'

Write-Host "🌐 Iniciando servidor de documentação..." -ForegroundColor Cyan
Write-Host "📂 Pasta: $path" -ForegroundColor Yellow
Write-Host "🔗 URL: http://localhost:$port" -ForegroundColor Green
Write-Host "⏹️ Para parar: Ctrl+C" -ForegroundColor Red

# Verificar se Python está disponível
try {
    $pythonVersion = python --version 2>&1
    Write-Host "🐍 Python encontrado: $pythonVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Python não encontrado. Tentando alternativas..." -ForegroundColor Red
    
    # Tentar Node.js
    try {
        $nodeVersion = node --version 2>&1
        Write-Host "📦 Node.js encontrado: $nodeVersion" -ForegroundColor Green
        
        # Usar http-server do Node.js
        Set-Location "$path"
        npx http-server -p $port --cors -o
        exit
    } catch {
        Write-Host "❌ Node.js não encontrado. Usando PowerShell nativo..." -ForegroundColor Yellow
        
        # Servidor PowerShell nativo
        $listener = New-Object System.Net.HttpListener
        $listener.Prefixes.Add("http://localhost:$port/")
        $listener.Start()
        
        Write-Host "✅ Servidor PowerShell iniciado!" -ForegroundColor Green
        Write-Host "📝 Servindo arquivos de: $path" -ForegroundColor Cyan
        
        try {
            while ($listener.IsListening) {
                $context = $listener.GetContext()
                $request = $context.Request
                $response = $context.Response
                
                $localPath = $request.Url.LocalPath
                if ($localPath -eq '/') { $localPath = '/index.html' }
                
                $filePath = Join-Path $path $localPath.Replace('/', '\')
                
                if (Test-Path $filePath) {
                    $content = Get-Content $filePath -Raw -Encoding UTF8
                    $buffer = [System.Text.Encoding]::UTF8.GetBytes($content)
                    
                    if ($filePath.EndsWith('.html')) {
                        $response.ContentType = 'text/html; charset=utf-8'
                    } elseif ($filePath.EndsWith('.css')) {
                        $response.ContentType = 'text/css'
                    } elseif ($filePath.EndsWith('.js')) {
                        $response.ContentType = 'application/javascript'
                    }
                    
                    $response.ContentLength64 = $buffer.Length
                    $response.OutputStream.Write($buffer, 0, $buffer.Length)
                } else {
                    $response.StatusCode = 404
                    $error = [System.Text.Encoding]::UTF8.GetBytes("404 - Arquivo não encontrado")
                    $response.ContentLength64 = $error.Length
                    $response.OutputStream.Write($error, 0, $error.Length)
                }
                
                $response.OutputStream.Close()
            }
        } finally {
            $listener.Stop()
        }
        exit
    }
}

# Usar Python
Set-Location "$path"
python -m http.server $port
