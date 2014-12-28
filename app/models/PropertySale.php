<?php

class PropertySale extends Eloquent {
    /**
     * @var string The database table used by the model.
     */
    protected $table = 'property_sales';

    /**
     * @var boolean Don't maintain created/updated columns.
     */
    public $timestamps = false;
}
