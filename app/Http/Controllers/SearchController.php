<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    protected $results = array();
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

    private function searchZipCode(string $zipCode): array
    {
        $url = "https://viacep.com.br/ws/$cep/json/";

        return array();
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
