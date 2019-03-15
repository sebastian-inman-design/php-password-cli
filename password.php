#!/usr/bin/php

<?php

/**
 * PHP Password Generator
 * Generate a random password or passphrase from the terminal.
 * 
 * @param return [string] (phrase | string) What kind of password to return.
 * @param length [integer] The total number of words in a passphrase OR the total length of a password string.
 * @param min [integer] The mininum length of each word in the phrase (only used when "return" is set to phrase).
 * @param max [integer] The maximum length of each word in the phrase (only used when "return" is set to phrase).
 * 
 * @example password return=phrase length=4 min=3 max=8
 * Returns a passphrase 4 words in length, each word between between 3 and 8 characters.
 * 
 * @example password return=string length=12
 * Returns a password string 12 characters long.
 * 
 */

// Strip filename from arguments.
$arguments = array_shift($argv);

// Set of available characters.
$phrase_characters = 'abcdefghjkmnqrstuvwy';

$string_characters = array();
$string_characters[] = 'abcdefghijklmnopqrstuvwxyz';
$string_characters[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$string_characters[] = '1234567890';
$string_characters[] = '!@#$%^&*=+';

$options = array(
  'return' => 'phrase', // What kind of password to return.
  'length' => 4, // The total number of words in a passphrase OR the total length of a password string.
  'min'    => 4, // The mininum length of each word in the phrase (only used when "return" is set to phrase).
  'max'    => 8  // The maximum length of each word in the phrase (only used when "return" is set to phrase).
);

$password = array();


// Looping through the arguments.
foreach($argv as $key => $argument):

  // Finding commands and values from the list of passed arguments.
  if(preg_match( "/^-{0,2}(?'argument'[^-=\s]+)=(?'value'.*)/", $argument, $match )):

    // Storing each argument and value.
    if(array_key_exists($match['argument'], $options)):

      // Update options based with user arguments.
      $options[$match['argument']] = $match['value'];
  
    endif;

  endif;

endforeach;


/**
 * Generate a password "string".
 */

if($options['return'] === 'string'):

  // Generate the password string.
  while($loop < $options['length']):

    // Get a random character from the character set.
    $character_set = $string_characters[array_rand($string_characters)];
    $password[] = $character_set[array_rand(str_split($character_set))];

    $loop++; // Just keep swimming...

  endwhile;

  // Return the password string.
  echo implode('', $password) . "\n";

endif;


/**
 * Generate a password "phrase".
 */

if($options['return'] === 'phrase'):

  // Dictionary API endpoint.
  $endpoint = 'https://api.datamuse.com/words?max='.$options['length'].'&sp=';

  // Generate the password phrase.
  while($loop < $options['length']):

    // Get a random character from the character set.
    $character = $phrase_characters[array_rand(str_split($phrase_characters))];

    // Set a random length of a word from the selected character.
    $strength = rand($options['min'], $options['max']);

    // Assemble the API request URI.
    $fetch = $endpoint . $character . str_repeat('?', $strength);

    // Decode the JSON returned from the API endpoint.
    if($returned = json_decode(file_get_contents($fetch), true)):

      // Append the returned word to the password phrase.
      $password[] = $returned[array_rand($returned)]['word'];

    endif;

    $loop++; // Just keep swimming...

  endwhile;

  // Return the password phrase.
  echo implode(' ', $password) . "\n";

endif;
