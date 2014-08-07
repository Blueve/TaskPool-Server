#代码风格指南

##PHP

###1.源代码文件
```php
// good
<?php
    #...your code...

// bad
<?php
    #...your code...
?>
```
###2.变量
####1. 命名

```php
// good
$myVar;

// bad
$MyVar;

// bad
$my_var;
```
####2. 字符串

```php
// good
$str = 'hello world';

// bad
$str = "hello world";
```

```php
// good
$sql = 'SELECT name'
     . 'FROM user'
     . 'WHERE id = 1';
     
// bad
$sql = 'SELECT name
        FROM user
        WHERE id = 1';
```

####3. 数组

```php
// good
$arr = ['a', 'b', 'c'];

// bad
$arr = array('a', 'b', 'c');

// good
$arr = array(
            '1' => 'a',
            '2' => 'b',
            '3' => 'c',
            );

// bad
$arr = array(
            '1' => 'a',
            '2' => 'b',
            '3' => 'c'
            );

```

###3. 函数

####1. 函数命名

```php
// good
function VarDump()
{

}

// good
function isValid()
{

}

// bad
function var_dump()
{

}

function IsValid()
{

}
```

###4. 类

```php
// good
class MyClass
{

}

// bad
class myClass
{

}

// bad
class MyClass {
    
}
```

```php
class MyClass
{
    // good
    public $id;
    // good
    public $leftChildId;
    // bad
    public $RightChildId;

    // good
    public function getId()
    {
        return $this->id;
    }

    // bad
    public function GetId()
    {
        return $this->Id;
    }
}
```