#PHP 代码风格指南

##目录
1. [源代码文件](#源代码文件)
1. [缩进与空格](#缩进与空格)
1. [区块](#区块)
1. [注释](#注释)
1. [变量](#变量)
1. [函数](#函数)
1. [类](#类)

## 源代码文件

  - 纯PHP脚本程序**不使用`?>`**封闭

    ```php
    <?php
        // ...stuff...
    ```

  - 一个类保存为一个文件，文件名与类名一致

    > User.php
    ```php
    class User
    {
        // ...stuff...
    }
    ```

## 缩进与空格

  - 块内部的代码必须缩进，大小为4个空格

    ```php
    // good
    $foo = function($var)
    {
    ∙∙∙∙return $var * $var;
    }

    // bad
    $foo = function()
    {
    return $var * $var;
    }

    // bad
    $foo = function()
    {
    ∙∙return $var * $var;
    }
    ```

  - 运算符的前后都应该添加空格

    ```php
    // good
    $expr = ($a + $b) * $c;

    // bad
    $expr=($a+$b)*$c;
    ```

  - 参数表的逗号之后需空格，比较长的参数可以换行

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

## 区块

  - 起始的大括号永远换到下一行，且不应被省略

    ```php
    // good
    if($a > $b)
    {
        // ...stuff...
    } 
    else 
    {
        // ...stuff...
    }

    // bad
    if($a > $b) {
        // ...stuff...
    } else {
        // ...stuff...
    }

    // bad
    if($a > $b)
        // statement
    else
        // statement
    ```

## 注释

  - 多行注释需要标明标题和描述

    ```php
    /* Title
     * Description
     */
    ```

  - 文档型注释参考[phpDocumentor](http://phpdoc.org/docs/latest/getting-started/your-first-set-of-documentation.html)标准

    ```php
    /**
     * Doc title
     *
     * Doc description
     *
     * @return TYPE
     */  
    ```

  - 对较长块的单行注释需要放在块的前一行

    ```php
    // Description
    while($a > $b)
    {
        // ...stuff...
    }
    ```

  - 对单行语句的注释需要放到语句后并对齐

    ```php
    class Apple
    {
        public $color;  // Description
        public $type;   // Description
    }
    ```

  - 块的注释需要在注释前面空一行

    ```php
    // good
    // Description
    fooA();

    // Description
    fooB();

    // bad
    // Description
    fooA();
    // Description
    fooB();
    ```

## 变量

  - 变量的首字母小写，后继的单词首字母都大写

    ```php
    // good
    $myVar;

    // bad
    $MyVar;

    // bad
    $my_var;
    ```

  - 字符串使用单引号包围

    ```php
    // good
    $str = 'hello world';

    // bad
    $str = "hello world";
    ```

  - 多行字符串使用拼接符号换行拼接，`.`与`=`对齐

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

  - 简单数组使用中括号的方式定义

    ```php
    // good
    $arr = ['a', 'b', 'c'];

    // bad
    $arr = array('a', 'b', 'c');
    ```

  - 较复杂的数组换行声明，并且每一行末位都要添加`,`

    ```php
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

## 函数

  - 函数的首字母大写，后继单词首字母大写

    ```php
    // good
    function VarDump()
    {
        // ...stuff...
    }

    // bad
    function var_dump()
    {
        // ...stuff...
    }

    // bad
    function vardump()
    {
        // ...stuff...
    }
    ```

  - 参数表逗号后面需要加空格，较复杂参数表需要逐个换行声明

    ```php
    // good
    function Foo($a, $b)
    {
        // function body
    }

    // good
    function Foo(Type1 $longLongLongParameterA,
                 Type2 $longLongLongParameterB,
                 Type3 $longLongLongParameterC)
    {
        // function body
    }

    // bad
    function Foo($longLongLongParameterA, $longLongLongParameterB, $longLongLongParameterC)
    {
        // function body
    }
    ```

## 类

  - 类名首字母大写，后继单词首字母大写

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

  - 属性和方法首字母小写，后继单词首字母大写

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

  - 私有类型的属性增加`_`前缀

    ```php
    class MyClass
    {
        private $_id;
    }
    ```

  - 常量全部字母大写，单词用`_`连接

    ```php
    class MyClass
    {
        const FIND_PSW = 'FIND_PSW';
    }
    ```

  - EntityModel中的枚举类型(与数据库ENUM对应)使用常量表示时，全部字母小写，使用`_`连接

    ```php
    class MyClass
    {
        const important = 'important';
        const urgent    = 'urgent';
        const date      = 'date';
        const custom    = 'custom';
    }
    ```

  - 接收POST请求的方法，在前一种命名的基础上增加`_post`后缀
    ```php
    class MyClass
    {
        public function findPassword_post()
        {
            // ...stuff...
        }
    }
    ```

  - 静态方法的`static`放置在方法访问权限标识符`public` `private` `protocted`的后面
    ```php
    class MyClass
    {
        public static function find()
        {
            // ...stuff...
        }
    }
    ```