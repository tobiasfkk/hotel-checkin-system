# Define a imagem base para a etapa de build, utilizando o JDK 17 da Eclipse Temurin
FROM eclipse-temurin:17-jdk AS builder

# Define o diretório de trabalho dentro do container
WORKDIR /app

# Copia todos os arquivos do diretório atual para o diretório de trabalho no container
COPY . .

# Concede permissão de execução ao script Maven Wrapper (mvnw)
RUN chmod +x mvnw

# Executa o Maven para limpar e empacotar o projeto, ignorando os testes
RUN ./mvnw clean package -DskipTests

# Define a imagem base para a etapa final, utilizando o JDK 17 da Eclipse Temurin
FROM eclipse-temurin:17-jdk

# Define o diretório de trabalho dentro do container
WORKDIR /app

# Copia o arquivo JAR gerado na etapa de build para o diretório de trabalho da etapa final
COPY --from=builder /app/target/billing-service-0.0.1-SNAPSHOT.jar app.jar

# Define o comando de entrada para iniciar a aplicação Java, executando o arquivo JAR
ENTRYPOINT ["java", "-jar", "app.jar"]