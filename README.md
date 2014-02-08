APath
=====

XPath-like path specifiers for plain PHP arrays.

XPath or XPath-like?
--------------------
Not all of XPath makes sense for arrays. Conversely, arrays would benefit from
features that XPath does not have. There is some level of portability between
the two, but it's perfectly easy to write path expressions in either language
that won't work in the other. We're talking XPath-like as in "it kinda
looks like XPath at first sight".

APath path expressions
----------------------
`//key/*[odd()]`
Three parts: function, path, expression

Paths
-----
empty
wildcard
fnmatch
normal

Functions
---------
### Numeric
number()
abs
ceiling
floor
round
round-half-to-even
### Strings
string()
concat
string-join
substring
string-length()
normalize-space
upper-case
lower-case
translate
tokenize
### Aggregate
count()
avg()
max()
min()
sum()

Expressions
-----------
first()
last()
position()
odd()
even()
not
boolean


Todo
----
More XPath support
Additional syntax
Path validation regex
Additional syntax flag
Performance testing
Refactor
Testsuite
Mock attribute support using '@' prefix (special or generic)
Javascript version, other languages