A simple little blog system written as a school project...

## Installation

**Requirements**:

- LAMP system
- Composer
- Git

Download the [installer script](https://github.com/opportus/installer.git):

`curl https://gist.githubusercontent.com/opportus/3452f63e692897a40eabd7b27bf9aa2d/raw/b12d2a1ff8d13249c961e97d9992af2db4689e8b/installer.sh >> installer.sh`

Then run:

`./installer.sh`

Then simply answer the questions the intaller will prompt to you...

From your input, the installer will:

- Git clone the blog-system
- Install Composer blog-system dependecies
- Creates a new MySQL database, its user, and the `post` table
- Setup blog-system's config.php (database credentials)
