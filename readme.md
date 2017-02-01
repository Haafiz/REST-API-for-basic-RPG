# RESTful API for Basic features of Role Playing Game

A small API that provides JSON data via HTTP to be consumed by a frontend-app or other services.

It use Laravel's microframework Lumen 5.3 as Framework and utilize CodeCeption for doing API testing.
This repository can be used as boiler plate or for learning purpose. This API is for a Role Playing Game. So its endpoints are mentioned in usage section to utilize to play game.
I have used MySQL and tested it with MySQL however other RDMS that Laravel support can be used.


## Quick Setup

- Clone this repo or download it's release archive and extract it somewhere
- You may delete `.git` folder if you get this code via `git clone`
- Run `composer install`
- Configure your `.env` file for authenticating via database. You can simply rename `.env.example` to `.env` and then updating DB information.
- Set the `API_PREFIX` parameter in your .env file (usually `api`).
- Run `php artisan migrate --seed`
- In .env file there is DB_TEST_DATABASE that should be another DB on your system having same user/pass but empty DB that will be populated on runtime by Codeception and will be used in test environment.
- Give write permissions to `/storage` directory.
- then `composer dump-autoload`
- Before running tests, also add test database credentials for DB_TEST_DATABASE in `codeception.yml` in this section:
```
- Db:
            dsn: 'mysql:host=localhost;dbname=testrpg'
            user: 'root'
            password: 'password'
            dump: tests/_data/rpg.sql
            populate: true
```
Replace Test DB name with `testrpg`, root with your username and password with your DB password. I recommend not changing dump or other settings.


## Running API

- Run a PHP built in server from your root project:

```sh
php -S localhost:8000 -t public/
```


## Endpoints Usage

### Authenticating User Login
To authenticate a user, make a `POST` request to `/api/auth/login` with parameter as mentioned below:

```
email: kaasib@gmail.com
password: Haafiz
```

Request:

```sh
curl -X POST -F "email=johndoe@example.com" -F "password=johndoe" "http://localhost:8000/api/auth/login"
```

Response:

```
{
  "success": {
    "message": "token_generated",
    "token": "a_long_token_appears_here"
  }
}
```
For all requests where login is required use same token in header like the request below

```sh
GET /api/auth/user HTTP/1.1
Host: localhost:8000
Authorization: Bearer {That long token here}
```

### See Authenticated User

Request: `GET api/auth/user`  with authentication token

### Refresh Token

Request: `PATCH api/auth`  with authentication token

### Blacklist Token

Request: `DELETE api/auth`  with authentication token

### Explore All Characters
Request: `GET api/characters`  to see list of all characters
Request: `GET api/characters/{characterId}`  to see detail of specific character

### Create a character
Request: `STORE api/me`  with authentication token  to create User's Character
Params Example: 
```
name' => "Haafiz",
'age' => rand(13,80),
'skilled_in' => "Sword Fighting"
```


Request: `GET api/me`  to see current user's character info

### Create new Fight
Request: `STORE api/me/fights`  with authentication token  to create User's Character
Params: Only parameter is `opponent_id` where opponent_id can be ID of any character in system, which can be explored


Request: `GET api/me/fights`  with authentication token to list current user's character's fights

## More Info
- Please note that User game is overall persistent so he can login any time and resume game from there.
- Also when a fight is completed, user's every fight have record of user's experience points. 
- A fight can have different experience points depends on fight's outcome.
- So experience is in user's every fight record.
- So it can be used for reporting or other purposes as game will proceed. Right now we are keeping record of this but not showing anywhere.

## Credits

```
Laravel and Lumen is a trademark of Taylor Otwell
Sean Tymon officially holds "Laravel JWT" license
```
This repo is Lumen, JWT and Dingo integration: https://github.com/krisanalfa/lumen-jwt 
CodeCeption is used as testing framework for both Unit and API tests.


## Running Tests
In tests directory there are api as well as unit tests.  which can be run by following command:
`vendor/bin/codecept run`
or for more verbose use:
`vendor/bin/codecept run -vv`
or for even more verbose use:
`vendor/bin/codecept run -vvv`

However few configurations are required before that: 
### Test configurations

- In .env file there is DB_TEST_DATABASE that should be another DB on your system having same user/pass but empty DB that will be populated on runtime by Codeception and will be used in test environment. 
- You also need to edit codeception.yml and provide your DB credentials under DB module. 
This DB module will populate a default DB in database using rpg.sql in _data directory and it will also clean it after running test case. 

### Code Coverage
In `codeception.yml` there are configurations already done to enable code coverage. So to see code coverage report, run:
`vendor/bin/codecept run --coverage --coverage-html`

This command will show coverage at the end of test executation in terminal and will also make HTML based Code Coverage report in 
`_output/coverage` directory. Open index.html to see report.

## Endpoint URL's error:
It is possible that above API endpoint may have typo so more accurate place to see endpoints reference is API tests which can be found in `tests/api` directory. 


## Reporting Bug
In case you guys find any bug or experience any problem during installation or configuration or in understanding, feel free to contact by creating issue, as improvement is continouos process. After well tested softwares are community and time tested :) .
