<?php
/*===================AVISOS IMPORTANTES=================
Se você escrever "echo" nesse arquivo o PDF não irá funcionar

O arquivo de testes possui notas adicionais
*/
//pega o número do lote
$numeroLote = $_GET['numeroLote'];

//carregar o dompdf do composer
require 'vendor/autoload.php'; // #01

//referenciar o namespace Dompdf
use Dompdf\Dompdf;

//chama o modelo_pdf
require_once 'modeloPDF.php';

//instanciar e usar o Dompdf
//$dompdf = new Dompdf(); <--- este é um exemplo simples de como instanciar o Dompdf
$dompdf = new Dompdf(['enable_remote' => true]); // o ['enable_remote'=>true] serve para que o Dompdf pegue informações de conteúdos fora dos arquivos utilizados, como informações de sites por exemplo (http://localhost/img/module_table_botton.png).

//pega o valor do modelo pdf
$html = html($numeroLote);

//instanciar o método loadHtml e enviar as informações para o PDF
//$dompdf->loadHtml('Paulo está testando o Dompdf');  <--- este é um exemplo bem simples do que podemos colocar dentro do PDF, lembrando que tudo o que estiver aqui ((dentro do parênteses do método $dompdf->loadHtml()) estará no PDF
$dompdf->loadHtml($html);

//definição da fonte
$dompdf->getOptions('defaultFont', 'Arial');

//definir a orientação e tamanho do PDF
//landscape defini o PDF como modo paisagem
$dompdf->setPaper('A4', 'portrait');

//rendenizar o html como PDF
$dompdf->render();

//gerar PDF
$dompdf->stream("Relatório de experimento lote n°" . $numeroLote);
