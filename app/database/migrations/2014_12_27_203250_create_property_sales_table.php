<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertySalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('property_sales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('parcel');
			$table->string('address');
			$table->string('community', 50)->nullable();
			$table->string('type', 15);
			$table->string('class', 15);
			$table->float('acreage');
			$table->string('zoning', 25)->nullable();
			$table->smallInteger('building_count')->nullable();
			$table->smallInteger('year_built')->nullable();
			$table->date('sale_date');
			$table->integer('sale_price');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('property_sales');
	}

}
