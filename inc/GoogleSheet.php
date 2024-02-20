<?php

namespace Inc;

class GoogleSheet {
	public $page;
	public $google_sheet_id;
	public $service;
	public $valueInputOption = 'RAW';

	public function __construct( $google_sheet_id, $page ,$header ) {
		$client = new \Google\Client();
		$client->setScopes( array( \Google\Service\Sheets::SPREADSHEETS ) );
		$client->setAccessType( 'offline' );
		$client->setAuthConfig( __DIR__ . '/creds.json' );
		$guzzleClient = new \GuzzleHttp\Client( array( 'verify' => false ) );
		$client->setHttpClient( $guzzleClient );
		$this->page            = $page;
		$this->google_sheet_id = $google_sheet_id;
		$this->service         = new \Google\Service\Sheets( $client );

		// Always insert header.
		$this->update( '!A1:Z1', $header );
	}


	public function append( $values ) {
		try {
			$body   = new \Google\Service\Sheets\ValueRange(
				array(
					'values' => array( $values ),
				)
			);
			$params = array(
				'valueInputOption' => $this->valueInputOption,
			);
			$result = $this->service->spreadsheets_values->append( $this->google_sheet_id, $this->page, $body, $params );
			// $result->getUpdates()->getUpdatedCells();
			return $result;
		} catch ( Exception $e ) {
			echo 'Message: ' . $e->getMessage();
		}
	}


	public function update( $ranges = '', $values ) {
		try {

			$ranges = $this->page . $ranges;
			$values = array( $values );

			$body   = new \Google\Service\Sheets\ValueRange(
				array(
					'values' => $values,
				)
			);
			$params = array(
				'valueInputOption' => $this->valueInputOption,
			);
			// executing the request
			$result = $this->service->spreadsheets_values->update(
				$this->google_sheet_id,
				$ranges,
				$body,
				$params
			);

			return $result;
		} catch ( Exception $e ) {
				// TODO(developer) - handle error appropriately
				echo 'Message: ' . $e->getMessage();
		}
	}
}
