<?php
/**
 *
 */
class Notification{

  static public function showNotification($message, $title, $type, $delay){
    if(!isset($_SESSION["notifications"])){
      $_SESSION["notifications"] = "";
    }
    $_SESSION["notifications"] = $_SESSION["notifications"]."<script>
      $(document).ready(function(){
        $.notiny({ text: '$message', theme: '$type', position: 'right-top',
                   title: '$title', delay: $delay});
      });
    </script>";
  }
}
