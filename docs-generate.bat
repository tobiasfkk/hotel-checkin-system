@echo off
echo ================================================
echo   GERADOR DE DOCUMENTACAO AUTOMATICA
echo   Hotel Check-in System - Billing Service  
echo ================================================
echo.

echo Criando estrutura de diretorios...
if not exist "docs\final" mkdir "docs\final"
if not exist "docs\final\javadoc" mkdir "docs\final\javadoc"

echo.
echo Gerando Javadoc...
cd billing-service-java

echo Executando: mvn javadoc:javadoc
mvn javadoc:javadoc -q

if %ERRORLEVEL% == 0 (
    echo ✓ Javadoc gerado com sucesso!
    
    echo Copiando Javadoc...
    if exist "target\site\apidocs" (
        xcopy "target\site\apidocs\*" "..\docs\final\javadoc\" /E /Y /Q
        echo ✓ Javadoc copiado para docs\final\javadoc\
    ) else (
        echo ! Javadoc nao encontrado em target\site\apidocs
    )
) else (
    echo X Erro ao gerar Javadoc!
)

cd ..

echo.
echo Criando pagina principal...

echo ^<!DOCTYPE html^> > "docs\final\index.html"
echo ^<html lang="pt-BR"^> >> "docs\final\index.html"
echo ^<head^> >> "docs\final\index.html"
echo     ^<meta charset="UTF-8"^> >> "docs\final\index.html"
echo     ^<title^>Documentacao Automatica - Billing Service^</title^> >> "docs\final\index.html"
echo     ^<style^> >> "docs\final\index.html"
echo         body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; } >> "docs\final\index.html"
echo         .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; } >> "docs\final\index.html"
echo         h1 { color: #333; text-align: center; } >> "docs\final\index.html"
echo         .section { margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 5px; } >> "docs\final\index.html"
echo         a { color: #007bff; text-decoration: none; padding: 10px 15px; background: #e7f3ff; border-radius: 5px; display: inline-block; margin: 5px 0; } >> "docs\final\index.html"
echo         .command { background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; } >> "docs\final\index.html"
echo     ^</style^> >> "docs\final\index.html"
echo ^</head^> >> "docs\final\index.html"
echo ^<body^> >> "docs\final\index.html"
echo     ^<div class="container"^> >> "docs\final\index.html"
echo         ^<h1^>Documentacao Automatica - Billing Service^</h1^> >> "docs\final\index.html"
echo         ^<div class="section"^> >> "docs\final\index.html"
echo             ^<h2^>Javadoc - Documentacao do Codigo^</h2^> >> "docs\final\index.html"
echo             ^<p^>Documentacao completa das classes e metodos do Billing Service.^</p^> >> "docs\final\index.html"
echo             ^<a href="javadoc/index.html"^>Abrir Javadoc^</a^> >> "docs\final\index.html"
echo         ^</div^> >> "docs\final\index.html"
echo         ^<div class="section"^> >> "docs\final\index.html"
echo             ^<h2^>Centro de Testes Manual^</h2^> >> "docs\final\index.html"
echo             ^<p^>Interface para testar os endpoints manualmente sem necessidade de serviço rodando.^</p^> >> "docs\final\index.html"
echo             ^<a href="../api-testing.html"^>Centro de Testes^</a^> >> "docs\final\index.html"
echo         ^</div^> >> "docs\final\index.html"
echo     ^</div^> >> "docs\final\index.html"
echo ^</body^> >> "docs\final\index.html"
echo ^</html^> >> "docs\final\index.html"

echo ✓ Pagina principal criada: docs\final\index.html

echo.
echo ================================================
echo   DOCUMENTACAO GERADA COM SUCESSO!
echo ================================================
echo.
echo ARQUIVOS CRIADOS:
echo   - Pagina Principal: docs\final\index.html
echo   - Javadoc: docs\final\javadoc\index.html
echo   - Centro de Testes: docs\api-testing.html
echo.
echo PARA INICIAR O SERVICO:
echo   cd billing-service-java
echo   mvn spring-boot:run
echo.
pause
