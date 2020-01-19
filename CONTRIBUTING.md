# Contributing to this GitHub Profile Plugin API

## How we Talk

All converstaion for this API on GitHub, whether it's Pull Requests, Issues, Comments, anything... must follow these simple guidelines:

- Simple: We talk in clear English, so we can be understood by as many people as possible.
- Professional: We talk in a professional manner - calm and collected, never rude or mean.
- Welcoming: We talk in a way that welcomes all developers, no matter how experienced.

## How to Contribute

- Please make changes on your own fork.
- Test your changes out before implementing them.
- Ensure your code meets the style guidelines.
- Submit a Pull Request to the relevant branch.
- If your code meets the style guidelines, and passes my tests, I'll consider merging it in.

## Style Guidelines

Use these guidelines to ensure our code is as uniform and easy-to-read as possible.

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

- When writing PHP code, use long tags, not short tags.  Short tags only work when they're enabled by server admins, and are scheduled to be deprecated in a future update to PHP.

```php
<?php
// Correct.
?>

<?
// Incorrect.
?>
```

- When writing PHP code, code blocks open with ```<?php``` on it's own line, and close with ```?>``` on it's own line.

```php
<?php
do_this(0);
do_that(9);
?>// Correct

<?php do_this(0);
do_that(9); ?>// Incorrect.
```

- an exception the the above rule can be made when you're only calling one statement.  Then your PHP code can go on one line.

```php
<p><?php text(); ?></p>
```

#### Commenting Your Code

- Add meaningful comments to clarify what your code is trying to achieve.
- Use JavaDoc-style code comments where possible for all methods/functions to document your code.

```php
/**
 * This squares a given input, then adds 5.
 * @param input - The inputted number to preform this functon on.
 * @return output - The resultant number after this function.
 **/
function square_then_add_five($input)
{
  $output = $input * $input;
  $output += 5;
  return $output;
}
```

- Use inline comments wherever you feel your code may be unclear on it's own.

## Thanks

- This was blatantly copied and cut down from BlogDraw Beta 2.1, Version 0.0.1's CONTRIBUTING.md.
