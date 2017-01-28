# RESTful API for Basic features of Role Playing Game
Description come here

## What's Used

- [Lumen 5.3](https://github.com/laravel/lumen/tree/v5.3.0).
- [JWT Auth](https://github.com/tymondesigns/jwt-auth) for Lumen Application. <sup>[1]</sup>
- [Dingo](https://github.com/dingo/api) to easily and quickly build your own API. <sup>[1]</sup>
-

## Quick Setup

- Clone this repo or download it's release archive and extract it somewhere
- You may delete `.git` folder if you get this code via `git clone`
- Run `composer install`
- Run `php artisan jwt:generate`
- Configure your `.env` file for authenticating via database. You can simply rename `.env.example` to `.env` and then updating DB information.
- Set the `API_PREFIX` parameter in your .env file (usually `api`).
- Run `php artisan migrate --seed`

## Running API

- Run a PHP built in server from your root project:

```sh
php -S localhost:8000 -t public/
```

Or use artisan command:

```sh
php artisan serve
```


## Endpoint Usage

### Authenticating User Login
To authenticate a user, make a `POST` request to `/api/auth/login` with parameter as mentioned below:

```
email: johndoe@example.com
password: johndoe
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

- With token provided by above request, you can check authenticated user by sending a `GET` request to: `/api/auth/user`.

Request:

```sh
curl -X GET -H "Authorization: Bearer a_long_token_appears_here" "http://localhost:8000/api/auth/user"
```

Response:

```
{
  "success": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "johndoe@example.com",
      "created_at": null,
      "updated_at": null
    }
  }
}
```

- To refresh your token, simply send a `PATCH` request to `/api/auth`.
- You can also invalidate token by sending a `DELETE` request to `/api/auth`.

## Credits

```
Laravel and Lumen is a trademark of Taylor Otwell
Sean Tymon officially holds "Laravel JWT" license
```
