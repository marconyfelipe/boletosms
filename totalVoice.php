<?php

class TotalVoiceAPI {

    var $accessToken;
    var $debug = false;
    var $assoc = false;
    function TotalVoiceAPI($accessToken, $assoc=false, $debug=false) {
        $this->accessToken = $accessToken;
        $this->assoc = $assoc;
        $this->debug = $debug;
    }
    public function debugOn() {
        $this->debug = true;
    }
    public function debugOff() {
        $this->debug = false;
    }
    public function returnAssoc(){
        $this->assoc = true;
    }
    public function returnObject(){
        $this->assoc = false;
    }
    private function sendRequest($path, $method, $body=null) {
        if ($this->debug) {
            echo "Evoline Request: " . $path . " Method: " . $method . " Body: " . $body . "\n";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.totalvoice.com.br".$path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if($body){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Access-Token: ".$this->accessToken));
        $response_body = curl_exec($ch); 
        if ($this->debug) {
            echo "Evoline Response: " . $response_body . "\n";
        }
        return json_decode($response_body, $this->assoc);
    }
    public function enviaSMS($numero_destino, $mensagem, $resposta_usuario=false) {
        $body = array();
        $body["numero_destino"] = $numero_destino;
        $body["mensagem"] = $mensagem;
        $body["resposta_usuario"] = $resposta_usuario;
        return $this->sendRequest("/sms", "POST", json_encode($body));
    }
}