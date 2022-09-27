# Configuration

With the `#[Configuration]` attribute the time is coming stop calling your configuration object which contains all your settings. Just assign the config path to your class property with the attribute `#[Value]`, implement your getter and your access directly the value.

### Example

```php 
#[Configuration]
class Config
{
    #[Value('dataSource.mysql.password')]
    private string $password;

    #[Value('dataSource.mysql.user')]
    private string $user;

    #[Value('dataSource.mysql.database')]
    private string $database;

    #[Value('dataSource.mysql.host')]
    private string $host;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}

class PdoReader implements ReaderInterface
{
    private null|PDO $connection = null;

    #[Autowired]
    private Config $config;

    ....
}

```

### Supported configuration types


| Supported configuration types | 
|-------------------------------|
| yaml                          | 


### Handle environment variables

We have now the possibility to access easily environment variables within a class.
Firstly you need to register the new `Configuration\Env\EnvironmentHandler` in your bootstrap file. Handler contains the logic to read .env if you define the following constant `APPLICATION_ENV_FILE_PATH`

```php 
DependencyContainer::getInstance()->addCustomHandler(new EnvironmentHandler());
```

Define now your class which should get some environment variable values like

```php 

class EnvConfig
{
    #[Env('TEST_ONE')]
    private int $valueOne;

    #[Env('TWO')]
    private int $valueTwo;

    #[Env('THREE_FOR_TEST')]
    private int $valueThree;

    #[Env('SOME_TEXT')]
    private string $word;

    #[Env('SINGLE_QUOTES')]
    private string $singleQuotes;

    #[Env('PHP_ARRAY_STYLE')]
    private array $arrayStyle;

    public function getValueOne(): int
    {
        return $this->valueOne;
    }

    public function getValueTwo(): int
    {
        return $this->valueTwo;
    }

    public function getValueThree(): int
    {
        return $this->valueThree;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getSingleQuotes(): string
    {
        return $this->singleQuotes;
    }

    public function getArrayStyle(): array
    {
        return $this->arrayStyle;
    }
}
```

Now you are ready to assign the data to the class properties. Just call now 
```php
$envConfig = DependencyContainer::getInstance()->get(EnvConfig::class);
```
and you get your object back with assigned values.
