<?php
namespace App\Services\CurrencyUpdate;

use App\Exceptions\CurrencyLayerHttp;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class CurrencyLayerUpdater implements CurrencyUpdateInterface{

    public function __construct(protected string $apiKey,protected string $apiUrl)
    {
    }
    public function updateRates():void{
        Currency::chunk(5,function($items){
            $this->updateBatch($items);
        });
    }
    /**
     * @param Collection<Currency> $items
     */
    protected function updateBatch(Collection $items){
        $signatures = $items->pluck('signature')->toArray();
        $response = Http::get($this->apiUrl,[
            'currencies'=>implode(',',$signatures),
            'source'=>'USD',
            'format'=>1,
            'access_key'=>$this->apiKey
        ]);
        if(!$response->ok()){
            throw CurrencyLayerHttp::responseNotOk();
        }
        $data = $response->json();
        foreach ($data['quotes'] as $currencyPair => $rate) {
            $signature = substr($currencyPair,3,3);
            $model = $items->where('signature',$signature)->first();
            if(is_null($model)){
                throw CurrencyLayerHttp::returnedPairNotFound($currencyPair);
            }
            $model->rate = $rate;
            $model->saveOrFail();
        }
    }
}