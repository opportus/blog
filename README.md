A simple little blog system written as a school project...

## Installation

**Installation requirements**:

- LAMP system
- Git
- Composer

### The automatic installation (time estimation: ~1-2 minuts)

From your terminal, download the [installer script](https://gist.github.com/opportus/d8bd16d52ef7b55c3d415c2b34c7280d), make it excecutable and then run it.
This can be achieved with for example the following command:

```shell
curl https://gist.githubusercontent.com/opportus/d8bd16d52ef7b55c3d415c2b34c7280d/raw/ba30d29f70db3f453ade065e45b16a8d1c92e2a5/installer.sh >> installer.sh && chmod u+x installer.sh && ./installer.sh
```

Then simply follow instructions that the installer will prompt to you...

From your input, the installer will:

- Git clone the blog-system
- Install Composer blog-system dependencies
- Creates a new MySQL database, its user, and the `post` table
- Setup blog-system's `config.php`

### The manual installation (time estimation: ~5-10 minuts)

#### Blog installation

Clone the repository:
```shell
git clone https://github.com/opportus/blog.git /path/to/my/blog
```

Install the dependencies:
```shell
composer --working-dir="/path/to/my/blog" install
```

#### MySql environment setup

Create the database:
```shell
mysql -u ${mysql_root_name} -p${mysql_root_password} -e "CREATE DATABASE ${mysql_db_name} CHARACTER SET = 'utf8' COLLATE = 'utf8_general_ci';"
```

Create its user and grant privileges:
```shell
mysql -u ${mysql_root_name} -p${mysql_root_password} -e "CREATE USER ${mysql_db_user}@${mysql_db_host} IDENTIFIED BY '${mysql_db_pass}';"
mysql -u ${mysql_root_name} -p${mysql_root_password} -e "GRANT ALL PRIVILEGES ON ${mysql_db_name}.* TO '${mysql_db_user}'@'${mysql_db_host}';"
mysql -u ${mysql_root_name} -p${mysql_root_password} -e "FLUSH PRIVILEGES;"
```

Create the post table:
```shell
mysql -u ${mysql_root_name} -p${mysql_root_password} -e "USE ${mysql_db_name};
	CREATE TABLE post
	(
		id bigint unsigned NOT NULL AUTO_INCREMENT,
		slug varchar(254) NOT NULL,
		author varchar(50) NOT NULL,
		created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated_at datetime,
		title varchar(255),
		excerpt tinytext,
		content longtext,
		CONSTRAINT pk_post_id PRIMARY KEY (id)
	);
	CREATE UNIQUE INDEX ix_post_slug ON post (slug);"
```

#### Blog configuration

Define configuration constants in `/path/to/my/blog/src/config.php`...

You're done.
