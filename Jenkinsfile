pipeline {
    agent any

    environment {
        DOCKER_HUB_CREDENTIALS = credentials('dockerhub-credentials-id')
        DOCKER_IMAGE_PREFIX = 'hotel-checkin-system'
    }

    stages {
        stage('Build & Test - Auth (Laravel)') {
            steps {
                dir('auth-service-php') {
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX/auth-service .'
                    sh 'docker run --rm $DOCKER_IMAGE_PREFIX/auth-service ./vendor/bin/phpunit --coverage-text'
                }
            }
        }

        stage('Build & Test - Booking (Laravel)') {
            steps {
                dir('booking-service-php') {
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX/booking-service .'
                    sh 'docker run --rm $DOCKER_IMAGE_PREFIX/booking-service ./vendor/bin/phpunit --coverage-text'
                }
            }
        }

        stage('Build & Test - Billing (Spring Boot)') {
            steps {
                dir('billing-service-java') {
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX/billing-service .'
                }
            }
        }

        stage('Build - API Gateway') {
            steps {
                dir('api-gateway-java') {
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX/api-gateway .'
                }
            }
        }

        stage('Push to DockerHub') {
            steps {
                withDockerRegistry([ credentialsId: 'dockerhub-credentials-id', url: '' ]) {
                    sh 'docker push $DOCKER_IMAGE_PREFIX/auth-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX/booking-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX/billing-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX/api-gateway'
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