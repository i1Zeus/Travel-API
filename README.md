<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About this project

I've just started working api in Laravel and this is my first project. I've used Laravel 8 and php 7.4. used mysql database. used postman for testing api. used Laravel dusk for testing. used Laravel ui for authentication. used Laravel sanctum for authentication.

## More about this project

* You'll find That I've installed [UnoCSS](https://unocss.dev), that was too as a test there is only a little of ppl that have installed it with Laravel.
* Used Laravel pint for styling and formatting the code.
* Used Larastan for static analysis.
* Used Scribe to document the api.

## How to install UnoCSS with Laravel

1. install [NodeJS](https://nodejs.org/en/), then install [UnoCSS](https://unocss.dev) with this command `npm install -D unocss`.

2. create a file called `uno.config.js` and put this code inside it.

```js
import {
    defineConfig,
    presetAttributify,
    presetUno,
    presetIcons,
} from "unocss"; // install and add ny preset you want

export default defineConfig({
    presets: [presetUno(), presetAttributify(), presetIcons()],
});
```

3. in your `vite.config.js` file you need to add this code inside the "`plugins`".

```js
UnoCSS({ content: { filesystem: ["./resources/views/**/*.blade.php"] },}),
```

4. in your `resources -> js ->  app.js` file you need to add this code.

```js
import "virtual:uno.css";
```

5. That's it, you can now use [UnoCSS](https://unocss.dev) in your project.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
