pipeline {
    agent any

    environment {
        REPO_URL = 'https://github.com/nehatech829-Devops/parking.git'
        BRANCH = 'main'
        DEPLOY_DIR = '/var/www/html/parking'
    }

    stages {

        stage('Checkout Source Code') {
            steps {
                git branch: "${BRANCH}", url: "${REPO_URL}"
            }
        }

        stage('Show Workspace') {
            steps {
                sh '''
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
                    echo "composer.json not found. Skipping Composer."
                fi
                '''
            }
        }

        stage('PHP Syntax Check') {
            steps {
                sh '''
                find . -name "*.php" -print0 | while IFS= read -r -d '' file
                do
                    php -l "$file"
                done
                '''
            }
        }

        stage('Build Package') {
            steps {
                sh '''
                zip -r parking.zip .
                '''
            }
        }

        stage('Archive Artifact') {
            steps {
                archiveArtifacts artifacts: 'parking.zip', fingerprint: true
            }
        }

        stage('Deploy to Apache') {
            steps {
                sh '''
                sudo rm -rf ${DEPLOY_DIR}
                sudo mkdir -p ${DEPLOY_DIR}

                sudo cp -r . ${DEPLOY_DIR}

                sudo chown -R www-data:www-data ${DEPLOY_DIR}
                sudo chmod -R 755 ${DEPLOY_DIR}
                '''
            }
        }

        stage('Restart Apache') {
            steps {
                sh '''
                sudo systemctl restart apache2
                sudo systemctl status apache2 --no-pager
                '''
            }
        }

        stage('Deployment URL') {
            steps {
                echo "Application URL: http://<SERVER-IP>/parking/"
            }
        }
    }

    post {

        success {
            echo 'Build and Deployment Successful'
        }

        failure {
            echo 'Build or Deployment Failed'
        }

        always {
            cleanWs()
        }
    }
}
