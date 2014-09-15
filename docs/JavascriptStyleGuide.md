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