<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://ssl.gstatic.com/docs/script/css/add-ons.css">
        <title>request status</title>
    </head>
    <body style="background: #f3f3f3;">
        
        <div style="background: #f3f3f3; alignment-adjust: central; margin-left: 150px;margin-right:50px;">
           
        
            <form action="" method="POST" style="margin-left:3px; height:200px;width:800px ;padding:4px;margin-top:1px;margin-right:2px;border: 1px solid #fff;border-radius: 3px; font-family:HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Lucida Grande;font-weight:300;text-align: left;text-decoration: none;">
            
                 <div style="margin-left: 120px;">
                <h2>Request Mail Export Status</h2>
            </div>
                
                <label style="float: left;width: 100px;">Request URI:</label>
            <input type="text" name="request" style="float: left; margin-left: 20px;width: 680px;"/>
            <br><br>
           
            <input type="submit" name="submit" value="Submit Request">
        </form>
       </div>
         <br><br>
        
        <?php
        
      
        define('URI_RSS', 'http://schemas.google.com/apps/2006');
            
        function audit_user(){
                session_start();
                $access = $_SESSION['access_token'];
                $refresh = $_SESSION['refresh_token'];

                if(isset($_REQUEST['submit'])){


               $requestID = $_POST['request'];
               $requestID.="?alt=json";
               

                                        $urla = $requestID;
                                        $cha = curl_init($urla);

                                        curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt ( $cha , CURLOPT_VERBOSE , 1 );
                                        curl_setopt ( $cha , CURLOPT_HEADER , 1 );
                                        curl_setopt($cha, CURLOPT_FAILONERROR, false);
                                        curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'GET');
                                        curl_setopt($cha, CURLOPT_CONNECTTIMEOUT ,0);
                                        curl_setopt($cha, CURLOPT_TIMEOUT, 400);
                                        curl_setopt($cha, CURLOPT_HTTPHEADER, array(
                                                      //  'Content-type: application/atom+xml',
                                                        'Authorization:Bearer '.$access

                                        ));


                                           $response = curl_exec($cha);
                                           $retf= json_decode($response, true);
                                           //echo $response;
                                           
                    $error = curl_error($cha);
                    $result = array( 'header' => '', 
                                     'body' => '', 
                                     'curl_error' => '', 
                                     'http_code' => '',
                                     'last_url' => '');


                    if ( $error != "" )
                    {
                        $result['curl_error'] = $error;
                        echo $result['curl_error'];
                    }

                    $header_size = curl_getinfo($cha,CURLINFO_HEADER_SIZE);
                    $result['header'] = substr($response, 0, $header_size);
                    $result['body'] = substr( $response, $header_size );
                    $result['http_code'] = curl_getinfo($cha,CURLINFO_HTTP_CODE);
                    $result['last_url'] = curl_getinfo($cha,CURLINFO_EFFECTIVE_URL);
                    $xmll = json_decode($result['body'], true);
                    
                    if($result['http_code']=="200"){
                       $val =  count($xmll['entry']['apps$property']);
                       for($i=0;$i<$val;$i++){
                           
                          echo $xmll['entry']['apps$property'][$i]['name']." = ".$xmll['entry']['apps$property'][$i]['value'].'<br>';
                           
                            
                       }
                      
                    }else{
                        
                        echo $result['header'];
                    }  

                   // if($result['http_code']=="200"){

                           // echo "Request Created Successfully".'<br>';
                            //echo "Source Username: $source".'<br>';
                           // echo "Destination Username: $dest".'<br>';
                            //echo "Start Date: $beginDate".'<br>';
                            //echo "End Date: $endDate".'<br>';
                            //echo "Include Deleted Mails: $include".'<br>';
                            // "Content: $content".'<br>';
           

                             /*$xml = simplexml_load_string($data3);
                             if ($xml === false) {
                                 echo "Failed loading XML: ";
                                 foreach(libxml_get_errors() as $error) {
                                     echo "<br>", $error->message;
                                 }
                             } else {
                                 
                                 foreach ($xml->children() as $name=>$c) {
                                    $attributes = $xml->children('apps', TRUE)->attributes(URI_RSS); 
                                    //echo $element."\n";
                                    //print_r($element) . "\n";
                                      echo $name, '=', $attributes['value'], "\n";
                                 }
                                    
                                 //echo $xml->apps:property;

                             }*/
                           //  if($xml===""){echo "No XML";}
                       // }else{

                       //     echo "An error occurred";
                       // }


                    
                     curl_close($cha);

                    }

                }                   

                audit_user();        
        
        
        ?>
    </body>
</html>
