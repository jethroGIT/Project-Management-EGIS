pipeline {
    agent any

    environment {
        IMAGE = "ghcr.io/jethrogit/egis-laravel:latest"
        COMPOSE_DIR = "/opt/egis-laravel"
    }

    stages {

        // stage('Login to GHCR') {
        //     steps {
        //         withCredentials([
        //             usernamePassword(
        //                 credentialsId: 'github-ghcr',
        //                 usernameVariable: 'GITHUB_USER',
        //                 passwordVariable: 'GITHUB_TOKEN'
        //             )
        //         ]) {
        //             sh '''
        //                 echo "$GITHUB_TOKEN" | docker login ghcr.io \
        //                     -u "$GITHUB_USER" \
        //                     --password-stdin
        //             '''
        //         }
        //     }
        // }

        // stage('Pull Latest Image') {
        //     steps {
        //         sh '''
        //             docker pull $IMAGE
        //         '''
        //     }
        // }

        stage('Deploy') {
            steps {
                dir("${COMPOSE_DIR}") {
                    sh '''
                        docker compose pull
                        docker compose up -d
                    '''
                }
            }
        }

        stage('Run Migration') {
            steps {
                sh '''
                    docker exec egis-laravel \
                    php artisan migrate --force
                '''
            }
        }

    }

    post {
        success {
            echo 'Deployment berhasil.'
        }

        failure {
            echo 'Deployment gagal.'
        }
    }
}