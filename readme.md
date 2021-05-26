Nette Web Project
=================

This is a simple, skeleton application using the [Nette](https://nette.org). This is meant to
be used as a starting point for your new projects.

[Nette](https://nette.org) is a popular tool for PHP web development.
It is designed to be the most usable and friendliest as possible. It focuses
on security and performance and is definitely one of the safest PHP frameworks.

If you like Nette, **[please make a donation now](https://nette.org/donate)**. Thank you!


Requirements
------------

- Web Project for Nette 3.1 requires PHP 7.2
- Node.js 12
- Docker


Installation with Docker
------------

The best way to install Web Project locally is using Docker. If you don't have Docker yet,
download it following [the instructions](https://www.docker.com/products/docker-desktop). Then use command:

	git clone --depth 1 https://github.com/evromalarkey/nette-vite.git . && npm i

That downloads the project from Github, installs `package.json` dependencies with Vite, and runs composer installation via Docker. After that you can serve your project from localhost

	npm run nette:dev

Js and Css files are served via Vite, directly from sources. Any file changes reloads the browsers for fast local development.

This version uses [gulp-vite](https://github.com/evromalarkey/gulp-vite)

> On Windows it's recommended to use WSL2 to run everything (Docker, Node.js via nvm), it's the best approach. Otherwise, some docker scripts inside package.json would work only in PowerShell. 

> When correct Node.js version is set in PhpStorm (WSL2 on Windows), you can use build-in npm to install dependencies or run scripts via GUI.

Installation
------------

The best way to install Web Project is using Composer. If you don't have Composer yet,
download it following [the instructions](https://doc.nette.org/composer). Then use command:

	composer install

Make directories `temp/` and `log/` writable. 


Web Server Setup
----------------

The simplest way to get started is to start the built-in PHP server in the root directory of your project:

	php -S localhost:8000 -t www

Then visit `http://localhost:8000` in your browser to see the welcome page.

For Apache or Nginx, setup a virtual host to point to the `www/` directory of the project and you
should be ready to go.

**It is CRITICAL that whole `app/`, `config/`, `log/` and `temp/` directories are not accessible directly
via a web browser. See [security warning](https://nette.org/security-warning).**
