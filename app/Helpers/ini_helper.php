<?php
function nav_oto(string $a, string $b):string
{
  if($a == $b){
    return "active";
  } else {
    return "";
  }
}