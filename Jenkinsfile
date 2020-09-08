pipeline {
    agent any
    stages {
        stage('setup') {
            steps {
                sh 'git checkout ${GIT_TAG}'
            }
        }
        stage('build') {
            agent { 
                dockerfile true 
            }
            steps {
                sh 'composer install -d plantilla_portal --prefer-dist -o --no-dev --no-scripts'
                sh 'yarn --cwd plantilla_portal encore production'
                sh 'yarn --cwd plantilla_portal install --prod'
            }
        }
        stage('deploy') {
            steps {
                sh 'ssh jenkins@172.16.72.25 mkdir /home/jenkins/plantilla_portal_nuevo'
                sh 'scp -r plantilla_portal/* jenkins@172.16.72.25:/home/jenkins/plantilla_portal_nuevo'
                sh 'ssh jenkins@172.16.72.25 rm -r /home/jenkins/plantilla_portal'
                sh 'ssh jenkins@172.16.72.25 mv /home/jenkins/plantilla_portal_nuevo /home/jenkins/plantilla_portal'
                sh 'ssh jenkins@172.16.72.25 APP_ENV=prod DIRECTORIO_VAR=/var/www/data/var_plantilla_portal php /home/jenkins/plantilla_portal/bin/console cache:clear --env=prod --no-debug'
            }
        }
    }
    post {
        success {
            slackSend color: "good", message:"Sistema de plantilla_portal desplegado con éxito"
        }

        failure {
            slackSend color: "danger", message:"Error al desplegar Sistema de plantilla_portal"
        }
    }
}
