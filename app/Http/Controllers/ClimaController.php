<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Stmt\Foreach_;

class ClimaController extends Controller
{
    //Função index de retorno do Cliema

    private function busca_estados() {
        $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/';
        $json = file_get_contents($url);
        $jo = json_decode($json);
        foreach ($jo as $estado) {
            $estados[$estado->sigla] = array('sigla'=>$estado->sigla, 'nome'=>$estado->nome);
        }
        sort($estados);
        return $estados;
    }

    public function busca_cidade($uf) {
        $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/'.$uf.'/municipios/';
        $json = file_get_contents($url);
        $jo = json_decode($json);
        return $jo;
    }

    private function busca_clima() {
        return 'Chuva em ';
    }

    public function index() {
       $dados = [];
       $dados['estados'] = $this->busca_estados();
       //$dados['cidades'] = $this->busca_cidade();
       $dados['clima'] = $this->busca_clima('cidade');
       //print_r($dados);
       return view('clima',$dados);
    }

}
