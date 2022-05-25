<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //별 변화가 없으면 defalult로
        //return parent::toArray($request);
        //필요한 attribute만 json으로 만들려면 다음과 같이
        return [
            'name' => $this->title,
            'author' => $this->author,
            'memo' => $this->memo,
        ];

        /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request
     * @param  \Illuminate\Http\Response
     * @return void
     */
    }

    public function withResponse($request, $response)
    {
        $response->header('Charset', 'utf-8');
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
