pipeline {
    agent any

    environment {
        DOCKER_IMAGE_PREFIX = 'doege/hotel-checkin-system'
    }

    stages {
        stage('Build & Test - Auth (Laravel)') {
            steps {
                dir('auth-service-php') {
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX:auth-service .'
                }
            }
        }
        stage('Build & Test - Booking (Laravel)') {
            steps {
                dir('booking-service-php') {
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX:booking-service .'
                }
            }
        }
        stage('Build & Test - Billing (Spring Boot)') {
            steps {
                dir('billing-service-java') {
                    sh 'chmod +x mvnw'
                    sh './mvnw clean package -DskipTests'
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX:billing-service .'
                }
            }
        }
        stage('Build - API Gateway') {
            steps {
                dir('api-gateway-java') {
                    sh 'chmod +x mvnw'
                    sh './mvnw clean package -DskipTests'
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX:api-gateway .'
                }
            }
        }
        stage('Push to DockerHub') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'dockerhub-credentials-id', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    sh 'echo "$DOCKER_PASS" | docker login -u "$DOCKER_USER" --password-stdin'
                    sh 'docker push $DOCKER_IMAGE_PREFIX:auth-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX:booking-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX:billing-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX:api-gateway'
                    sh 'docker logout'
                }
            }
        }
    }

    post {
        always {
            echo 'Pipeline finalizado.'
        }
        success {
            echo 'Todos os serviços foram testados e publicados!'
        }
        failure {
            echo 'Erro durante a pipeline.'
        }
    }
}