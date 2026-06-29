pipeline {
    agent any

    environment {
        DEPLOY_DIR = '/var/www/html/PHP-Project'
    }

    stages {

        stage('Show Workspace') {
            steps {
                sh '''
                echo "Current Workspace:"
                pwd
                ls -la
                '''
            }
        }

        stage('Check PHP Version') {
            steps {
                sh 'php -v'
            }
        }

        stage('Install Composer Dependencies') {
            steps {
                sh '''
                if [ -f composer.json ]; then
                    composer install --no-interaction --prefer-dist
                else
                    echo "composer.json not found. Skipping Composer installation."
                fi
                '''
            }
        }

        stage('PHP Syntax Check') {
            steps {
                sh '''
                find . -name "*.php" -exec php -l {} \\;
                '''
            }
        }

        stage('Deploy to Apache') {
            steps {
                sh """
                echo "Deploying application..."

                sudo rm -rf ${DEPLOY_DIR}
                sudo mkdir -p ${DEPLOY_DIR}

                sudo cp -R . ${DEPLOY_DIR}/

                sudo chown -R www-data:www-data ${DEPLOY_DIR}
                sudo chmod -R 755 ${DEPLOY_DIR}
                """
            }
        }

        stage('Restart Apache') {
            steps {
                sh '''
                sudo systemctl restart apache2
                '''
            }
        }

        stage('Verify Apache') {
            steps {
                sh '''
                sudo systemctl status apache2 --no-pager
                '''
            }
        }

        stage('Deployment Complete') {
            steps {
                echo "======================================"
                echo "Application deployed successfully!"
                echo "URL: http://localhost/PHP-Project/"
                echo "======================================"
            }
        }
    }

    post {
        success {
            echo 'Build and deployment completed successfully.'
        }

        failure {
            echo 'Build or deployment failed.'
        }

        always {
            cleanWs()
        }
    }
}
