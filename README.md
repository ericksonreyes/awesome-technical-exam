# Erickson Reyes Technical Exam

## Description
The goal of the exam is to pass the two requirements.
* [Github Users API](docs/GITHUB_API_REQUIREMENTS.md)
* [Hamming Distance Calculator](docs/HAMMING_DISTANCE_REQUIREMENTS.md)


## <a name="preRequisites"></a>Software pre-requisites
* [Git](https://git-scm.com/downloads). Software for tracking changes in any set of files, usually used for 
coordinating work among programmers collaboratively developing source code during software development.

* [Docker](https://docs.docker.com/get-docker/). This will be used to spawn containers that will host the dependencies
 that will host the application. No more hard, messy, step by step manual installations in your computer.
* [Postman](https://www.postman.com/downloads/). You can use this to test the API end points. It has a cool graphical 
user interface.

* Any text editor. The Github User API has acceptance test files `(.feature)` in the [/tests/acceptance/](/tests/acceptance) 
directory. You can modify or add examples in these feature files to test if the core domain codes in the 
[/src/Github/](/src/Github) are passing the domain requirements. 


## Installation
Installation can be done in two ways. Step by step or using the install script. Be sure to have the 
[software pre-requisites](#preRequisites) installed. If your Operating System has terminal or command 
line interface that supports shell scripts. Follow these steps.


### Using the install script
* Clone the repository using HTTPS.
    ```shell script
    git clone https://github.com/ericksonreyes/awesome-technical-exam.git
    ```
  
* Clone the repository using SSH.
    ```shell script
    git clone git@github.com:ericksonreyes/awesome-technical-exam.git
    ```
  
* Go to the project directory
    ```shell script
    cd awesome-technical-exam/
    ```
  
* Run the install script
    ```shell script
    sh install.sh
    ```
  
### Installing manually
* Clone the repository using HTTPS.
    ```shell script
    git clone https://github.com/ericksonreyes/awesome-technical-exam.git
    ```
  
* Clone the repository using SSH.
    ```shell script
    git clone git@github.com:ericksonreyes/awesome-technical-exam.git
    ```
  
* Go to the project directory
    ```shell script
    cd awesome-technical-exam/
    ```
  
* Take down running docker containers in the working directory.
    ```shell script
    docker-compose down
    ```
    
* Build the docker images
    ```shell script
    docker-compose build
    ```
  
* Spawn a container running a Redis service. This will give it enough time to boot up before all steps are completed.
    ```shell script
    docker-compose up -d redis
    ```
    Adding the `-d` to run the service in the background or make it a daemon process.
  
* Spawn a container running a MySQL service. This will give it enough time to boot up before all steps are completed. 
    ```shell script
    docker-compose up -d mysql
    ```
  
* Install the projects PHP library dependencies
    ```shell script
    docker-compose run --rm composer install
    ```
    Adding the `--rm` option to tell Docker to delete the container used once it is done. Saves storage space.
    
* Spawn containers running the `php-fpm`and `Nginx` services that will host the API.
    ```shell script
    docker-compose up -d exam
    ```
       
* Create the needed tables in the MySQL database.
    ```shell script
    docker-compose run --rm php artisan migrate:fresh --seed
    ```

Once the installation is complete you can browse the API at 
* [http://localhost:18000/](http://localhost:18000/). 
Port 18000 was chosen so that it will not conflict with any running web servers using the 8000 (which is a commonly 
preferred API) port. 

You can access the MySQL using the following information.
* Host: localhost
* Port: 13306 (This was intentional so that it will not conflict with an existing MySQL instance in your computer.)
* Username: homestead
* Password: secret
* Database: homestead

## Testing
* [Testing the Github Users API](docs/GITHUB_API_TESTING.md)
* [Testing the Hamming Distance Calculator](docs/HAMMING_DISTANCE_TESTING.md)

## Running Acceptance and Unit tests
To ensure that I am writing my code in accordance to domain requirements and technical specifications, I am running 
the following test suites during coding and refactoring.
* Acceptance test using Behat.
    ```shell script
    docker-compose run --rm php bin/behat 
    ```
* Unit test using PHPSpec.
    ```shell script
    docker-compose run --rm php bin/phpspec run
    ```
  
## Viewing the test coverage
To ensure that the core domain codes is 100% test covered browse the code coverage report page.
* [/build/logs/phpspec_coverage/index.html](build/logs/phpspec_coverage/index.html)

## Applied development methods and disciplines.
* [Domain-driven design](https://en.wikipedia.org/wiki/Domain-driven_design). The acceptance and core domain codes are 
written according to the given requirements. The code was carefully written to let non-technical people understand it. 
This will make code review between domain experts and developers much easier. Making the validation and correctness of 
code's logic flow and result more accurate and faster.

* [Test-driven development](https://en.wikipedia.org/wiki/Test-driven_development). Effort is made to write acceptance 
and unit tests before writing codes and refactoring it. The acceptance tests guides me to deliver results that the domain 
is expecting from the application. These acceptance test parameters can be modified to test the results. Unit tests 
ensures that the codes I am writing is according to my specification. With these tests implemented, I can do modification
and refactoring my code with less worry of deploying breaking changes since these tests provides the fastest feedback and
does not rely on other factors (database engine, web servers etc).

* [Hexagonal architecture](https://en.wikipedia.org/wiki/Hexagonal_architecture_(software). All dependencies points to 
the core domain. Core domain has no database, web framework or web server related codes. Heavy use of 
[Interfaces](https://www.php.net/manual/en/language.oop5.interfaces.php) allows the application layer code in the 
[/src/Github/Application/](/src/Github/Application) directory to switch and inject dependencies with flexibility. 
Changing the dependency for the application layer doesn't require changes in the application layer codes. This architecture 
relied on [Dependency Inversion Principle](https://en.wikipedia.org/wiki/Dependency_inversion_principle). Also I can 
make the application working as intended even if I defer deciding the framework to be used or I have no installed web 
or database servers yet. 
  
* [SOLID principles of object-oriented programming](https://en.wikipedia.org/wiki/SOLID). Principles that allows the code 
to be separated by concerns, extensible, flexible and understandable.

## Final notes
Follow the commit history on how I started writing the acceptance tests for core domain, write unit tests for the classes, 
code to make the tests pass and code refactoring. Once the core domain is working as intended that is the time I applying 
it to the controllers, make related eloquent models, make classes that implements the interfaces that the core domain requires.     