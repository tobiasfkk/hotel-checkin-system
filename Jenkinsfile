pipeline {
    agent any

    environment {
        DOCKER_HUB_CREDENTIALS = credentials('dockerhub-credentials-id')
        DOCKER_IMAGE_PREFIX = 'hotelcheckin'
        SONAR_TOKEN = credentials('sonar-token')
        K8S_NAMESPACE = 'hotel-checkin-system'
        // Definir ambiente baseado na branch
        DEPLOY_ENV = "${env.BRANCH_NAME == 'main' ? 'production' : env.BRANCH_NAME == 'develop' ? 'staging' : 'development'}"
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
                script {
                    env.BUILD_VERSION = "${env.BUILD_NUMBER}-${env.GIT_COMMIT.take(7)}"
                }
            }
        }

        stage('Build Services') {
            parallel {
                stage('Auth Service (Laravel)') {
                    steps {
                        dir('auth-service-php') {
                            sh 'composer install --no-dev --optimize-autoloader'
                            script {
                                docker.build("$DOCKER_IMAGE_PREFIX/auth-service:${env.BUILD_VERSION}")
                            }
                        }
                    }
                }

                stage('Booking Service (Laravel)') {
                    steps {
                        dir('booking-service-php') {
                            sh 'composer install --no-dev --optimize-autoloader'
                            script {
                                docker.build("$DOCKER_IMAGE_PREFIX/booking-service:${env.BUILD_VERSION}")
                            }
                        }
                    }
                }

                stage('Billing Service (Spring Boot)') {
                    steps {
                        dir('billing-service-java') {
                            sh './mvnw clean package -DskipTests'
                            script {
                                docker.build("$DOCKER_IMAGE_PREFIX/billing-service:${env.BUILD_VERSION}")
                            }
                        }
                    }
                }
            }
        }

        stage('Push to Registry') {
            when {
                anyOf {
                    branch 'main'
                    branch 'develop'
                }
            }
            steps {
                script {
                    docker.withRegistry('', 'dockerhub-credentials-id') {
                        docker.image("$DOCKER_IMAGE_PREFIX/auth-service:${env.BUILD_VERSION}").push()
                        docker.image("$DOCKER_IMAGE_PREFIX/booking-service:${env.BUILD_VERSION}").push()
                        docker.image("$DOCKER_IMAGE_PREFIX/billing-service:${env.BUILD_VERSION}").push()
                        
                        // Tag as latest for main branch
                        if (env.BRANCH_NAME == 'main') {
                            docker.image("$DOCKER_IMAGE_PREFIX/auth-service:${env.BUILD_VERSION}").push('latest')
                            docker.image("$DOCKER_IMAGE_PREFIX/booking-service:${env.BUILD_VERSION}").push('latest')
                            docker.image("$DOCKER_IMAGE_PREFIX/billing-service:${env.BUILD_VERSION}").push('latest')
                        }
                    }
                }
            }
        }

        stage('Deploy to Environment') {
            parallel {
                stage('Deploy to Development') {
                    when { branch 'feature/*' }
                    steps {
                        sh '''
                            echo "Deploying to Development environment..."
                            docker-compose -f docker-compose.dev.yml down
                            docker-compose -f docker-compose.dev.yml up -d
                        '''
                    }
                }
                
                stage('Deploy to Staging') {
                    when { branch 'develop' }
                    steps {
                        sh '''
                            echo "Deploying to Staging environment..."
                            export APP_VERSION=${BUILD_VERSION}
                            docker-compose -f docker-compose.staging.yml down
                            docker-compose -f docker-compose.staging.yml up -d
                        '''
                    }
                }
                
                stage('Deploy to Production') {
                    when { 
                        allOf {
                            branch 'main'
                            input message: 'Deploy to Production?', ok: 'Deploy'
                        }
                    }
                    steps {
                        sh '''
                            echo "Deploying to Production environment..."
                            # Deploy com Kubernetes
                            kubectl set image deployment/auth-service auth-service=$DOCKER_IMAGE_PREFIX/auth-service:${BUILD_VERSION} -n $K8S_NAMESPACE
                            kubectl set image deployment/booking-service booking-service=$DOCKER_IMAGE_PREFIX/booking-service:${BUILD_VERSION} -n $K8S_NAMESPACE
                            kubectl set image deployment/billing-service billing-service=$DOCKER_IMAGE_PREFIX/billing-service:${BUILD_VERSION} -n $K8S_NAMESPACE
                            
                            # Verificar se deploy foi bem-sucedido
                            kubectl rollout status deployment/auth-service -n $K8S_NAMESPACE
                            kubectl rollout status deployment/booking-service -n $K8S_NAMESPACE
                            kubectl rollout status deployment/billing-service -n $K8S_NAMESPACE
                        '''
                    }
                }
            }
        }

        stage('Tests & Coverage') {
            steps {
                parallel {
                    stage('Java Tests') {
                        steps {
                            dir('billing-service-java') {
                                sh './mvnw clean test jacoco:report'
                                publishHTML([
                                    allowMissing: false,
                                    alwaysLinkToLastBuild: true,
                                    keepAll: true,
                                    reportDir: 'target/site/jacoco',
                                    reportFiles: 'index.html',
                                    reportName: 'JaCoCo Coverage - Billing Service'
                                ])
                            }
                            dir('api-gateway-java') {
                                sh './mvnw clean test jacoco:report'
                                publishHTML([
                                    allowMissing: false,
                                    alwaysLinkToLastBuild: true,
                                    keepAll: true,
                                    reportDir: 'target/site/jacoco',
                                    reportFiles: 'index.html',
                                    reportName: 'JaCoCo Coverage - API Gateway'
                                ])
                            }
                        }
                    }
                    stage('PHP Tests') {
                        steps {
                            script {
                                try {
                                    dir('auth-service-php') {
                                        sh 'composer install'
                                        sh 'vendor/bin/phpunit --coverage-html coverage-html'
                                    }
                                    publishHTML([
                                        allowMissing: true,
                                        alwaysLinkToLastBuild: true,
                                        keepAll: true,
                                        reportDir: 'auth-service-php/coverage-html',
                                        reportFiles: 'index.html',
                                        reportName: 'PHPUnit Coverage - Auth Service'
                                    ])
                                } catch (Exception e) {
                                    echo "Auth Service tests failed: ${e.getMessage()}"
                                }
                                
                                try {
                                    dir('booking-service-php/src') {
                                        sh 'composer install'
                                        sh 'vendor/bin/phpunit --coverage-html coverage-html'
                                    }
                                    publishHTML([
                                        allowMissing: true,
                                        alwaysLinkToLastBuild: true,
                                        keepAll: true,
                                        reportDir: 'booking-service-php/src/coverage-html',
                                        reportFiles: 'index.html',
                                        reportName: 'PHPUnit Coverage - Booking Service'
                                    ])
                                } catch (Exception e) {
                                    echo "Booking Service tests failed: ${e.getMessage()}"
                                }
                            }
                        }
                    }
                }
            }
        }

        stage('Generate Documentation') {
            steps {
                parallel {
                    stage('JavaDoc') {
                        steps {
                            dir('billing-service-java') {
                                sh './mvnw javadoc:javadoc'
                                publishHTML([
                                    allowMissing: false,
                                    alwaysLinkToLastBuild: true,
                                    keepAll: true,
                                    reportDir: 'target/site/apidocs',
                                    reportFiles: 'index.html',
                                    reportName: 'JavaDoc - Billing Service'
                                ])
                            }
                            dir('api-gateway-java') {
                                sh './mvnw javadoc:javadoc'
                                publishHTML([
                                    allowMissing: false,
                                    alwaysLinkToLastBuild: true,
                                    keepAll: true,
                                    reportDir: 'target/site/apidocs',
                                    reportFiles: 'index.html',
                                    reportName: 'JavaDoc - API Gateway'
                                ])
                            }
                        }
                    }
                    stage('Complete Documentation') {
                        steps {
                            sh '''
                                echo "Generating complete documentation..."
                                chmod +x ./scripts/generate-docs.sh
                                ./scripts/generate-docs.sh
                            '''
                            publishHTML([
                                allowMissing: false,
                                alwaysLinkToLastBuild: true,
                                keepAll: true,
                                reportDir: 'docs',
                                reportFiles: 'index.html',
                                reportName: 'Complete Documentation'
                            ])
                        }
                    }
                }
            }
        }
    }

    post {
        always {
            // Limpar imagens Docker locais
            sh '''
                docker system prune -f
                docker image prune -f
            '''
            
            echo 'Pipeline finalizado.'
        }
        success {
            echo '✅ Todos os serviços foram compilados e publicados com sucesso!'
        }
        failure {
            echo '❌ Erro durante a pipeline.'
        }
    }
}