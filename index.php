<?php
header('Content-Type: text/html; charset=utf-8');
include("classe.php");

if(isset($_GET["v"])):
    $valor = $_GET["v"];
else:
    $valor = "ITUB4";
endif;

$googleUrl = "https://www.google.com/search?q=$valor";
$arrMaskRemoveG = (['<td class="data destaque w3"><span class="txt">', '</span></td>', '</span>']);
#Obtendo o valor principal do Google
$retorno = new script($googleUrl, "/\d\d,\d\d<\/span>/", $arrMaskRemoveG);
$valorGoogle = $retorno->valor[0];

$arrGoogle = (['cotacao_google' => $valorGoogle]);


$urlFundamentus = "http://fundamentus.com.br/detalhes.php?papel=$valor&x=0&y=0";
$arrMaskRemove = (['"><span class="txt">', '</span>','<font color="#F75D59">','</font>','<font color="#306EFF">']);
$chaves = (['papel', 'cotacaoFundamentus', 'tipo', 'data_ult_cotacao', 'empresa', 'min52sem',
            'skip', 'max52sem', 'skip', 'vol_med_2sem', 'valor_mercado', 'ult_balanco_processado',
            'valor_da_firma', 'nro_acoes', 'skip', 'skip', 'skip', 'oscilacao_dia', 'if_PL', 'if_LPA',
            'skip', 'oscilacao_mes', 'if_PVP', 'if_VPA', 'skip', 'oscilacao_30dias', 'if_PEBIT', 'if_marg_bruta',
            'skip', 'oscilacao_12meses', 'if_PSR', 'if_EBIT', 'skip', 'oscilacao_2018', 'if_ativos',
            'if_marg_liquida', 'skip', 'oscilacao_2017', 'if_pcap_giro', 'if_ebit_ativo', 'skip', 'oscilacao_2016',
            'if_ativ_circ_liq', 'if_ROIC', 'skip', 'oscilacao_2015', 'if_div_yield', 'if_ROE',
            'skip', 'oscilacao_2014', 'if_EV_EBIT', 'id_liquidez_corr', 'skip',  'oscilacao_2013',
            'if_giro_ativos', 'if_div_br_patrim', 'if_cres_rec', 'skip', 'dbp_ativo', 'dbp_div_bruta', 
            'dbp_disponibilidades', 'dbp_div_liquida', 'dbp_ativo_circulante', 'dbp_patrim_liquido', 
            'skip', 'skip', 'skip', 'ddr_receita_12liquida', 'ddr_receita_3liquida', 'ddr_12EBIT', 'ddr_3EBIT',
            'ddr_12lucro_liquido', 'ddr_3lucro_liquido' ]);

#Obtendo os valores da Fundamentus
$retorno = new script($urlFundamentus, "/\"><span class=\"txt\">.+<\/span>|<font color=\"#F75D59\">.+<\/font>|<font color=\"#306EFF\">.+<\/font>|\"><span class=\"txt\">\s.+<\/span>/", $arrMaskRemove);


$dadosRetorno = $retorno->valor;
$dadosRetorno = array_map("utf8_encode", $dadosRetorno );

#var_dump($dadosRetorno);

$arrJson = [];
$cont = 0;

foreach($chaves as $chave):
    if($chave == 'skip'){
        $cont++;
        continue; 
    }
    $arrJson[$chave] = trim($dadosRetorno[$cont]);
    $cont++;
endforeach;

echo json_encode(array_merge($arrGoogle, $arrJson));

?>