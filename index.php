<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
        <link rel="stylesheet" href="https://ssl.gstatic.com/docs/script/css/add-ons.css">
<title>Email Audit</title>



</head>

<body style="background: #f3f3f3;">
    <div>
            
        
        <p><h1>Google Apps Email Audit Application</h1>    </p></br>
        <p>This application can only be used by Google Apps Administrator. </p>
        </br>
    </br>
       <?php
       
       
                                                session_start();
                                                         

if(isset($_GET['code'])){


$code =  $_GET['code'];

}
else{
//authorization                         
                        $data2= "https://accounts.google.com/o/oauth2/auth?"; 

                        $data2 .="response_type=code&";
                        $data2 .="redirect_uri=" . urlencode("http://localhost/aud/index.php") ."&";

                        $data2 .="client_id=675674032822-4dfcfe2ecmvpu50t5q6f0ajqgkdkck52.apps.googleusercontent.com" ."&";

                        $data2 .="scope=" . urlencode("https://apps-apis.google.com/a/feeds/compliance/audit/") ."&"; #orgunit user
                    

                        $data2 .="approval_prompt=force&";
                        $data2 .="state=kay&";
                        $data2 .="access_type=offline&"; 

                        $data2 .="include_granted_scopes=true"; #true
                        $datea = $data2;
                        
                        header("Location: $datea");

}


$url = 'https://accounts.google.com/o/oauth2/token';
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($ch, CURLOPT_FAILONERROR, false);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded'
));

curl_setopt($ch, CURLOPT_POSTFIELDS,
    'code=' . urlencode($code) . '&' .
    'client_id=' . urlencode('675674032822-4dfcfe2ecmvpu50t5q6f0ajqgkdkck52.apps.googleusercontent.com') . '&' .
    'client_secret=' . urlencode('P8oWu5g29JCae4kLwr2ofM0f') . '&' .
    'redirect_uri=' . urlencode('http://localhost/aud/index.php') . '&' .
    'grant_type=authorization_code'
);


// Send the request & save response to $resp
$resp = curl_exec($ch);

        //$_SESSION['access_token'] ;
	//$_SESSION['refresh_token'] ;


$json = json_decode($resp, true);

if(!isset($json['access_token'])){
    $access_token = $_SESSION['access_token'];
    $refresh_token = $_SESSION['refresh_token'];
}else{
    $access_token = $json['access_token'];
    $refresh_token = $json['refresh_token'];
}
// Close request to clear up some resources
curl_close($ch);


if (isset($access_token)){

	//session_start();
	
	$_SESSION['access_token'] = $access_token;
	$_SESSION['refresh_token'] = $refresh_token;

echo "Access token generated";
}else{echo "Access NOT granted";}

?> 
    </br>
    </br>
        

            
        

    <h2> <p><a href="emailmonitor.php"> -Create Email Monitor </a></p></h2>
    <h2> <p><a href="maildump.php"> -Create Mail Dump Request</a></p></h2>
    <h2> <p><a href="requeststatus.php"> -Get Mail Dump Request Status</a></p></h2>
    
   </div>
   
</body>
</html>