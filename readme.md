## Open Tactics Skeleton

The repository is intended for rapid, essential iterations of server structures.

## Setup and configuration

Clone the repo:

    $ git clone git@github.com:the-brogrammers/open-tactics-skeleton.git
    
Update composer:

    $ cd open-tactics-skeleton
    $ composer update
    
Make artisan runnable:

    $ chmod +x ./artisan
    
Generate an app secret key:

    $ echo "<?php echo md5(uniqid()) . \"\r\n\";" | php
    
Setup .env file:

    $ cp .env.example .env
    
Then:

- paste the previously generated key 
- type in your database credentials
- setup cache and session drivers. Ex:

    CACHE_DRIVER=database
    SESSION_DRIVER=cookie

Run migrations:

    $ ./artisan migrate
    

## Accounts

To register, `POST` a request to `/accounts`, with these parameters:

    name: a string containing a user's name (spaces allowed)
    email: the user's email
    password: a password not longer than 60 characters.
    
To get a token, `POST` a request to `/sessions`, with these parameters:

    email: the user's email
    password: a password not longer than 60 characters.
  
The response json will contain an `access_token` field.
Use this token to sign subsequent requests, by setting the header (pay attention to spaces):

    "Authorization": "Bearer [token]"
    
To test your token is working, make a `GET` request to `/accounts/me`. The response should be your email address.
