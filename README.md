## About Hedo

Hedo is (at least at this time) a very minimalistic and basic framework that I've written as a school project but that I plan to maintain and develop as I use it for my personnal projects.<br />
It is composed of 20 classes which by their name and their nature, should be self-explanatory enough about how the framework can help you.

**11 very core classes**:

 - Autoloader
 - Config
 - Container
 - Dispatcher
 - Gateway
 - Initializer
 - Request
 - Response
 - Router
 - Session
 - Toolbox

**4 abstract classes**:

 - AbstractController
 - AbstractMapper
 - AbstractModel
 - AbstractRepository

**5 interfaces**:

 - ControllerInterface
 - MapperInterface
 - ModelInterface
 - RepositoryInterface
 - GatewayInterface

### Main Characteristics

#### The View

Architecture purists would argue that it's MVP and not MVC, however, I find it personnaly, much more natural and straightforward to implement and use the views this way...<br />
You implement your views as dumb HTML templates. The `AbstractController` has a method `render(string $template, array $data)` which basically returns as a string your template filled with your data (Symfony like), which you then output via the `Response->setBody($html)` and `Response->send()`...

#### The Model Layer

Its very basic ORM implements:

 - Data gateway pattern
 - Data mapper pattern
 - Repository pattern
 - Domain model pattern

### Phylosophy

KISS > Flexibility > Extensibility

### Important Notes

Note that this framework is still in pre-alpha, so it may include new features and possibly heavy changes anytime soon...<br />
Note also that PHP versions lower than the **7** *might* never be supported...

## Contributing

Constructive issues/PRs of any type are more than welcome !

## Doc

Working on the doc... Meanwhile, you can check my [blogging system](https://github.com/opportus/blogging-system) to learn how to base your app on Hedo.
