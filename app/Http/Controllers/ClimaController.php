<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Stmt\Foreach_;
use SimpleXMLElement;

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


    /*
    // Função para retornar ID e NOME das cidades de uma determinada UF a partir de um XML
    public function busca_cidade($uf) {
        $url = 'http://servicos.cptec.inpe.br/XML/listaCidades';

        try {
            // Carrega o conteúdo do XML da URL para um objeto SimpleXMLElement
            $xml = new SimpleXMLElement(file_get_contents($url));

            $cidadesFiltradas = [];

            // Itera sobre cada elemento 'cidade' no XML
            foreach ($xml->cidade as $cidade) {
                // Obtém o valor da UF da cidade
                $ufCidade = (string) $cidade->uf;

                // Verifica se a UF da cidade corresponde à UF fornecida
                if ($ufCidade === $uf) {
                    // Obtém o ID e o nome da cidade
                    $id = (int) $cidade->id;
                    $nome = (string) $cidade->nome;

                    // Cria um array associativo com ID e nome da cidade
                    $cidadeArray = [
                        'id' => $id,
                        'nome' => $nome
                    ];

                    // Adiciona a cidade filtrada ao array de cidades filtradas
                    $cidadesFiltradas[] = $cidadeArray;
                }
            }

            return $cidadesFiltradas;

        } catch (Exception $e) {
            // Em caso de erro ao carregar o XML ou ao processar as cidades
            echo "Erro ao processar o XML: " . $e->getMessage();
            return [];
        }
    }
    */

    public function busca_cidade($uf) {
        $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/'.$uf.'/municipios/';
        $json = file_get_contents($url);
        $jo = json_decode($json);
        return $jo;
    }

    public function busca_clima() {
        $dados = [];
        $dados['estados'] = $this->busca_estados();

        //Consulta Dados do Clima
        try {
            $url = 'http://servicos.cptec.inpe.br/XML/listaCidades?city='.urlencode($_GET['cidade']);
            //dump($url);
            $xml = new SimpleXMLElement(file_get_contents($url));
            //dump($xml->cidade->id);4
            $url = "http://servicos.cptec.inpe.br/XML/cidade/".$xml->cidade->id."/previsao.xml";
            $xml = new SimpleXMLElement(file_get_contents($url));
        } catch (Exception $e) {
            // Em caso de erro ao carregar o XML ou ao processar as cidades
            echo "Erro ao processar o XML: " . $e->getMessage();
            exit(1);
        }

        // Carrega o conteúdo do XML da URL para um objeto SimpleXMLElement

        $dados['clima'] =  'Dados: '.json_encode($xml);
        return view('clima',$dados);
    }

    public function index() {
       $dados = [];
       $dados['estados'] = $this->busca_estados();
       //$dados['cidades'] = $this->busca_cidade();
       $dados['clima'] = $this->busca_clima();
       //print_r($dados);
       return view('clima',$dados);
    }

}
