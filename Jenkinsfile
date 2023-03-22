pipeline{
        agent any

        stages{
            stage('Deploy to Remote'){
                steps{
                    sh 'scp ${WORKSPACE}/* root@10.105.4.105:8088/dashboard//sampleJenkinfile/'
                }
            }
        }
}