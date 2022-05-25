<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
  //    return parent::toArray($request);
        return [
            // this->collection 은 BookResource에 정의된 내용대로 return
            'book' => $this->collection,
            // 그 외 추가적으로 필요한 filed를 포함할 수도 있다
            'withOthers' => 'Others',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Charset', 'utf-8');
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
