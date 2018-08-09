<?php

namespace SdkBonusApi;

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
//use RabbitWrapper\WorkerSender;

require_once 'WorkerSender.php';

class SdkBonusApi
{

    public $array_setting; 

    public function __construct() 
    {

      require_once 'array_setting.php'; //array_setting - general setting(server, key, pwd) + number api-items
      $this->array_setting =  $array_setting;

    }

    public function requestApi($array_from_platform) //numberapi + postparamstring
    {

       //!!!guzzle... 
       $array_params = explode('/', $array_from_platform['postparamstring']);
       for($i = 0; $i < count($array_params); ++$i ) {$array_postparams[strstr($array_params[$i], '=', true)] = substr($array_params[$i], strpos($array_params[$i], '=')+1);}
       $array_postparams['Hash'] = hash('md5', $array_from_platform['postparamstring'] . $this->array_setting['pwd']); 
  
       $client = new Client();

       $response = $client->request('POST', $this->array_setting['server'].$this->array_setting['key'], [ //SERVER+KEY ...when real +PATH (.$this->array_setting[$array_from_platform['numberapi']]['addurl'])
           'form_params' => [

             //...for DEMO, when - delete...
             'addurl' => $this->array_setting[$array_from_platform['numberapi']]['addurl'], //...PATH -> URL...
             //...for DEMO, when - delete...

             'parameters' => $array_postparams,    
             
           ]
       ]);
       echo $response->getStatusCode() . ' - ' . $response->getBody()->getContents();
       //!!!guzzle... 

       //!!!rabbit - send... 
       $sender =  new WorkerSender();
       $sender->execute('Hello world...'); 
       //!!!rabbit - send... 
          
    }

}


