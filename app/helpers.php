<?php

use App\Models\Modulos;

function PegaDispositivo()
{
    $iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
    $ipad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");
    $symbian = strpos($_SERVER['HTTP_USER_AGENT'], "Symbian");
    $windowsphone = strpos($_SERVER['HTTP_USER_AGENT'], "Windows Phone");

    if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian || $windowsphone == true) {
        $dispositivo = "mobile";
    } else {
        $dispositivo = "computador";
    }

    return $dispositivo;
}





function format_Size($set_bytes)
{
    $set_kb = 1024;
    $set_mb = $set_kb * 1024;
    $set_gb = $set_mb * 1024;
    $set_tb = $set_gb * 1024;
    if (($set_bytes >= 0) && ($set_bytes < $set_kb)) {
        return $set_bytes . ' B';
    } elseif (($set_bytes >= $set_kb) && ($set_bytes < $set_mb)) {
        return ceil($set_bytes / $set_kb) . 'KB';
    } elseif (($set_bytes >= $set_mb) && ($set_bytes < $set_gb)) {
        return ceil($set_bytes / $set_mb) . 'MB';
    } elseif (($set_bytes >= $set_gb) && ($set_bytes < $set_tb)) {
        return ceil($set_bytes / $set_gb) . 'GB';
    } elseif ($set_bytes >= $set_tb) {
        return ceil($set_bytes / $set_tb) . 'TB';
    } else {
        return $set_bytes . 'Bytes';
    }
}

function folder_Size($set_dir)
{
    $set_total_size = 0;
    $set_count = 0;
    $set_dir_array = scandir("/");
    foreach ($set_dir_array as $key => $set_filename) {
        if ($set_filename != ".." && $set_filename != ".") {
            if (is_dir($set_dir . "/" . $set_filename)) {
                $new_foldersize = folder_Size($set_dir . "/" . $set_filename);
                $set_total_size = $set_total_size + $new_foldersize;
            } else if (is_file($set_dir . "/" . $set_filename)) {
              //  dd($set_filename);
                $set_total_size = $set_total_size + filesize($set_dir  );
                $set_count++;
            }
        }
    }
    return $set_total_size;
}

function tamanhoPasta($pasta)
{
    return format_Size(folder_Size($pasta));
}

function mesAno($valor)
{
    $yearMap = [

        1 => 'JANEIRO',
        2 => 'FEVEREIRO',
        3 => 'MARCO',
        4 => 'ABRIL',
        5 => 'MAIO',
        6 => 'JUNHO',
        7 => 'JULHO',
        8 => 'AGOSTO',
        9 => 'SETEMBRO',
        10 => 'OUTUBRO',
        11 => 'NOVEMBRO',
        12 => 'DEZEMBRO',
    ];
    return $yearMap[$valor];
}

function diaSemana($valor)
{
    $weekMap = [

        1 => 'Segunda',
        2 => 'Terça',
        3 => 'Quarta',
        4 => 'Quinta',
        5 => 'Sexta',
        6 => 'Sabado',
        7 => 'Domingo',
    ];
    return $weekMap[$valor];
}




function diaTurno($valor)
{
    $weekMap = [

        1 => 'MANHÃ',
        2 => 'TARDE',
        3 => 'NOITE',

    ];
    return $weekMap[$valor];
}


function calculaIdade($data)
{
    if ($data == null) return null;


    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $data);
    return $date->diffInYears(\Carbon\Carbon::now());
}

function formataData($data)
{
    return date('d/m/Y', strtotime($data));
}


function formataTelefone($numero)
{
    $numero = str_replace(['.', '-', '(', ')'], "", $numero);

    $formata = substr($numero, 0, 2);
    $formata_2 = substr($numero, 2, 5);
    $formata_3 = substr($numero, 7, 4);
    return "(" . $formata . ") " . $formata_2 . "-" . $formata_3;
}

function formataHora($data)
{
    return  date('H:i:s', strtotime($data));
}

function formataMoeda($data)
{
    return 'R$ ' . number_format($data, 2, ',', '.');
}

function formataDecimal($valor)
{

    return  number_format($valor, 2, ',', '.');
}


function limpaCPF($cpf)
{
    return  str_replace(['.', '-'], "", $cpf);
}

function limpaCEP($cep)
{
    return  str_replace(['.', '-'], "", $cep);
}

/* 
function limpaCaractere($caractere){
    return  str_replace(['.','-'],"",$cpf);
} */


function formata_cpf_cnpj($cpf_cnpj)
{
    /*
        Pega qualquer CPF e CNPJ e formata

        CPF: 000.000.000-00
        CNPJ: 00.000.000/0000-00
    */

    ## Retirando tudo que não for número.
    $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
    $tipo_dado = NULL;
    if (strlen($cpf_cnpj) == 11) {
        $tipo_dado = "cpf";
    }
    if (strlen($cpf_cnpj) == 14) {
        $tipo_dado = "cnpj";
    }
    switch ($tipo_dado) {
        default:
            $cpf_cnpj_formatado = "Não foi possível definir tipo de dado";
            break;

        case "cpf":
            $bloco_1 = substr($cpf_cnpj, 0, 3);
            $bloco_2 = substr($cpf_cnpj, 3, 3);
            $bloco_3 = substr($cpf_cnpj, 6, 3);
            $dig_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;
            break;

        case "cnpj":
            $bloco_1 = substr($cpf_cnpj, 0, 2);
            $bloco_2 = substr($cpf_cnpj, 2, 3);
            $bloco_3 = substr($cpf_cnpj, 5, 3);
            $bloco_4 = substr($cpf_cnpj, 8, 4);
            $digito_verificador = substr($cpf_cnpj, -2);
            $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;
            break;
    }
    return $cpf_cnpj_formatado;
}


// function verificaModulo($modulo)
// {
//   $modulo = Modulos::where('modulo',$modulo)->get()->last();
//   return $modulo->status;   
// }
function virgula_por_ponto($numero)
{
return  str_replace([','], ".", floatval($numero));
}

function converte_data($data){
    $result =  str_replace(['/'], "-", $data);
        $result = date_create($result . " 00:00:00");
       $result =  date_format($result, 'Y-m-d H:i:s');
       return $result;
}

