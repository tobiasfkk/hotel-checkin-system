@echo off
echo 🌐 Servidor de documentação alternativo...
echo 📂 Pasta: docs
echo 🔗 URL: http://localhost:8090
echo ⏹️ Para parar: Ctrl+C

cd docs
python -m http.server 8090 2>nul || (
    echo Python não encontrado, usando Node.js...
    npx --yes serve -l 8090 .
)
