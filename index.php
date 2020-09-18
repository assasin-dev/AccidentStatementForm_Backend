<?php

function hashs(){
	$priKeyId = openssl_get_privatekey(file_get_contents('privkey.pem'));
	$hash = md5('eaccident@edrauda.lt'.'#'.'UbcHjH8HxNekaEys'. '#'. gmdate('Y-m-d H:i'));
	if ($priKeyId !== false) {
		if (openssl_sign($hash, $signature, $priKeyId) === true) {
			openssl_free_key($priKeyId);
			if (($signature = base64_encode($signature)) !== false) {

				return preg_replace("/[\r\n\t]*/", "", $signature);
			} else {
				throw new Exception('Failed to base64 encode signed hash.');
			}
		} else {
			openssl_free_key($priKeyId);
			throw new Exception('Failed to sign hash.');
		}
	} else {
		throw new Exception('Can not get private key.');
	}
}
// echo hashs();
$hash = hashs();
// var_dump($_REQUEST);
// echo $_POST['ask_hash'];
if(isset($_POST['ask_hash'])) {
// 	echo "start";
	$reg_num = $_POST['reg_num'];
	$owner_code = $_POST['owner_code'];

	//The XML string that you want to send.
	$xml = "<Request><Login>
	        <LoginName>eaccident@edrauda.lt</LoginName>
	        <Password>UbcHjH8HxNekaEys</Password>
	        <Hash>" . $hash . "</Hash></Login>
	        <GetVehicleMinimizedData>
	        <Source>any</Source>
	        <AutoNumber>" . $reg_num . "</AutoNumber>
	        <OwnerCode>" . $owner_code . "</OwnerCode>
	        </GetVehicleMinimizedData></Request>";
	 
	 
	//The URL that you want to send your XML to.
	$url = 'https://www.drauskaita.lt/services/getVehicleMinimizedData';
	 
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
	 $oXML = new SimpleXMLElement($result);
	//Print out the response output.
	// var_dump($oXML);
	// foreach($oXML->GetVehicleMinimizedData as $oEntry){
	//     echo $oEntry->OwnerName . "\n";
	// }
	 echo json_encode($oXML->GetVehicleMinimizedData);
	// echo $oXML;
}
?>