pipeline{
        agent any

        stages{
            stage('Deploy to Remote'){
                steps{
                    sh 'scp ${WORKSPACE}/* slpauser@10.70.4.37:/sampleJenkinfile/'
                }
            }
        }
}