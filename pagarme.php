<?php 

class PagarMe {

	function PagarMe($accessToken, $numPedido) {
        $this->accessToken = $accessToken;
        $this->numPedido = $numPedido;
	}

	function obtemCodigoBoleto () {

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.pagar.me/1/transactions");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "api_key=$this->accessToken&metadata[order_number]=$this->numPedido");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$headers = array();
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		$result = json_decode($result, true);
		curl_close($ch);

		return $result[0]['boleto_barcode'];
	}

}