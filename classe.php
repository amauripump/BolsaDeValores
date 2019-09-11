<?php

/*
    @author: Amauri da Silva Junior
    @date: 08/08/2018
*/
class script{

    var $parametro;
    var $valor;

    public function __construct($param = "https://www.google.com/search?q=ITUB4", $base = "/\d\d,\d\d<\/span>/", $mask){
        return $this->buscaPadrao($param, $base, $mask);
    }

    public function buscaPadrao($url, $base, $mask){
        
        $retorno = shell_exec('curl -L '.$url.' -H "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0"');
    
        preg_match_all($base , $retorno, $arrRetorno);
    
        if(is_array($arrRetorno)){
            #var_dump($arrRetorno);
            @$arrRetorno = $arrRetorno[0];

        }
        
        $this->valor =  $this->formataRetorno($arrRetorno, $mask);
    }

    public function formataRetorno($valor, $masks = array()){

        foreach($masks as $mask):
            $valor = str_replace($mask, '', $valor);
        endforeach;
        // Substitui os padrões para o valor ficar sozinho na string de retorno
        #$valor = str_replace('.', '', $valor);
        #$valor = str_replace(',', '.', $valor);
        return $valor;
    }

    public function dicionario($valor = ""){
        $arrDicionario = ([
            'papel' => 'Papel',
            'cotacaoFundamentus' => 'Cotação da Fundamentus',
            'tipo' => 'Tipo',
            'data_ult_cotacao' => 'Data Última Cotação',
            'empresa' => 'Empresa',
        ]);

        return (key_exists($arrDicionario[$valor])) ? $arrDicionario[$valor] : $valor;
    }
}