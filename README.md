## About Hedo

Hedo is a simple, lightweight and flexible framework I've written as a school project but that I maintain and develop as I use it for my personnal projects.<br />

### The View System

You implement your views as dumb HTML templates. Then in your controller...

```php
class MyController extends Core\Base\AbstractController
{
	$body = $this->response->getBody()
		->write($this->render('myTemplate.php', array('title' => $title)));

	$this->response->withBody($body)->send();
}
```

...Symfony like.

### The Model Layer

Its basic ORM implements:

 - Data gateway
 - Data mapper
 - Repository
 - Model factory
 - Domain model

### PSR

Hedo is compliant to:

 - PSR1
 - PSR2
 - PSR4
 - PSR7
 - PSR11

### Phylosophy

KISS > Flexibility > Extensibility

### Important Notes

Note that this framework is still in pre-alpha, so it may include new features and possibly heavy changes anytime soon...<br />
Note also that PHP versions lower than the **7.0** *might* never be supported...

## Contributing

Constructive issues/PRs of any type are more than welcome !

## Doc

Working on the doc... Meanwhile, you can check my [blog](https://github.com/opportus/blog) to learn how to base your app on Hedo.
