Nette Vite
=================

This is a simple, skeleton application using the [Nette](https://nette.org). This is meant to
be used as a starting point for your new projects.

[Nette](https://nette.org) is a popular tool for PHP web development.
It is designed to be the most usable and friendliest as possible. It focuses
on security and performance and is definitely one of the safest PHP frameworks.

If you like Nette, **[please make a donation now](https://nette.org/donate)**.

In addition, this skeleton provides complete solution for fast, compelling applications with a minimal amount of effort.

* [Vite](https://vitejs.dev/) - next generation frontend tooling 
* [Tailwind 3+](https://tailwindcss.com/) - a utility-first CSS framework packed with classes
* [Stimulus 3+](https://stimulus.hotwired.dev/) - designed to augment your HTML with just enough behavior to make it shine
* [Turbo 7+](https://turbo.hotwired.dev/) - accelerates links and form submissions by negating the need for full page reloads

Requirements
------------

- PHP 8.0
- Node.js LTS
- Docker


Local Setup
------------

The best way to install Web Project locally is using Docker. If you don't have Docker yet,
download it following [the instructions](https://www.docker.com/products/docker-desktop). 

Use following commands:
    
    mkdir nette-vite && cd nette-vite
	git clone --depth 1 https://github.com/evromalarkey/nette-vite.git . && npm i

That downloads the project from Github, installs `package.json` dependencies. After that you can serve your project from localhost

	docker compose up
    npm run dev

Then visit `http://localhost` in your browser to see the welcome page.

JS and CSS files are served via Vite, directly from sources. Any file changes reloads the browsers for fast local development.

> On Windows it's recommended to use **WSL2** to run everything (Docker, Node.js via nvm), it's the best approach. Otherwise, some docker scripts inside package.json would work only in PowerShell. 

> When correct Node.js version is set in **PhpStorm** (WSL2 on Windows), you can use build-in npm to install dependencies or run scripts via GUI.


Production Setup
----------------

Make directories `temp/` and `log/` writable.

For Apache or Nginx, setup a virtual host to point to the `www/` directory of the project and you
should be ready to go.

**It is CRITICAL that whole `app/`, `config/`, `log/` and `temp/` directories are not accessible directly
via a web browser. See [security warning](https://nette.org/security-warning).**

Vite
----------------
There are few possible ways how to load assets with Vite in your latte templates.

Option 1 - most basic, preferred
```latte
{if $vite->isEnabled()}
    <script type="module" src="{='@vite/client'|asset}"></script>
{/if}

<script src="{='src/scripts/main.js'|asset}" type="module"></script>
<link rel="stylesheet" href="{='src/styles/main.css'|asset}">
```

Option 2 -if you prefer to include css in `.js`, use this option
```latte
{if $vite->isEnabled()}
    <script type="module" src="{='@vite/client'|asset}"></script>
{else}
    {foreach $vite->getCssAssets('src/scripts/main.js') as $path}
        <link rel="stylesheet" href="{$path}">
    {/foreach}
{/if}

<script src="{='src/scripts/main.js'|asset}" type="module"></script>
```

Option 3 - same as second option, but print all `<script>` and `<link>` tags automatically, with this you have to also include css in `.js`
```latte
{$vite->printTags('src/scripts/main.js')}
```
