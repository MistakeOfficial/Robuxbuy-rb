<?php

/**
* TrueWallet Class
 *
 * @category  Payment Gateway
 * @package   php-truewallet-class
 * @author    Likecyber <cyber2friends@gmail.com>
 * @copyright Copyright (c) 2018-2019
 * @license   https://creativecommons.org/licenses/by/4.0/ Attribution 4.0 International (CC BY 4.0)
 * @link      https://github.com/likecyber/php-truewallet-class
 * @version   1.2.1
**/

class TrueWallet {
	public $credentials = array();
	public $access_token = null;
	public $reference_token = null;

	public $curl_options = null;

	public $data = null;

	public $response = null;
	public $http_code = null;

	public $mobile_api_gateway = "https://mobile-api-gateway.truemoney.com/mobile-api-gateway/";
	public $secret_key = "9LXAVCxcITaABNK48pAVgc4muuTNJ4enIKS5YzKyGZ";

	public $device_id = ""; // Set device_id here
	public $mobile_tracking = ""; // Set mobile_tracking here

	public function generate_identity () {
		$this->mobile_tracking = base64_encode(openssl_random_pseudo_bytes(40));
		$this->device_id = substr(md5($this->mobile_tracking), 16);
		return implode("|", array($this->device_id, $this->mobile_tracking));
	}

	public function __construct ($username = null, $password = null, $reference_token = null) {
		if (empty($this->device_id) || empty($this->mobile_tracking)) {
			$identity_file = dirname(__FILE__)."/".basename(__FILE__, ".php").".identity";
			if (file_exists($identity_file)) {
				list($this->device_id, $this->mobile_tracking) = explode("|", file_get_contents($identity_file));
			} else {
				file_put_contents($identity_file, $this->generate_identity());
			}
		}
		if (!is_null($username) && !is_null($password)) {
			$this->setCredentials($username, $password, $reference_token);
		} elseif (!is_null($username)) {
			$this->setAccessToken($username);
		}
	}

	public function setCredentials ($username, $password, $reference_token = null, $type = null) {
		if (is_null($type)) $type = filter_var($username, FILTER_VALIDATE_EMAIL) ? "email" : "mobile";
		$this->credentials["username"] = strval($username);
		$this->credentials["password"] = strval($password);
		$this->credentials["type"] = strval($type);
		$this->setAccessToken(null);
		$this->setReferenceToken($reference_token);
	}

	public function setAccessToken ($access_token) {
		$this->access_token = is_null($access_token) ? null : strval($access_token);
	}

	public function setReferenceToken ($reference_token) {
		$this->reference_token = is_null($reference_token) ? null : strval($reference_token);
	}

