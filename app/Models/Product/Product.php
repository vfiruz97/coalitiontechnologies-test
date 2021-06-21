<?php

namespace App\Models\Product;

use Illuminate\Support\Facades\Storage;

class Product
{

    private $id;
    private $productName;
    private $quantityInStock;
    private $pricePerItem;
    private $totalValueNumber;
    private $sendDateTime;

    public function __construct(
        $id,
        $productName,
        $quantityInStock,
        $pricePerItem
    ) {
        $this->id = $id ?? uniqid();
        $this->productName = $productName;
        $this->quantityInStock = $quantityInStock;
        $this->pricePerItem = $pricePerItem;
        $this->totalValueNumber = $quantityInStock * $pricePerItem;
        $this->sendDateTime = date("Y/m/d H:i:s");
    }

    public static function all()
    {
        $products = [];
        $rowProducts =  json_decode(Storage::disk('public')->get('products.json'));
        if (!empty($rowProducts && isset($rowProducts->length))) {
            foreach ($rowProducts->products as $key => $item) {
                $products[] = [
                    "id" => $item->id,
                    "productName" => $item->productName,
                    "quantityInStock" => $item->quantityInStock,
                    "pricePerItem" => $item->pricePerItem,
                    "totalValueNumber" => $item->totalValueNumber,
                    "sendDateTime" => $item->sendDateTime,
                ];
            }
        }

        return $products;
    }

    public function save()
    {
        $products = self::all();
        array_unshift($products, $this->toArray());
        $fileData = [
            'products' => $products,
            'length' => count($products)
        ];
        Storage::disk('public')->put('products.json', $this->toJson($fileData));
    }

    public function update($productId)
    {
        $products = self::all();
        foreach ($products as $key => $product) {
            if ($product['id'] === $this->id) {
                $products["$key"] = $this->toArray();
                break;
            }
        }
        $fileData = [
            'products' => $products,
            'length' => count($products)
        ];
        Storage::disk('public')->put('products.json', $this->toJson($fileData));
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "productName" => $this->productName,
            "quantityInStock" => $this->quantityInStock,
            "pricePerItem" => $this->pricePerItem,
            "totalValueNumber" => $this->totalValueNumber,
            "sendDateTime" => $this->sendDateTime,
        ];
    }

    protected function toJson(array $array)
    {
        return json_encode($array);
    }
}
