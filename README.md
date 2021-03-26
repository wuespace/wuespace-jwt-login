# wuespace-jwt-login

> A PHP-based Login System/JWT Token Dispenser for organization members

## System Requirements
- Linux-based web server running Apache 2 and PHP 7.2+
- npm (with the `npx` command)
- `ssh-keygen` and `openssl`

## Installation

1. Login to your server
2. Create a suitable domain (e.g., https://login.wuespace.de)
3. Clone this repository
4. Run `php composer.phar install` to install required dependencies
5. Configure the login system (cf. *Configuration*)
6. Forward your domain to the root of the cloned repository folder

## Configuration
All configuration takes place in the `data` folder.

### `keys` (`key` and `key.pub`)
First things first, you'll need to generate private and public keys.

To generate the keys, enter the `/data/keys` folder and run these two commands:

```shell
ssh-keygen -t rsa -b 4096 -m PEM -f key && openssl rsa -in key -pubout -outform PEM -out key.pub
```
> **:warning: NOTE:** Don't add a passphrase to these keys as it is not supported by the system.

The public key can (and should) be shared with applications using the login systems.

The private key, however, should be kept private under all circumstances.


### `registered-domains.json`

In `/data/registered-domains.json`, you can add domains that may use the login system (to which the system can redirect 
after the form gets filled). Redirect urls must **begin** with the exact domain registered here.
For security purposes, we recommend being as precise as possible with these domains.

### `config.json`

In `config.json`, you can set the following preferences:

- `token_expire_after` - The number of seconds how long a token can be used before it expires.
  Tokens cannot get revoked, meaning you should choose a value where, in case of a compromise,
  it is acceptable to shut down services for that duration after a compromise is detected.

### Users
Each user is identified using a `[username].json` file within the `/data/users` folder.

This, in turn, also creates the boundaries of valid usernames, as in "valid UNIX file names".

A user file is structured in the following way:

```json
{
  "password":"SOME_TOKEN_HERE",
  "data": {
    "role": "member",
    "meerkats-editor-at": ["https://www.wuespace.de/"]
  }
}
```

`"password"` is a hash for the user's password, encoded using PHP's `password_hash()`.

`"data"` can contain any data and is readable by any application that consumes the token. It can, thus, for example
contain information about specific permissions within a system and so on.

#### Adding a user

You can use the integrated micro-CLI to add a new user.

To use it, run `./data/add-user.sh`.

On non-Linux systems, you can alternatively set the `NEW_USERNAME` and
`NEW_PASSWORD` environment variables to their desired values and run
`php ./data/cli-add-user.php`.

## Usage

### Forwarding

Open the following request in a browser (usually by just entering the domain):

```http request
GET https://login.wuespace.de?source=[domain]
```

The user is now asked to login with their credentials.

Upon success, they'll get asked whether to transmit the listed data to `[domain]`.

If they agree, a `POST` request with the token as `"token"` within the `form-data` gets submitted to `[domain]`.

**Please note that `[domain]` has to begin with a domain registered in `registered-domains.json`.**

### API
(detailed docs coming soon)

```http request
POST https://login.wuespace.de/api.php?source=[domain]
```

With `user` and `pass` (username and password) as `form-data`.

Possible responses:
- `200` - Returned body = token
- `401` - Wrong credentials
- `400` - No/incomplete user data specified or source not in `registered-domains.json`

## License

MIT © [WüSpace e. V.](https://www.wuespace.de)
