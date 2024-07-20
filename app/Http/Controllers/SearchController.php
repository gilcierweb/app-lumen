<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenApi\Annotations as OA;
class SearchController extends Controller
{
    protected $results = array();

    /**
     * @OA\Get(
     *     path="/api/search/local/{zipCodes}",
     *     operationId="/search/local/{zipCodes}",
     *     tags={"Master Data"},
     *     @OA\Parameter(
     *         name="zipCodes",
     *         in="path",
     *         description="CEP of viaCEP to return",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns list of zip codes in the viaCEP",
     * 
     *         @OA\JsonContent(type="array", 
     *             @OA\Items(type="string", example=
     *               {
     *                   "cep": "60050-070",
     *                   "logradouro": "Rua Barão de Aratanha",
     *                   "complemento": "até 338/339",
     *                   "unidade": "",
     *                   "bairro": "Centro",
     *                   "localidade": "Fortaleza",
     *                   "uf": "CE",
     *                   "ibge": "2304400",
     *                   "gia": "",
     *                   "ddd": "85",
     *                   "siafi": "1389"
     *               }
     *               )
     *         )
     *     ),
     * )
     */
    public function index(Request $request)
    {
        $zipCode = $request->zip;
        $zipCodes  = explode(",", $zipCode);
        foreach ($zipCodes as $zipCode) {
            $code = $this->validateZipCode($zipCode);

            $this->requestViaCEP($code);
        }

        return response()->json($this->results);
    }
    private function validateZipCode(string $zipCode)
    {
        $formatedZipCode = $this->numberClear($zipCode);

        if (!preg_match('/^[0-9]{8}?$/', $formatedZipCode)) {
            throw new \Exception("CEP $formatedZipCode está inválido");
        }

        return $formatedZipCode;
    }

    private function numberClear(string $number): ?string
    {
        if ($number == null) {
            return null;
        }

        return preg_replace('/[^0-9]/', '', $number);
    }

    private function requestViaCEP(string $zipCode)
    {

        $url = "https://viacep.com.br/ws/$zipCode/json/";

        $response = Http::get($url);

        $result = $response->json();
        array_push($this->results, $result);
    }
}
