Chess Diagram Generator
===
Library to dynamically generate chess diagrams

## Usage

### Step 1: install library via composer:

**Notice: you need [Imagick](http://pecl.php.net/package/imagick) library installed**

Add it to respositories section:

```json
{
    "type": "git",
    "url": "git@github.com:ChessCom/DiagramGenerator.git"
}
```

Add it to require section:

```json
"chesscom/diagram-generator": "dev-master"
```

### Step 2: create generator

You can define it as a service

```xml
<service id="diagram.generator" class="DiagramGenerator\Generator">
    <argument type="service" id="validator" />
</service>
```

or create with `new` operator

```php
$generator = new \DiagramGenerator\Generator($validator);
```

### Step 3: create config

Config is as a `\DiagramGenerator\Config` object

```php
$config = new Config();
$config
    ->setFen($fenString)
    ->setSizeIndex(2)
    ...
```

If config parameters can be represented as array (e.g. GET or POST parameters), jms serializer can be used to crete config object:

```php
$diagramConfig = $jmsSerializer->deserialize($inputParameters, 'DiagramGenerator\Config', 'json');
```

#### Config options

| Name        | Description                     | Values                     | Default      | Examples                    |
| ----------- | ------------------------------- | -------------------------- | ------------ | --------------------------- |
| size        | board size                      | 0-3 (0,1,2,3)              | 0            | `/diagram/size=2`           |
| theme       | theme (pieces) type             | 0-6                        | 1            | `/diagram/size=1&theme=5`   |
| texture     | board (squares) texture         | 0-3                        | None         | `/diagram/size=1&texture=1` |
| caption     | text to show under the board    | any url encoded string     | empty string | `/diagram/caption=php%20c#` |
| coordinates | show or not board coordinates   | true or false              | false        | `/diagram/coordinates=true` |
| light       | hex color of light board pieces | ^[a-fA-F0-9]{6}$           | eeeed2       | `/diagram/light=aecef2`     |
| dark        | hex color of dark board pieces  | ^[a-fA-F0-9]{6}$           | 769656       | `/diagram/dark=16a656`      |
| flip        | allows to flip the board        | true or false              | false        | `/diagram/flip=true`        |

### Step 4: create and render diagram

Its as simple as just call one method and set appropriate header:

```php
$diagram = $generator->buildDiagram($diagramConfig);
header('Content-Type: image/jpeg');
echo $diagram->getImage();
```

### Step 5: UrlHelper

UrlHelper class adds support of creating diagram image urls
To generate secure and non-secure urls:

```php
$urlHelper->getNonSecureUrl($config, $routingName);
$urlHelper->getSecureUrl($config, $routingName);
```
where $config is a `DigramGenerator\Config` object, `$routingName` is your routing name for the action, responsible for rendering diagrams

### Step 6: Validation

To enable config validation enable annotations for the validator

```php
$validator->enableAnnotationMapping();
```

or in sf2 config:

```yaml
framework:
    validation: { enable_annotations: true }
```

### Bonus

`Fen` object is a convenient way to work with fen strings and represents the board as a list of all pieces, each one is an instance of `DiagramGenerator\Fen\Piece` object, has color, row and column properties. It can be developed according to our future needs
