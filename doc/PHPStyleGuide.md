#代码风格指南

##PHP

##目录
###1. [源代码文件](#源代码文件)
###2. [变量](#变量)
###3. [函数/方法](#函数/方法)
###4. [类](#类)

###1. 源代码文件
```php
// good
<?php
    # body

// bad
<?php
    # body
?>
```

###2. 缩进、括号及注释

####1. 流程控制语句
```php
// good
if($a > $b)
{
    // if body
} 
else 
{
    // else body
}

// bad
if($a > $b) {
    // if body
} else {
    // else body
}

// bad
if($a > $b)
    // statement
else
    // statement
```

####2. 函数/方法

```php
// good
function foo()
{
    // function body
}

// bad
function foo() {
    // function body
}
```

####3. 闭包

```php
// good
$foo = function()
{
    // closure body
}

// bad
$foo = function() {
    // closure body
}
```

####4. 表达式

```php
// good
$expr = ($a + $b) * $c;

// bad
$expr=($a+$b)*$c;
```

####5. 参数表

```php
// good
$bar = foo($a, $b, $c);

// good
$bar = foo($longLongLongParameterA,
           $longLongLongParameterB,
           $longLongLongParameterC);

// bad
$bar = foo($a,$b,$c);
```

###3. 变量

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

###4. 函数/方法

####1. 命名

```php
// good
function VarDump()
{
    // function body
}

// good
function isValid()
{
    // function body
}

// bad
function var_dump()
{
    // function body
}

// bad
function IsValid()
{
    // function body
}
```

####2. 参数表

```php
// good
function foo($a, $b)
{
    // function body
}

// good
function foo(Type1 $longLongLongParameterA,
             Type2 $longLongLongParameterB,
             Type3 $longLongLongParameterC)
{
    // function body
}

// bad
function foo($longLongLongParameterA, $longLongLongParameterB, $longLongLongParameterC)
{
    // function body
}

// bad
```

###5. 类

####1. 定义

```php
// good
class MyClass
{
    // class body
}

// bad
class myClass
{
    // class body
}
```
####2. 属性和方法

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