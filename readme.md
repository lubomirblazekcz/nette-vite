Nette Vite
=================

Welcome to the Nette Web Project! This is a basic skeleton application built using
[Nette](https://nette.org), ideal for kick-starting your new web projects.

Nette is a renowned PHP web development framework, celebrated for its user-friendliness,
robust security, and outstanding performance. It's among the safest choices
for PHP frameworks out there.

If Nette helps you, consider supporting it by [making a donation](https://nette.org/donate).
Thank you for your generosity!


Requirements
------------

This Web Project is compatible with Nette 3.2 and requires PHP 8.1.


Installation
------------

To install the Web Project, Composer is the recommended tool. If you're new to Composer,
follow [these instructions](https://doc.nette.org/composer). Then, run:

	composer install


Web Server Setup
----------------

To quickly dive in, use PHP's built-in server:

	export NETTE_DEBUG=true && php -S localhost:8000 -t www

Then, open `http://localhost:8000` in your browser to view the welcome page.

For Apache or Nginx users, configure a virtual host pointing to your project's `www/` directory.

**Important Note:** Ensure `app/`, `config/`, `log/`, and `temp/` directories are not web-accessible.
Refer to [security warning](https://nette.org/security-warning) for more details.


Docker
----------------

Alternatively you can also use [Docker](https://www.docker.com/) for local development:

	composer run dev

Then, open `http://localhost` in your browser to view the welcome page.

Vite
----------------

This Web Project also includes [@contributte/vite](https://github.com/contributte/vite) for seamless frontend development.
Node.js is required, after that you can run following commands:

[Node.js](https://nodejs.org) is required, to install the dependencies run:

	npm install

To run Vite run:

	npm run dev

To build Vite run:

	npm run build
