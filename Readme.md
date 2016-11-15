Web Syntax Highlighter
======================

Given a block of code, these PHP functions will wrap `<style>` tags around coding
syntax (keywords, digits, operators, etc).

This allows a web devloper to use CSS to style the syntax, enabling elegant
dynamic displays of code on websites.

CSS Classes
-----------

These are the css classes you will need to use to style the syntax.
<pre>
.code-block
    This is the encompassing <pre> block that contains all of the code

.code-block-comment
    For both single-line and multi-line comments

.code-block-string
    Double-quoted text

.code-block-keyword
    Syntax words like class, public, bool, void, new

.code-block-command
    Syntax words like break, for, if, return, while

.code-block-digit
    Numbers
</pre>
