<?php
namespace Album\Model;

class Album
{
    public $id;
    public $product_name;
    public $sku;
    public $stock;
    public $prouduct_url;
    public $price;
    public $image;
    public $image2;
    public $image3;
    public $image4;
    public $image5;
    public $manufacturer;

    public function exchangeArray($data)
    {
        $this->product_name = (!empty($data['PRODUCT_NAME'])) ? $data['PRODUCT_NAME'] : null;
        $this->sku = (!empty($data['SKU'])) ? $data['SKU'] : null;
        $this->stock = (!empty($data['STOCK'])) ? $data['STOCK'] : null;
        $this->prouduct_url = (!empty($data['PROUDUCT_URL'])) ? $data['PROUDUCT_URL'] : null;
        $this->price = (!empty($data['PRICE'])) ? $data['PRICE'] : null;
        $this->image = (!empty($data['IMAGE'])) ? $data['IMAGE'] : null;
        $this->image2 = (!empty($data['IMAGE2'])) ? $data['IMAGE2'] : null;
        $this->image3 = (!empty($data['IMAGE3'])) ? $data['IMAGE3'] : null;
        $this->image4 = (!empty($data['IMAGE4'])) ? $data['IMAGE4'] : null;
        $this->image5 = (!empty($data['IMAGE5'])) ? $data['IMAGE5'] : null;
        $this->manufacturer = (!empty($data['MANUFACTURER'])) ? $data['MANUFACTURER'] : null;
    }
}