<?php
namespace jpuck\etl\Sources;

use jpuck\etl\Data\Datum;
use jpuck\etl\Schemata\Schema;
use Exception;
use InvalidArgumentException;

class REST extends Source {
	/**
	 * @throws InvalidArgumentException
	 */
	protected function validateURI($uri) : Bool {
		if (empty($uri['url'])){
			// TODO: validate URL
			// http://stackoverflow.com/q/206059/4233593
			throw new InvalidArgumentException(
				'base url required.'
			);
		}
		return true;
	}

	/**
	 * @throws Exception
	 */
	public function fetch(String $endpoint, String $datumClass, Schema $schema = null) : Datum {
		$curl = curl_init();

		// don't care about trailing slash or not
		$url = trim($this->uri['url'], '/');
		$endpoint = trim($endpoint, '/');

		$options = [
			CURLOPT_URL => "$url/$endpoint",
			CURLOPT_ENCODING => 'gzip',
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => true,
		];

		$headers = $this->uri['headers'] ?? null;
		if(is_array($headers)){
			foreach($headers as $header => $value){
				$options[CURLOPT_HTTPHEADER] []= "$header: $value";
			}
		}

		if (isset($this->uri['username']) && isset($this->uri['password'])){
			$options[CURLOPT_USERPWD] =
				"{$this->uri['username']}:{$this->uri['password']}";
		}

		curl_setopt_array($curl, $options);

		$responseData = curl_exec($curl);

		if (curl_errno($curl)){
			throw new Exception(curl_error($curl));
		} else {
			// TODO: Handle HTTP status code and response data
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		}

		curl_close($curl);

		return new $datumClass($responseData, $schema);
	}
}
