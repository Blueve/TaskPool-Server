#Javascript 代码风格指南

##目录
1. [源代码文件](#源代码文件)
1. [缩进与空格](#缩进与空格)
1. [区块](#区块)
1. [注释](#注释)
1. [变量](#变量)
1. [函数](#函数)
1. [JQuery](#JQuery)

## 源代码文件

  - 在网页的结尾引入Javascript文件，用于避免Javascript阻塞页面的加载

## 缩进与空格

  - 块内代码必须缩进，长度为4个空格，使用Tab进行缩进

    ```javascript
    // good
    function checkUser(id)
    {
    ∙∙∙∙return find(id);
	}

	// bad
	function checkUser(id)
	{
	return find(id);
	}

	// bad
    function checkUser(id)
    {
    ∙∙return find(id);
	}
    ```

  - 运算符的前后都应该添加空格

    ```javascript
    // good
    expr = (a + b) * c;

    // bad
    expr=(a+b)*c;
    ```

  - 参数表的逗号之后需空格，比较长的参数可以换行

    ```javascrpit
    // good
    bar = foo(a, b, c);
    
    // good
    bar = foo(longLongLongParameterA,
              longLongLongParameterB,
              longLongLongParameterC);
    
    // bad
    bar = foo(a,b,c);
    ```

## 区块

## 注释

## 变量

## 函数
  
  - 不要在非函数区块中定义函数

    ```javascript
    // bad
    if(something)
    {
        function foo()
        {
            // ...stuff...
        }
    }

    // good
    if(something)
    {
        bar = function foo()
        {
            // ...stuff...
        };
    }
    ```
  
  - 不要使用`arguments`作为函数的参数名

    ```javascript
    // bad
    function foo(user, arguments)
    {
        // ...stuff...
    }

    // good
    function foo(user, args)
    {
        // ...stuff...
    }
    ```

## JQuery

  - 使用$前缀标识选择器选择的结果对象

    ```javascript
    // bad
    button = $('#button');

    // good
    $button = $('#button');
    ```

  - 在同一代码段中选择相同容器的时候，应该将其缓存，避免多次进行选择
    
    ```javascript
    // bad
    $('#someone').hide();
    $('#someone').show();

    // good
    function foo(user, args)
    {
        $someone = $('someone');
        $someone.hide();
        $someone.show();
    }
    ```