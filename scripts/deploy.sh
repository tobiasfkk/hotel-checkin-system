#!/bin/bash

# Script de deploy para diferentes ambientes

ENV=${1:-development}
VERSION=${2:-latest}

echo "🚀 Iniciando deploy para ambiente: $ENV"
echo "📦 Versão: $VERSION"

case $ENV in
  "development")
    echo "🔧 Deploy em Desenvolvimento..."
    docker-compose -f docker-compose.dev.yml down
    docker-compose -f docker-compose.dev.yml up -d --build
    ;;
    
  "staging")
    echo "🧪 Deploy em Homologação..."
    export APP_VERSION=$VERSION
    docker-compose -f docker-compose.staging.yml down
    docker-compose -f docker-compose.staging.yml up -d
    ;;
    
  "production")
    echo "🏭 Deploy em Produção..."
    
    # Verificar se todas as variáveis estão definidas
    if [ -z "$DOCKER_REGISTRY" ] || [ -z "$K8S_NAMESPACE" ]; then
        echo "❌ Erro: Variáveis DOCKER_REGISTRY e K8S_NAMESPACE devem estar definidas"
        exit 1
    fi
    
    # Deploy com Kubernetes
    echo "📋 Atualizando deployments no Kubernetes..."
    kubectl set image deployment/auth-service auth-service=$DOCKER_REGISTRY/auth-service:$VERSION -n $K8S_NAMESPACE
    kubectl set image deployment/booking-service booking-service=$DOCKER_REGISTRY/booking-service:$VERSION -n $K8S_NAMESPACE
    kubectl set image deployment/billing-service billing-service=$DOCKER_REGISTRY/billing-service:$VERSION -n $K8S_NAMESPACE
    
    # Verificar status do deploy
    echo "⏳ Verificando status do deploy..."
    kubectl rollout status deployment/auth-service -n $K8S_NAMESPACE --timeout=300s
    kubectl rollout status deployment/booking-service -n $K8S_NAMESPACE --timeout=300s
    kubectl rollout status deployment/billing-service -n $K8S_NAMESPACE --timeout=300s
    
    echo "✅ Deploy em produção concluído!"
    ;;
    
  *)
    echo "❌ Ambiente inválido. Use: development, staging ou production"
    exit 1
    ;;
esac

echo "🎯 Deploy concluído para ambiente: $ENV"

# Executar health check
echo "🏥 Executando health check..."
sleep 30

case $ENV in
  "development")
    curl -f http://localhost:8080/api/health || echo "⚠️ Health check falhou"
    ;;
  "staging")
    curl -f http://staging.hotel-checkin.local/api/health || echo "⚠️ Health check falhou"
    ;;
  "production")
    kubectl get pods -n $K8S_NAMESPACE
    ;;
esac

echo "✅ Deploy script finalizado!"
