<?php
namespace jpuck\etl\Sources;

use jpuck\etl\Data\Datum;
use jpuck\etl\Schemata\Schema;
use Exception;
use InvalidArgumentException;
use jpuck\phpdev\Exceptions\Unimplemented;

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

		$options = [
			CURLOPT_URL => "{$this->uri['url']}/$endpoint",
			CURLOPT_ENCODING => 'gzip',
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => true,
		];

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

		return new $datumClass($responseData);
	}

	public function insert  (Datum $data) : bool {
		throw new Unimplemented(__METHOD__);
		return false;
	}
	public function replace (Datum $data) : bool {
		throw new Unimplemented(__METHOD__);
		return false;
	}
}
