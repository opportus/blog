A simple little blog system written as a school project...

## Installation

**Requirements**:

- LAMP system
- Composer
- Git

From your terminal, download the [installer script](https://gist.github.com/opportus/d8bd16d52ef7b55c3d415c2b34c7280d), make sure it's excecutable and then run it with for example:

```shell
curl https://gist.githubusercontent.com/opportus/d8bd16d52ef7b55c3d415c2b34c7280d/raw/ba30d29f70db3f453ade065e45b16a8d1c92e2a5/installer.sh >> installer.sh && chmod u+x installer.sh && ./installer.sh
```

Then simply follow instructions that the installer will prompt to you...

From your input, the installer will:

- Git clone the blog-system
- Install Composer blog-system dependencies
- Creates a new MySQL database, its user, and the `post` table
- Setup blog-system's `config.php`
