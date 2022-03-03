# Contributing

When contributing, please first discuss the change you wish to make via an [issue](https://github.com/JamesPhillipsUK/GitHubProfilePluginAPI/issues/new) before making a change.

## Pull Request Process

1. Fork the repository to work on.
2. Create your changes, ensure they meet the style guidelines below, and test them.
3. Increase the version numbers in any files containing an @version tag to the new version that this Pull Request would represent.
4. Open a Pull Request and request a reviewer to merge it for you.

## Style Guidelines

### Files and Directories

- Use 'underscored_lower_case' for file names.

### Code Style

- Use two spaces to indent code.
- Braces have their own lines.

```php
function do_this()
{
  ...
}// Correct.

function do_this(){...}// Incorrect.

function do_this(){
  ...
}// Also incorrect.
```

- Always indent code contained within braces.
- Braces aren't necessary for one-line loops and statements, but indentation is.

```php
if (1 == 1)
  return true;// Correct.

if (2 == 2)
{
  return true;// Incorrect.
}
```

- Don’t leave trailing white space at the end of your lines.
- Write one statement per line.
- Give your variables meaningful names.
- Use ‘camelCase’ for variable names.

```php
thisInteger = 7;
```

- Use 'underscored_lower_case' for method/function names in PHP.

```php
function this_funtion()
{
  ...
}
```

- When writing PHP code, use long tags, not short tags.  Short tags only work when they're enabled by server admins, and are deprecated.  These tags should have their own line.

```php
<?php
// Correct.
?>

<?
// Incorrect.
?>
```

```php
<?php
do_this(0);
do_that(9);
?>// Correct

<?php do_this(0);
do_that(9); ?>// Incorrect.
```

- An exception the the above rule can be made when you're only calling one statement.  Then your PHP code can go on one line.

```php
<p><?php text(); ?></p>
```

#### Commenting Your Code

- Use meaningful inline comments where you feel your code may be unclear on it's own.  Clean code needs minimal comments.
- Use PHPDoc comments where possible to document your methods.

```php
/**
 * This squares a given input, then adds 5.
 * @param    int    $input    The inputted number to preform this functon on.
 * @return   int    $output   The resultant number after this function.
 **/
function square_then_add_five($input)
{
  $output = $input * $input;
  $output += 5;
  return $output;
}
```

## Code of Conduct

As contributors to this project, we seek to ensure the community is free of harrassment for everyone; regardless of who they may be, their background, or any of their characteristics.

We interact in ways that are open, welcoming, diverse, inclusive, and healthy.

We follow the [Software Engineering Code of Ethics and Professional Practice](https://ethics.acm.org/code-of-ethics/software-engineering-code/).

## Thanks

This was inspired by:

- BlogDraw [Beta 2.1, Version 0.0.1's CONTRIBUTING.md](https://github.com/BlogDraw/BlogDraw/releases/tag/v0.0.1-beta-2.1).
- PurpleBooth's [Good Contributing template](https://gist.github.com/PurpleBooth/b24679402957c63ec426).
