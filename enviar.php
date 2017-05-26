<?php

include_once "pagarme.php";
include_once "totalVoice.php";

$transacao = new PagarMe("SUA_KEY_TOTAL_PAGAR_ME", "NUMERO_PEDIDO_META_DATA");
$codigoBoleto = $transacao->obtemCodigoBoleto();

$api = new TotalVoiceAPI("SUA_KEY_TOTAL_VOICE");
$api->enviaSMS("TELEFONE_DESTINO", "MENSAGEM");

?>