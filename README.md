# GitHub API Challenge
This is a repository containing GitHub API Challenge.

Clone it and start using it.

## Start the services
+ Clone repository to your working directory.
+ Create .env file with your GitHub username and Access Token. Take a look at .env.example.
+ Run the following command to make services up and running:
```sh
        $ docker-compose up -d --build
```
+ To start using the App run the following command:
```sh
        $ docker-compose exec php-fpm composer install
```
+ To run "create repository" CLI command run the following command:
```sh
        $ docker-compose exec php-fpm composer create-repo -- --name=NewRepoName
```
+ To run "delete repository" CLI command run the following command:
```sh
        $ docker-compose exec php-fpm composer delete-repo -- --name=NewRepoName
```
+ To access REST endpoint navigate to http://localhost:8080/github/repos URL. Username set in .env will be used as default.
If you want to filter by username try this URL: http://localhost:8080/github/repos?username=AnyOtherUsername
+ To run simple tests for endpoint controller run the following command:
```sh
        $ docker-compose exec php-fpm composer test
```