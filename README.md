<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

## Setup
To set up this project is simple, just run the command below.
```sh
docker-compose up
```

## How to access and test?
This project is API Rest based so, you can't access any resource in your browser. You should use a shell curl command or tools like Postman, Insomnia and others tools.

To keep your setup fast and easy, you should use `api.postman_collection.json` and import in your postman. The collection have all you need to interact with the application.

The project use the SQLite as your database. You don't need to install anything else.

### Test coverage
<img src=".github/assets/coverage.png" />

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
