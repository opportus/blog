A simple little blog system written as a school project...

## Installation

**Requirements**:

- LAMP system
- Composer
- Git

Download the [installer script](https://github.com/opportus/installer.git) script:

`curl https://raw.githubusercontent.com/opportus/installer/master/installer.sh >> installer.sh`

Then run:

`./installer.sh`

Then simply answer the questions the intaller will prompt to you...

From your input, the installer will:

- Git clone the blog-system
- Install Composer blog-system dependecies
- Creates a new MySQL database, its user, and the `post` table
- Setup blog-system's config.php (database credentials)
