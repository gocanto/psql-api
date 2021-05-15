## Simple PSQL API.

<a href="https://packagist.org/packages/gocanto/psql-api"><img src="https://img.shields.io/packagist/dt/gocanto/psql-api.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/gocanto/psql-api"><img src="https://img.shields.io/github/v/release/gocanto/psql-api.svg?style=flat-square" alt="Latest Stable Version"></a>

Simple Application and API modeling to work with PostgresQL written in PHP.

## Installation

This library uses [Composer](https://getcomposer.org) to manage its dependencies. So, before using it, make sure you have it installed in your machine.
Once you have done this, you will be able to pull this library in by typing the following command in your terminal.

```bash
composer require gocanto/psql-api
```

After you have done this, you will have to populate your [environment](https://github.com/gocanto/psql-api/blob/main/.env.example) variables in order for you to
connect to your testing server endpoints. You can achieve this by typing the following command in your terminal
within your project root folder.

```bast
cp .env.example .env
```
 Once you have the newly created file open in your proffered IDE, you can update your database connection values alongside with your
 app environment mode.

Finally, you might be able to start testing the API by hitting the available endpoints. In order for you to do so,
you will need a [restfull client](https://www.postman.com/) to facilitate these tasks, or you can go all in and query from your CLI.

## Available Features
- Create cars.
- List all cars.
- Show a given car.
- Update a given car.
- Delete a given car.

> See [more](https://github.com/gocanto/psql-api/blob/main/src/Http/Router.php#L32)

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance its functionality.

## License

The MIT License (MIT). Please see [License File](https://github.com/gocanto/psql-api/blob/main/LICENSE) for more information.


## How can I thank you?
Why not star the GitHub repo and share the link for this repository on Twitter?

Don't forget to [follow me on twitter](https://twitter.com/gocanto)!

Thanks!
