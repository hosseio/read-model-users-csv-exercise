## Exercise

#### Statement
Read statement.pdf

#### Prerequisites
* [Docker](https://www.docker.com/)
* [docker-compose](https://docs.docker.com/compose/install/)
* [Make](https://ftp.gnu.org/old-gnu/Manuals/make-3.79.1/html_chapter/make_2.html)

the following shows the commands

    > make help

    usage: make <command>
    
    commands:
        start       - start the application containers
        stop        - stop the application containers
        clean       - stop running containers and remove them
        sh          - execute sh inside the app container
        synchronize - download the users csv file
        install     - install php dependencies using composer
        update      - update php dependencies using composer
        test        - run tests

to start the project lets

    > make start

to execute tests

    > make test

once executing you can download the users csv file

    > make synchronize

now the system should be ready to start. Access to the server through `localhost`

Getting the users

     curl localhost/users

Adding query params

     curl localhost/users?activation_length=25&countries[]=FR&countries[]=LU

#### Author

* [Jose Ortiz](https://github.com/hosseio)
