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
`function(//key/*[odd()])`
Three parts: function, root, path, attribute

Root
----
No root or `/' means the path must start at the root
`//` means the path may start at any branch

Paths
-----
### empty

### wildcard
`?` matches exactly one character.
`*` matches zero or more characters.

### fnmatch

### normal

Numeric functions
-----------------
number()
abs
ceiling
floor
round
round-half-to-even
String functions
----------------
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

Aggregate functions
-------------------
### count()
Count the number of matched items

### avg()
Return the average value of the matched items (if numeric)

### max()
Return the greatest value of all matched items

### min()
Return the least value of all matched items

### sum()
Return the sum of all matched item values added together

Attributes
----------
### even()
Return only the even-indexed children of their parent.

### first()
Return only the items that are the first child of their parent.

### last()
Return only the items that are the last child of their parent.

### odd()
Return only the odd-indexed children of their parent.

### position()
Return the indexes of the items as an index number within their respective
parents. The first item has index value 1, so `[position()=2]` will match the
second children only.

### div

### mod

### and

### or

Todo
----
More XPath support
Additional syntax
Path validation regex
Additional syntax flag
Performance testing
Refactor into class?
Mock attribute support using '@' prefix (special or generic)
n-th child attribute