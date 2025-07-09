@echo off
echo 🌐 Iniciando servidor de documentação...
echo 📂 Pasta: docs
echo 🔗 URL: http://localhost:8090
echo ⏹️ Para parar: Ctrl+C

cd docs
npx http-server -p 8090 -o
