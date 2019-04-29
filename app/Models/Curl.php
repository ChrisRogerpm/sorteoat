<?php

namespace App\Models;

class Curl
{
	protected $endpoint;
	protected $api_key;
	protected $token;
	protected $headers = [];

	public function __construct($password){
		$this->endpoint = "https://api.apuestatotal.com";
		$this->api_key = "H4ofnr4pg02Vgd39lnLaa30kFGdKNqjp";
		$this->token = $this->api_key.":".$password;
		$this->headers[] = 'Content-Type:application/json';
		$this->headers[] = "Accept-Language: en-US,en;q=0.9,es;q=0.8,pt;q=0.7,gl;q=0.6";
		$this->headers[] = "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36";
	}

	public function post($data, $uri=""){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'canhazip.com');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);

		$ch = curl_init($this->endpoint.$uri);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->token);

		$response =  json_decode(curl_exec($ch), true);

		curl_close($ch);

		return $response;
	}
	public function consultarLocal($unitId){		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.apuestatotal.com/v2/locales/'.$unitId);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$headers = array();
		$headers[] = 'Accept: application/json';
		//$headers[] = 'Authorization: Bearer '.$accessToken;
		$headers[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjAyN2VjMWMwY2Q3MTllODQxNzE2N2M0ZjhmZDRlNTRlMzY1MTZmMjVkYjU4ZDQyYjU4ZWYzYjc0MTRjNDQ5MjE4OGE4ZDJiZmZlMGI5ZTJkIn0.eyJhdWQiOiIxIiwianRpIjoiMDI3ZWMxYzBjZDcxOWU4NDE3MTY3YzRmOGZkNGU1NGUzNjUxNmYyNWRiNThkNDJiNThlZjNiNzQxNGM0NDkyMTg4YThkMmJmZmUwYjllMmQiLCJpYXQiOjE1NDkwNTkzNDQsIm5iZiI6MTU0OTA1OTM0NCwiZXhwIjoxNTgwNTk1MzQ0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.b02lJppH1QZyMYSN5O--xJPOzdOaF6WHpojcfxgolZID7-hAXDTu67Z09bqgXZC1oIuoOgq9yYTZjTcsbKWiF1xmNq5kL20jqjh7ZxfqcvfyI1Ol8dGOcf8aQFP41iUPM44AkxkLoMZ2ebx3h0XWKxzk-lHcqayrGBKuH6dM67UoQmbhks4EevkGEY7xkqjcD9AttcpwXeBfZLc8FPAF6z_HLQfI9j9On1KBr4mRoaqGfU4Zb0gF_sMeG2KdlszCfmU8HmkYOM7Wzg63AxHu-v7MdtVN0G1n3Ho4BJ5UdCgtQx28u9PJ4sfd74DVhFSt_NI2cMN03s_iZbk2LEcuO4RRFe_jrqeyqLVgAS9WgWeYNGN0W98k3pX6hxiJ9jB3qBfiTkL_KwS2O5d-O3mPf85R3KH37JH8yFF7nS9CXEQUI1xcfGHpt8ARdauojZf6KuIhwMh0r0-d6dX9pGGcOnUlmxaMM4piYRVsuEnp3fHWue_kadTDLLQ5sWCFmLwaWRMH6GcT_Je1PLkpjPvWVJYbCR28cmsw7magRdEtPNY1g0RCm7oTb7LjsJXLgw-OAiWUEQdmiWDaB8baFc9G1RzcrOldRZlsbRem_H_LYBwZxIat-aCs00gpDFd8ra4E3nIl_SXm3Nvq9ZaNaEiJB9vBnECihgqXryNE_Q2HV98';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		$response =  json_decode(curl_exec($ch), true);
		curl_close ($ch);
		return $response;
	}
	public function ListarLocalJson(){	
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.apuestatotal.com/v2/locales",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjAyN2VjMWMwY2Q3MTllODQxNzE2N2M0ZjhmZDRlNTRlMzY1MTZmMjVkYjU4ZDQyYjU4ZWYzYjc0MTRjNDQ5MjE4OGE4ZDJiZmZlMGI5ZTJkIn0.eyJhdWQiOiIxIiwianRpIjoiMDI3ZWMxYzBjZDcxOWU4NDE3MTY3YzRmOGZkNGU1NGUzNjUxNmYyNWRiNThkNDJiNThlZjNiNzQxNGM0NDkyMTg4YThkMmJmZmUwYjllMmQiLCJpYXQiOjE1NDkwNTkzNDQsIm5iZiI6MTU0OTA1OTM0NCwiZXhwIjoxNTgwNTk1MzQ0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.b02lJppH1QZyMYSN5O--xJPOzdOaF6WHpojcfxgolZID7-hAXDTu67Z09bqgXZC1oIuoOgq9yYTZjTcsbKWiF1xmNq5kL20jqjh7ZxfqcvfyI1Ol8dGOcf8aQFP41iUPM44AkxkLoMZ2ebx3h0XWKxzk-lHcqayrGBKuH6dM67UoQmbhks4EevkGEY7xkqjcD9AttcpwXeBfZLc8FPAF6z_HLQfI9j9On1KBr4mRoaqGfU4Zb0gF_sMeG2KdlszCfmU8HmkYOM7Wzg63AxHu-v7MdtVN0G1n3Ho4BJ5UdCgtQx28u9PJ4sfd74DVhFSt_NI2cMN03s_iZbk2LEcuO4RRFe_jrqeyqLVgAS9WgWeYNGN0W98k3pX6hxiJ9jB3qBfiTkL_KwS2O5d-O3mPf85R3KH37JH8yFF7nS9CXEQUI1xcfGHpt8ARdauojZf6KuIhwMh0r0-d6dX9pGGcOnUlmxaMM4piYRVsuEnp3fHWue_kadTDLLQ5sWCFmLwaWRMH6GcT_Je1PLkpjPvWVJYbCR28cmsw7magRdEtPNY1g0RCm7oTb7LjsJXLgw-OAiWUEQdmiWDaB8baFc9G1RzcrOldRZlsbRem_H_LYBwZxIat-aCs00gpDFd8ra4E3nIl_SXm3Nvq9ZaNaEiJB9vBnECihgqXryNE_Q2HV98"
			),
		));
		$response = curl_exec($curl);
		$response =  json_decode(curl_exec($curl), true);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			//echo $response;
		}
		return $response['result'];			
	}

	public function LoginLocal($cc_id,$password){		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.apuestatotal.com/v2/locales",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => "cc_id=".$cc_id."&password=".$password,
			CURLOPT_ENCODING => "",
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
		
			CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjAyN2VjMWMwY2Q3MTllODQxNzE2N2M0ZjhmZDRlNTRlMzY1MTZmMjVkYjU4ZDQyYjU4ZWYzYjc0MTRjNDQ5MjE4OGE4ZDJiZmZlMGI5ZTJkIn0.eyJhdWQiOiIxIiwianRpIjoiMDI3ZWMxYzBjZDcxOWU4NDE3MTY3YzRmOGZkNGU1NGUzNjUxNmYyNWRiNThkNDJiNThlZjNiNzQxNGM0NDkyMTg4YThkMmJmZmUwYjllMmQiLCJpYXQiOjE1NDkwNTkzNDQsIm5iZiI6MTU0OTA1OTM0NCwiZXhwIjoxNTgwNTk1MzQ0LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.b02lJppH1QZyMYSN5O--xJPOzdOaF6WHpojcfxgolZID7-hAXDTu67Z09bqgXZC1oIuoOgq9yYTZjTcsbKWiF1xmNq5kL20jqjh7ZxfqcvfyI1Ol8dGOcf8aQFP41iUPM44AkxkLoMZ2ebx3h0XWKxzk-lHcqayrGBKuH6dM67UoQmbhks4EevkGEY7xkqjcD9AttcpwXeBfZLc8FPAF6z_HLQfI9j9On1KBr4mRoaqGfU4Zb0gF_sMeG2KdlszCfmU8HmkYOM7Wzg63AxHu-v7MdtVN0G1n3Ho4BJ5UdCgtQx28u9PJ4sfd74DVhFSt_NI2cMN03s_iZbk2LEcuO4RRFe_jrqeyqLVgAS9WgWeYNGN0W98k3pX6hxiJ9jB3qBfiTkL_KwS2O5d-O3mPf85R3KH37JH8yFF7nS9CXEQUI1xcfGHpt8ARdauojZf6KuIhwMh0r0-d6dX9pGGcOnUlmxaMM4piYRVsuEnp3fHWue_kadTDLLQ5sWCFmLwaWRMH6GcT_Je1PLkpjPvWVJYbCR28cmsw7magRdEtPNY1g0RCm7oTb7LjsJXLgw-OAiWUEQdmiWDaB8baFc9G1RzcrOldRZlsbRem_H_LYBwZxIat-aCs00gpDFd8ra4E3nIl_SXm3Nvq9ZaNaEiJB9vBnECihgqXryNE_Q2HV98"
			),
		));
		//$response = curl_exec($curl);
		$response =  json_decode(curl_exec($curl), true);
		$err = curl_error($curl);
		curl_close($curl);		
		return $response;
	}

}

?>