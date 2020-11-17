<?php
require('env.php');

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
if(isset($_POST['b_affected'])) {
	if($_POST['b_affected'] == 'injured' || $_POST['b_affected'] == 'asset') {
		echo $_POST['b_affected'];
	} else {
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
	}
}

if(isset($_POST['a_info_request'])) {
	// Create connection
	$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$photo_page = AddSlashes($_POST['photo_page']);
	$scheme_page = AddSlashes($_POST['scheme_page']);
	$review_page = AddSlashes($_POST['review_page']);
	// $source_canvas = AddSlashes($_POST['source_canvas']);
	$source_canvas = $_POST['source_canvas'];
	$a_sign_canvas = $_POST['a_sign_canvas'];
	$sql = "INSERT INTO information (what_affected, injured_fullname, injured_phone, damaged_description, asset_owner_phone, a_reg_num, a_owner_phone, a_driver_name, a_driver_id_code, a_owner_name, a_driver_license, a_state_no, a_brand, a_model, a_owner_address, a_owner_email, event_type, a_kind, affected_vehicle, affected_assets, affected_person, b_license, b_phone, event_time, incident_place, event_lat, event_lng, event_description, registered_police, police_detail, a_was_driving, a_tpvca_insurer, a_want_kasko, a_kasko_insurer, photo_page, scheme_page, review_page, source_canvas, a_sign_canvas)
	VALUES ('". $_POST['what_affected'] . "','". $_POST['injured_fullname'] . "','". $_POST['injured_phone'] . "','". $_POST['damaged_description'] . "','". $_POST['asset_owner_phone'] . "','". $_POST['a_reg_num'] . "','" . $_POST['a_owner_phone'] . "','" . $_POST['a_driver_name'] . "','" . $_POST['a_driver_id_code'] . "','" . $_POST['a_owner_name'] . "','" . $_POST['a_driver_license'] . "','" . $_POST['a_state_no'] . "','" . $_POST['a_brand'] . "','" . $_POST['a_model'] . "','" . $_POST['a_owner_address'] . "','" . $_POST['a_owner_email'] . "','" . $_POST['event_type'] . "','" . $_POST['a_kind'] . "','" . $_POST['affected_vehicle'] . "','" . $_POST['affected_assets'] . "','" . $_POST['affected_person'] . "','" . $_POST['b_license'] . "','" . $_POST['b_phone'] . "','" . $_POST['event_time'] . "','" . $_POST['incident_place'] . "','" . $_POST['event_lat'] . "','" . $_POST['event_lng'] . "','" . $_POST['event_description'] . "','" . $_POST['registered_police'] . "','" . $_POST['police_detail'] . "','" . $_POST['a_was_driving'] . "','" . $_POST['a_tpvca_insurer'] . "','" . $_POST['a_want_kasko'] . "','" . $_POST['a_kasko_insurer'] . "','" . $photo_page . "','" . $scheme_page . "','" . $review_page . "','" . $source_canvas . "','" . $a_sign_canvas . "')";
	$res = $conn->query($sql);
	if ($res === TRUE) {
	  echo "save_information_success";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
		// echo $_POST['photo_page'];
		echo "save_information_failed";
	}

	$conn->close();
}

if(isset($_POST['b_request_information'])) {
	$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM information WHERE b_phone = '". $_POST['b_phone']."'";
	$res = $conn->query($sql);
	$result = $res->fetch_assoc();
	echo json_encode($result);
}

?>