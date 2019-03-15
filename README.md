# PHP Password Generator
Generate a random password or passphrase from the terminal.

**@param** *return* [string] (phrase | string) What kind of password to return.
**@param** *length* [integer] The total number of words in a passphrase OR the total length of a password string.
**@param** *min* [integer] The mininum length of each word in the phrase (only used when "return" is set to phrase).
**@param** *max* [integer] The maximum length of each word in the phrase (only used when "return" is set to phrase).

**@example** `password return=phrase length=4 min=3 max=8`

Returns a passphrase 4 words in length, each word between between 3 and 8 characters.

**@example** `password return=string length=12`

Returns a password string 12 characters long.
