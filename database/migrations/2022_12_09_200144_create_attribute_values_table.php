<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('attribute_id')->constrained();            
            $table->string('name');
            $table->string('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /*
    item => ('id'=>'5' , 'name'=>'coffee')
    attribute => ('id'=>7 , 'name'=>'extentions')
    attr_value => ('id'=>1 , 'item_id'=>5 , 'attribute_id'=>7 , name=>'espresso single shot' , price=>'5')
    attr_value => ('id'=>1 , 'item_id'=>5 , 'attribute_id'=>7 , name=>'espresso double shot' , price=>'8')

$item has many attributes 
$attribute has many attr_values

public $totalPrice=0.0;
foreach($item->attributes as $attribute){
    foreach($attribute->attr_values as $value){
    $totalPrice+=$value->price;
    }
}
    
    
    */
     

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
};
