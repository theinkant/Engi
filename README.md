## SQL template engine (engi)
Act like [sprintf](https://www.php.net/manual/en/function.sprintf.php),
but placeholders are customizable, extendable, its behavior is flexible and sql-oriented.

### TL;DR
`i?` - trying convert to int sql type positional parameter  
`i?name1` - trying convert to int sql named parameter "name1"  
`?` - trying resolve passed positional parameter type to reasonable sql type  
`?name1` - trying resolve passed named parameter "name1" type to reasonable sql type
```php
$query = new \Inkant\Engi\Query(
    'SELECT i?, ?, ?name1, i?name1', [
    '100',
    100,
    'name1' => '454'
]);

$result = "SELECT 100, 100, '454', 454";
$compiler = new Compiler(new DummyEscaper());
$compiler->compile($query) === $result
    ?: throw new \Exception();
```
[More descriptive test case](tests/QueryTest.php) with subquery and parameter types  
Check resolvers setup example in [Query](src/Query.php)::resolvers() it can be extended  to customize placeholders or/and customize resolvers
### Architecture
[Contracts that describing concepts](src/Contracts)  

[Parsers](src/Contracts/ParserInterface.php) are responsible for providing [placeholders](src/Contracts/PlaceholderInterface.php) from string template
as parts of [Abstract syntax tree](src/Contracts/AstInterface.php).  
[Abstract syntax tree](src/Contracts/AstInterface.php) is an implementation of `composite` pattern,
where leaf is a [token](src/Contracts/TokenInterface.php)(must have string representation) in sql context
and [composites](src/Contracts/AstNodeInterface.php)(e.g.[placeholders](src/Contracts/PlaceholderInterface.php)) are more complex sql expressions.  
Every [composite](src/Contracts/AstNodeInterface.php) must be transformed to [tokens](src/Contracts/TokensInterface.php)
by calling `compile(mixed ...$dependencies)` method.  
Every [token](src/Contracts/TokenInterface.php) must be transformed to string
by calling `compile(mixed ...$dependencies)` method.  
[Tokens](src/Contracts/TokensInterface.php) must be assembled
by [assembler](src/Contracts/AssemblerInterface.php) calling method
`assemble` providing [Tokens](src/Contracts/TokensInterface.php) and `...$dependencies`.

`...$dependencies` are any required dependencies during `compile`(e.g. database version/name, escape string mechanism).
### Placeholders
Placeholders are just substrings with optionally following name `[a-zA-Z0-9_]+` string:  
`?` - if no name provided, using next positional parameter    
`?email` - using array parameters item with key `email`    
`i?id` - convert using array parameters item with key `id` to `int`

Placeholders making possible using named and positional parameters at once.  
Also, it lets reusing one value in different contexts:  
`i?id` - will convert string value '100' to sql `integer` value 100  
`s?id` - (value type is obvious, can be replaced by "?id")  will convert string value '100' to sql `text` value '100'  
`?id` - will resolve value '100' to sql `text` value '100' based on value type that is string
```php
$query = new \Inkant\Engi\Query(
    'SELECT i?id, s?id, ?id', [
    'id' => '100'
]);

$result = "SELECT 100, '100', '100'";
$compiler = new Compiler(new DummyEscaper());
$compiler->compile($query) === $result
    ?: throw new \Exception();
``` 
To determine by what exactly placeholder must be replaced, placeholders using [resolvers](#resolvers). 
### Resolvers
Resolvers responsible for resolving passed values to placeholders into sql values/expressions.  
Resolvers are simple, here is [StringResolver](src/Resolvers/StringResolver.php) example:  
```php
class StringResolver extends ResolverAbstract
{
    public function resolve(mixed $value): ?StringToken
    {
        return is_string($value)
            ? new StringToken($value)
            : null;
    }
}
```
   
  
 



 