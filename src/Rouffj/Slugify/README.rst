Slugify, an agnostic slug generator
===================================

Domain language
---------------
To be able to generate a slug of a string there is always two 2 steps:

- The transliteration step which convert a given string from any writing system
  (French, Deutsh, Greek, Arabic...) into its ASCII representation.
- The slug generation step which basically separate each word and field by a custom delimiter.

How to use it with Doctrine2
----------------------------

How to use it with Propel2
--------------------------
