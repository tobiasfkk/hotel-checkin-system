@echo off
echo 🔧 Iniciando Billing Service...
echo 📂 Diretorio: %CD%
echo 🌐 API Health: http://localhost:8080/api/billing/health
echo.
mvn spring-boot:run
