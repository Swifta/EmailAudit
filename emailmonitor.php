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
        <title></title>
    </head>
    <body style="background: #f3f3f3;">
       <div style="background: #f3f3f3; alignment-adjust: central; margin-left: 250px;margin-right:50px;">
            
        
           <form action="" method="POST" style="margin-left:3px; height:420px;width:450px ;padding:7px;margin-top:1px;margin-right:2px;border: 1px solid #fff;border-radius: 3px; font-family:HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Lucida Grande;font-weight:300;text-align: left;text-decoration: none;">
            <div style="margin-left: 200px;">
                <h2>Email Monitor</h2>
            </div>
                
               <label style="float: left;width: 200px;">Destination Email: </label>
            <input type="text" name="dest"style="float: left; margin-left: 20px;width: 200px;"/>
            <br><br>
            <label style="float: left;width: 200px;">Source Email:</label>
            <input type="text" name="source"style="float: left; margin-left: 20px;width: 200px;"/>
            <br><br>
            <label style="float: left;width: 200px;">End Date:</label>
            <input type="date" name="endDate"style="float: left; margin-left: 20px;"/>
            <br><br>
            <label style="float: left;width: 200px;">Incoming Email Monitor Level:</label>
            <select id="menu" name="incoming" style="float: left; margin-left: 20px;"/>
                <option>HEADER_ONLY</option>
                <option>FULL_MESSAGE</option>
            </select>
            <br><br>
            <label style="float: left;width: 200px;">Outgoing Email Monitor Level:</label>
            <select id="menu" name="outgoing" style="float: left; margin-left: 20px;"/>
                <option>HEADER_ONLY</option>
                <option>FULL_MESSAGE</option>
            </select>
            <br><br>
            <label style="float: left;width: 200px;">Draft Monitor Level:</label>
            <select id="menu" name="draft" style="float: left; margin-left: 20px;"/>
                <option>HEADER_ONLY</option>
                <option>FULL_MESSAGE</option>
            </select>
            <br><br>
            <label style="float: left;width: 200px;">Chat Monitor Level:</label>
            <select id="menu" name="chat" style="float: left; margin-left: 20px;"/>
                <option>HEADER_ONLY</option>
                <option>FULL_MESSAGE</option>
            </select>
            <br><br>
            <input type="submit" name="submit" value="Create Monitor">
        </form>
       </div>
         <br><br>
        <?php
        
            function audit_user(){
                
                    session_start();
                    $access = $_SESSION['access_token'];
                    $refresh = $_SESSION['refresh_token'];

                    if(isset($_REQUEST['submit'])){

                   $dest = $_POST['dest'];
                   $source = $_POST['source'];
                  // $beginDate = $_POST['beginDate'];
                   $endDate = $_POST['endDate'];
                   $incoming = $_POST['incoming'];
                   $outgoing = $_POST['outgoing'];
                   $draft = $_POST['draft'];
                   $chat = $_POST['chat'];

                   $endDate.= " 23:20";
                   //$beginDate.= " 00:00";


                $data2 = "<atom:entry xmlns:atom='http://www.w3.org/2005/Atom' xmlns:apps='http://schemas.google.com/apps/2006'>".
                                                        "<apps:property name='destUserName' value='$dest'/>".
                                                        "<apps:property name='beginDate' value=''/>".
                                                        "<apps:property name='endDate' value='$endDate'/>".
                                                        "<apps:property name='incomingEmailMonitorLevel' value='$incoming'/>".
                                                        "<apps:property name='outgoingEmailMonitorLevel' value='$outgoing'/>".
                                                        "<apps:property name='draftMonitorLevel' value='$draft'/>".
                                                        "<apps:property name='chatMonitorLevel' value='$chat'/>".
                                                     "</atom:entry>";




                        //global $access, ;
                        //$access = "ya29.HAFellyT2fYZ5PYzG_Yevsboy25X7n5pdhleED1Y4gxFZ5DtuLr7cc1ecSsis0EOp6kBaxrxyYPmbw";

                                            $urla = 'https://apps-apis.google.com/a/feeds/compliance/audit/mail/monitor/afrintegra.com/'.$source;
                                            $cha = curl_init($urla);

                                            curl_setopt($cha, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt ( $cha , CURLOPT_VERBOSE , 1 );
                                            curl_setopt ( $cha , CURLOPT_HEADER , 1 );
                                            curl_setopt($cha, CURLOPT_FAILONERROR, false);
                                            curl_setopt($cha, CURLOPT_SSL_VERIFYPEER, false);
                                            curl_setopt($cha, CURLOPT_CUSTOMREQUEST, 'POST');
                                            curl_setopt($cha, CURLOPT_CONNECTTIMEOUT ,0);
                                            curl_setopt($cha, CURLOPT_TIMEOUT, 400);
                                            curl_setopt($cha, CURLOPT_HTTPHEADER, array(
                                                            'Content-type: application/atom+xml',
                                                            'Authorization:Bearer '.$access

                                            ));


                                           curl_setopt($cha, CURLOPT_POSTFIELDS, $data2);

                                              // $readResponse = curl_exec($cha); 
                                               
                                               
                                               
                                               $response = curl_exec($cha);
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
        $xmll = $result['body'];
        
            if($result['http_code']=="201"){
                
                echo "Monitor Created Successfully".'<br>';
                echo "Source Username: $source".'<br>';
                echo "Destination Username: $dest".'<br>';
                //echo "Start Date: $beginDate".'<br>';
                echo "End Date: $endDate".'<br>';
                
                
                 $xml = simplexml_load_string($xmll);
                 if ($xml === false) {
                     echo "Failed loading XML: ";
                     foreach(libxml_get_errors() as $error) {
                         echo "<br>", $error->message;
                     }
                 } else {
                     echo "Request ID: ".$xml->id;
                     
                 }
                 if($xml===""){echo "No XML";}
            }else{
                
                echo "An error occurred";
            }
       // echo  "header: ". $result['header'].'<br>';
       // echo "body: ";
        //echo '<pre>', htmlentities($result['body']), '</pre><br>';
        //echo "header code: ".$result['http_code'].'<br>';
        //echo "last URL: ".$result['last_url'].'<br>';

             
                                               curl_close($cha);
                                               //echo $readResponse;
                        }

                    }                   

                    audit_user();
        ?>
    </body>
</html>
