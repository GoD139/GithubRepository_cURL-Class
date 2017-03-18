<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700" rel="stylesheet">
<style>
       * {
              font-family: 'Open Sans', sans-serif;
       }

       article {
              margin:20px;
              padding:10px;
              border:1px solid rgb(224, 224, 224);
              width:25%;
              height:200px;
              float:left;
       }

       h3 {
              margin-top:0;
       }

       h3 a{
              color:#303030;
              text-decoration:none;
              font-weight:bold;
       }

       h3 a:hover{
              color:#D64541;
              text-decoration:none;
       }
</style>


<?php

include_once('class/curl.class.php');
$GitRep = new cURL("danielmiessler");

/*echo '<pre>';
print_r($GitRep->Fetch(20));
echo '</pre>';*/

foreach($GitRep->Fetch(10) as $Fetch)
{
       echo '<article>';
              echo '<h3><a href="'. $Fetch['Link'] .'" target="_blank">'. $Fetch['Name'] .'</a></h3>';
              echo $Fetch['Desc'];
              echo 'Last updated: '.$Fetch['LastUpdate'];
       echo '</article>';
}
