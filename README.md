# Simple Message API using

## Stack Used

1. Laravel
2. Developed locally with Laravel Sail
3. Sanctum for Authentication
4. No other packages other than what ships besides Sanctum (laravel first party plugin)
5. Created using TDD.

## Todo yet

1. Make Authenticated tests
2. unit tests acl functions like getting a flat collection of a user's permission slug $user->permissions() to be able to verify a user is assigned a permission through the role model
3. Finish messages and tests (CRUD) only public list is done
4. Create authentication and tests to ensure a user can register and login/out

## To install and get running

1. Clone locally
2. Ensure you have docker running
3. in a terminal cd into the repo root (source/message-api)
4. run "./vendor/bin/sail up -d" to let it set up docker environment

## NOTE

* Run migrations and seeder (sail artisan migrate --seed). In a prod environed you will want to run the AclSeeder but adjust how you have a user. DO NOT USE THE DEFAULT as it is a security issue (generic).
