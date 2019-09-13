<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
if (isset($_POST["submit"]) && !empty($_POST["submit"])) {


    echo "-- begin 1 --";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $MOId = isset($_POST["MOId"]) ? trim($_POST["MOId"]) : "";
    $Telco = isset($_POST["Telco"]) ? trim($_POST["Telco"]) : "";
    $ServiceNum = isset($_POST["ServiceNum"]) ? trim($_POST["ServiceNum"]) : "";
    $Phone = isset($_POST["Phone"]) ? trim($_POST["Phone"]) : "";
    $Syntax = isset($_POST["Syntax"]) ? trim($_POST["Syntax"]) : "";
    $EncryptedMessage = strtolower(base64_decode($Syntax));
    $PrivateKey = '844114065369337123338';
    $signature = base64_encode(sha1($MOId . $ServiceNum . $Phone . $EncryptedMessage . $PrivateKey, true));

    echo "-- begin 2 --";
    echo '<br> $MOId : ' . $MOId;
    echo '<br> $Telco : ' . $Telco;
    echo '<br> $ServiceNum : ' . $ServiceNum;
    echo '<br> $Phone : ' . $Phone;
    echo '<br> $EncryptedMessage : ' . $EncryptedMessage;
    echo '<br> $Syntax : ' . $Syntax;
    echo '<br> $signature : ' . $signature;

    $xml = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <ReceiveResponse xmlns="urn:Partner">
            <MOId>'.$MOId.'</MOId>
            <Telco>'.$Telco.'</Telco>
            <ServiceNum>'.$ServiceNum.'</ServiceNum>
            <Phone>'.$Phone.'</Phone>
            <Syntax>'.$Syntax.'</Syntax>
            <EncryptedMessage>'.$EncryptedMessage.'</EncryptedMessage>
            <Signature>'.$signature.'</Signature>
        </ReceiveResponse>
    </Body>
</Envelope>';

    echo "-- begin 3 --";
    echo "<pre>";
    print_r($xml);
    echo "</pre>";
//The URL that you want to send your XML to.
    $url = 'https://beautyexpo.ngoisao.net/soap/service.php?wsdl';

//Initiate cURL
    $curl = curl_init($url);

//Set the Content-Type to text/xml.
    curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));

//Set CURLOPT_POST to true to send a POST request.
    curl_setopt($curl, CURLOPT_POST, true);

//Attach the XML string to the body of our request.
    curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);

//Tell cURL that we want the response to be returned as
//a string instead of being dumped to the output.
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//Execute the POST request and send our XML.
    $result = curl_exec($curl);

//Do some basic error checking.
    if(curl_errno($curl)){
        throw new Exception(curl_error($curl));
    }

//Close the cURL handle.
    curl_close($curl);

//Print out the response output.
    echo "<br> --- end --- ";
    echo $result;
}



?>

<form name="debug" method="post" action="">
    <div style="padding: 30px">
        MOId
        <input type="text" name="MOId" value="">
    </div>
    <div style="padding: 30px">
        Telco
        <input type="text" name="Telco" value="viettel">
    </div>
    <div style="padding: 30px">
        ServiceNum
        <input type="text" name="ServiceNum" value="8700">
    </div>
    <div style="padding: 30px">
        Phone
        <input type="text" name="Phone" value="0865529878">
    </div>
    <div style="padding: 30px">
        Syntax
        <input type="text" name="Syntax" value="MAKEOVER 78">
    </div>

    <div style="padding: 30px">
        <input type="submit" name="submit" value="TEST">
    </div>
</form>
</body>
</html>