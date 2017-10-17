A simple little blog system written as a school project...

## Installation

**Requirements**:

- LAMP system
- Composer
- Git

From your terminal, download the [installer script](https://gist.github.com/opportus/77d673134b1ac97812682edf34660bb2) with for example:

```shell
curl https://gist.githubusercontent.com/opportus/77d673134b1ac97812682edf34660bb2/raw/2711c50417a94d86c63af81e8599a099ccc6420e/installer.sh >> installer.sh
```

Then run:

```shell
./installer.sh
```

Then simply answer the questions the intaller will prompt to you...

From your input, the installer will:

- Git clone the blog-system
- Install Composer blog-system dependencies
- Creates a new MySQL database, its user, and the `post` table
- Setup blog-system's `config.php`
