<?php


  /**
   * Output the page not found
   *
   */
  function menuPageNotFound(){
    global $allCategories;  // gives access to $allCategories to prevent variable not found error
   
    echo "Page not found";
  
    die();
  }


  /**
   * validate if array value exists and is empty
   *
   * @param  [array] $array
   * @param  [string] $key
   * @return boolean
   */
  function validateIsEmptyData($array, $key){
    // if (!array_key_exists('txtTitle', $_POST) || $_POST['txtTitle'] ==""  ){
    if(!array_key_exists($key, $array) || $array[$key] == ""){
       return true;
      // error should occur add to error message
      }else {
        return false;
      }
    }

    

?>