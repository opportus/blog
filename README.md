A simple little blog system written as a school project...

## Installation

**Requirements**:

- LAMP system
- Composer
- Git

From your terminal, download the [installer script](https://gist.github.com/opportus/87b1fd0f12a501cb81130edbd79b4392) with for example:

```shell
curl https://gist.githubusercontent.com/opportus/87b1fd0f12a501cb81130edbd79b4392/raw/427a998bcd1eac4764f8809f6d48d34528408461/installer.sh >> installer.sh
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
