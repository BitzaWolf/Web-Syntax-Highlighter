<?php

function printCPPCodeBlock($code)
{
  global $REGEX_cpp_keywords, $REGEX_cpp_commands;
  
  printCodeBlock($code, $REGEX_cpp_keywords, $REGEX_cpp_commands);
}

function printJavaCodeBlock($code)
{
  global $REGEX_java_keywords, $REGEX_java_commands;
  
  printCodeBlock($code, $REGEX_java_keywords, $REGEX_java_commands);
}

function printCodeBlock($code, $keywords, $commands)
{
  global $REGEX_digits;
  
  ?>
<pre class="code-block"><?php
  
  // Explode because PHP crashes when trying to REGEX a large String.
  $lines = explode("\n", $code);
  $isInMultiLineComment = false;
  
  foreach ($lines as $line)
  {
    if ($isInMultiLineComment)
    {
      $index = strpos($line, "*/");
      if ($index !== false)
      {
        $line = substr($line, 0, strlen($line) - 1);
        echo $line . "</span>\n";
        $isInMultiLineComment = false;
        continue;
      }
      else
      {
        echo $line;
        continue;
      }
    }
    
    $suffix = "";
    $index = strpos($line, "/*");
    if ($index !== false) // Is multi-line comment in this line?
    {
      // save the content that is not in a comment to be processed for syntax highlgihts as normal
      $formatMe = substr($line, 0, $index);
      $comment = substr($line, $index);
      $line = $formatMe;
      $suffix = "<span class=\"code-block-comment\">" . $comment;
      $isInMultiLineComment = true;
    }
    
    // single-line comment?
    $index = strpos($line, "//");
    if ($index !== false)
    {
      $formatMe = substr($line, 0, $index);
      $comment = substr($line, $index);
      
      $line = $formatMe;
      $suffix .= "<span class=\"code-block-comment\">" . $comment . "</span>";
    }
    
    // are there quotes?
    $index = strpos($line, "\"");
    $strings = array();
    $i = 0;
    while ($index !== false)
    {
      // Since there may be multiple quotes per line, and there may be
      // highlights after the quote, we have to set aside all of the quoted-strings
      // and substitue strange keywords that are later replaced with the quotes here.
      // this prevents the text in the quote from being highlighted.
      $string = substr($line, $index);
      $endIndex = strpos($string, "\"", 1);
      $restOfLine = substr($string, $endIndex + 1);
      $string = "<span class=\"code-block-string\">" . substr($string, 0, $endIndex + 1) . "</span>";
      $line = substr($line, 0, $index) . "bitzawolfReplace$i" . $restOfLine;
      
      $index = strpos($line, "\"");
      
      $strings["bitzawolfReplace$i"] = $string;
      ++$i;
    }
    
    if ($line != "")
    {
      $replacement = "<span class=\"code-block-keyword\">$0</span>";
      $line = preg_replace($keywords, $replacement, $line);
      
      $replacement = "<span class=\"code-block-command\">$0</span>";
      $line = preg_replace($commands, $replacement, $line);
      
      $replacement = "<span class=\"code-block-digit\">$0</span>";
      $line = preg_replace($REGEX_digits, $replacement, $line);
      
      foreach ($strings as $replaceKeyword => $string)
      {
        $line = str_replace($replaceKeyword, $string, $line);
      }
      
      echo $line;
    }
    
    if ($suffix != "")
    {
      echo $suffix;
    }
  }
  
  
  ?></pre><?php
}

$REGEX_digits = "/\\b\\d+\\.?\\d*/";
$REGEX_strings = "/\\\"[^\\\"]*\\\"/";

$REGEX_java_keywords = "/(abstract|assert|public|static|void|int|byte|case|char|instanceof|interface|new|synchronized|transient|volatile|boolean|float|double|short|long|extends|implements|private|final|class|protected|throws|false|true|null|enum|boolean)\\b/";
$REGEX_java_commands = "/(break|case|catch|continue|default|do|else|finally|for|if|return|super|this|switch|throw|try|while)\\b/";

$REGEX_cpp_keywords = "/(and|alignas|alignof|and_eq|asm|auto|bitand|bitor|bool|char|char16_t|char32_t|class|compl|concept|const|constexpr|const_cast|decltype|delete|double|dynamic_cast|enum|explicit|export|extern|false|float|friend|inline|int|long|mutable|namespace|new|noexcept|not|not_eq|nullptr|operator|or_eq|private|protected|public|register|reinterpret_cast|requires|short|signed|sizeof|static|static_assert|static_cast|struct|template|thread_local|true|typedef|typeid|typename|union|unsigned|using|virtual|void|volatile|wchar_t|xor|xor_eq)\\b/";
$REGEX_cpp_commands = "/(break|case|catch|continue|default|do|else|for|goto|if|return|switch|this|throw|try|while)\\b/";


?>