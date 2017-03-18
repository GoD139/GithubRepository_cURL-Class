<?php

include_once('simple_html_dom.php');



class cURL
{
       public $PageData; //Contains the fetched page
       private $Username; //Github username
       private $DataArray = array();
       private $html;

       function cURL( $username )
       {
              $this->Username = $username; //Github username
              $this->PageData = $this->cURLRequest(); //raw github page

              //Call simple_html_dom lib
              $this->html =  new simple_html_dom();
              $this->html =  $this->html->load($this->PageData);
       }

       //cURL method that fetch the requested page
       private function cURLRequest()
       {
       	$ch = curl_init();
              $url = 'https://github.com/'. $this->Username .'?tab=repositories';
       	$timeout = 5; //Timeout time in seconds (use 0 to disable limit *NOT RECOMMENDED*)
       	$agent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36';

       	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
       	curl_setopt($ch,CURLOPT_URL,$url);
       	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
       	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
       	curl_setopt($ch, CURLOPT_VERBOSE, true);
       	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
              //echo 'Curl error: ' . curl_error($ch);
       	$data = curl_exec($ch);
       	curl_close($ch);

       	return $data;
       }


       //array of repos info we want
       private function RepArray()
       {
              $items = $this->html->find('li[class=public]');
              foreach($items as $post) {

                     $Link = new SimpleXMLElement($post->children(0)->first_child()->first_child()->outertext);

                     $RepData[] = array(
                                   "Name" => $post->children(0)->first_child()->first_child()->innertext,
                                   "Link" => 'https://github.com'.$Link['href'],
                                   "Desc" => $post->children(1)->first_child()->innertext,
                                   //"CodeLang" => $post->children(2)->second_child()->outertext,
                                   "LastUpdate" => $post->children(2)->last_child()->outertext);
              }
              return $RepData;
       }


       public function Fetch($MaxDisplayed = 30)
       {
              if($MaxDisplayed < 31) {
                     return array_slice($this->RepArray(), 0, $MaxDisplayed);
              } else {
                     return "Can't fetch more than 30 repositories";
              }
       }



}
