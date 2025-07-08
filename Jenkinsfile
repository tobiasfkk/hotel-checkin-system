pipeline {
    agent docker

    environment {
        DOCKER_HUB_CREDENTIALS = credentials('dockerhub-credentials-id')
        DOCKER_IMAGE_PREFIX = 'hotelcheckin'
    }

    stages {
        stage('Checkout') {
            steps {
                git 'https://github.com/tobiasfkk/hotel-checkin-system.git'
            }
        }

        stage('Build & Test - Auth (Laravel)') {
            steps {
                dir('auth-service-php') {
                    sh 'composer install'
                    sh './vendor/bin/phpunit --coverage-text'
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX/auth-service .'
                }
            }
        }

        stage('Build & Test - Booking (Laravel)') {
            steps {
                dir('booking-service') {
                    sh 'composer install'
                    sh './vendor/bin/phpunit --coverage-text'
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX/booking-service .'
                }
            }
        }

        stage('Build & Test - Billing (Spring Boot)') {
            steps {
                dir('billing-service') {
                    sh './mvnw clean install'
                    sh 'docker build -t $DOCKER_IMAGE_PREFIX/billing-service .'
                }
            }
        }

        stage('Push to DockerHub') {
            steps {
                withDockerRegistry([ credentialsId: 'dockerhub-credentials-id', url: '' ]) {
                    sh 'docker push $DOCKER_IMAGE_PREFIX/auth-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX/booking-service'
                    sh 'docker push $DOCKER_IMAGE_PREFIX/billing-service'
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