	public function request ($api_path, $headers = array(), $data = null) {
		$this->data = null;
		$handle = curl_init($this->mobile_api_gateway.ltrim($api_path, "/"));
		if (!is_null($data)) {
			curl_setopt_array($handle, array(
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => is_array($data) ? json_encode($data) : $data
			));
			if (is_array($data)) $headers = array_merge(array("Content-Type" => "application/json"), $headers);
		}
		curl_setopt_array($handle, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "okhttp/3.8.0",
			CURLOPT_HTTPHEADER => $this->buildHeaders($headers)
		));
		if (is_array($this->curl_options)) curl_setopt_array($handle, $this->curl_options);
		$this->response = curl_exec($handle);
		$this->http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		if ($result = json_decode($this->response, true)) {
			if (isset($result["data"])) $this->data = $result["data"];
			return $result;
		}
		return $this->response;
	}

	public function buildHeaders ($array) {
		$headers = array();
		foreach ($array as $key => $value) {
			$headers[] = $key.": ".$value;
		}
		return $headers;
	}

	public function getTimestamp() {
		return strval(floor(microtime(true)*1000));
	}

	public function RequestLoginOTP () {
		if (!isset($this->credentials["username"]) || !isset($this->credentials["password"]) || !isset($this->credentials["type"])) return false;
		$timestamp = $this->getTimestamp();
		$result = $this->request("/api/v1/login/otp/", array(
			"username" => $this->credentials["username"],
			"password" => sha1($this->credentials["username"].$this->credentials["password"])
		), array(
			"type" => $this->credentials["type"],
			"device_id" => $this->device_id,
			"timestamp" => $timestamp,
			"signature" => hash_hmac("sha1", implode("|", array($this->credentials["type"], $this->device_id, $timestamp)), $this->secret_key)
		));
		return $result;
	}

	public function SubmitLoginOTP ($otp_code, $mobile_number = null, $otp_reference = null) {
		if (is_null($mobile_number) && isset($this->data["mobile_number"])) $mobile_number = $this->data["mobile_number"];
		if (is_null($otp_reference) && isset($this->data["otp_reference"])) $otp_reference = $this->data["otp_reference"];
		if (is_null($mobile_number) || is_null($otp_reference)) return false;
		$timestamp = $this->getTimestamp();
		$result = $this->request("/api/v1/login/otp/verification/", array(
			"username" => $this->credentials["username"],
			"password" => sha1($this->credentials["username"].$this->credentials["password"])
		), array(
			"type" => $this->credentials["type"],
			"otp_code" => strval($otp_code),
			"mobile_number" => strval($mobile_number),
			"otp_reference" => strval($otp_reference),
			"device_id" => $this->device_id,
			"mobile_tracking" => $this->mobile_tracking,
			"timestamp" => $timestamp,
			"signature" => hash_hmac("sha1", implode("|", array($this->credentials["type"], strval($otp_code), strval($mobile_number), strval($otp_reference), $this->device_id, $this->mobile_tracking, $timestamp)), $this->secret_key)
		));
		if (isset($result["data"]["access_token"])) $this->setAccessToken($result["data"]["access_token"]);
		if (isset($result["data"]["reference_token"])) $this->setReferenceToken($result["data"]["reference_token"]);
		return $result;
	}

	public function Login () {
		if (!isset($this->credentials["username"]) || !isset($this->credentials["password"]) || !isset($this->credentials["type"]) || is_null($this->reference_token)) return false;
		$timestamp = $this->getTimestamp();
		$result = $this->request("/api/v1/login/", array(
			"username" => $this->credentials["username"],
			"password" => sha1($this->credentials["username"].$this->credentials["password"])
		), array(
			"type" => $this->credentials["type"],
			"reference_token" => $this->reference_token,
			"device_id" => $this->device_id,
			"mobile_tracking" => $this->mobile_tracking,
			"timestamp" => $timestamp,
			"signature" => hash_hmac("sha1", implode("|", array($this->credentials["type"], $this->reference_token, $this->device_id, $this->mobile_tracking, $timestamp)), $this->secret_key)
		));
		if (isset($result["data"]["access_token"])) $this->setAccessToken($result["data"]["access_token"]);
		return $result;
	}

	public function Logout () {
		if (is_null($this->access_token)) return false;
		return $this->request("/api/v1/signout/".$this->access_token, array(), "");
	}

	public function GetProfile () {
		if (is_null($this->access_token)) return false;
		return $this->request("/api/v1/profile/".$this->access_token);
	}

	public function GetBalance () {
		if (is_null($this->access_token)) return false;
		return $this->request("/api/v1/profile/balance/".$this->access_token);
	}

	public function GetTransaction ($limit = 50, $start_date = null, $end_date = null) {
		if (is_null($this->access_token)) return false;
		if (is_null($start_date) && is_null($end_date)) $start_date = date("Y-m-d", strtotime("-30 days") - date("Z") + 25200);
		if (is_null($end_date)) $end_date = date("Y-m-d", strtotime("+1 day") - date("Z") + 25200);
		if (is_null($start_date) || is_null($end_date)) return false;
		return $this->request("/user-profile-composite/v1/users/transactions/history?start_date=".strval($start_date)."&end_date=".strval($end_date)."&limit=".intval($limit), array(
			"Authorization" => $this->access_token
		));
	}

	public function GetTransactionReport ($report_id) {
		if (is_null($this->access_token)) return false;
		return $this->request("/user-profile-composite/v1/users/transactions/history/detail/".intval($report_id), array(
			"Authorization" => $this->access_token
		));
	}

	public function TopupCashcard ($cashcard) {
		if (is_null($this->access_token)) return false;
		return $this->request("/api/v1/topup/mobile/".time()."/".$this->access_token."/cashcard/".strval($cashcard), array(), "");
	}

	public function DraftTransferP2P ($mobile_number, $amount) {
		if (is_null($this->access_token)) return false;
		$timestamp = $this->getTimestamp();
		return $this->request("/api/v1/transfer/draft-transaction/", array(
			"Authorization" => $this->access_token
		), array(
			"amount" => number_format(str_replace(",", "", strval($amount)), 2, ".", ""),
			"mobileNumber" => str_replace(array("-", " "), "", strval($mobile_number)),
			"timestamp" => $timestamp,
			"signature" => hash_hmac("sha1", implode("|", array(number_format(str_replace(",", "", strval($amount)), 2, ".", ""), str_replace(array("-", " "), "", strval($mobile_number)), $timestamp)), $this->secret_key)
		));
	}

	public function ConfirmTransferP2P ($personal_message = "", $draft_transaction_id = null, $reference_key = null) {
		if (is_null($this->access_token)) return false;
		if (is_null($draft_transaction_id) && isset($this->data["draftTransactionID"])) $draft_transaction_id = $this->data["draftTransactionID"];
		if (is_null($reference_key) && isset($this->data["referenceKey"])) $reference_key = $this->data["referenceKey"];
		if (is_null($draft_transaction_id) || is_null($reference_key)) return false;
		$timestamp = $this->getTimestamp();
		return $this->request("/api/v1/transfer/transaction/".$draft_transaction_id, array(
			"Authorization" => $this->access_token
		), array(
			"personalMessage" => strval($personal_message),
			"referenceKey" => strval($reference_key),
			"timestamp" => $timestamp,
			"signature" => hash_hmac("sha1", implode("|", array(strval($personal_message), strval($reference_key), $timestamp)), $this->secret_key)
		));
	}
}

?>
