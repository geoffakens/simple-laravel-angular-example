<?php
class PropertySalesTableSeeder extends Seeder {

    /**
     * Seeds the property_sales table.
     */
    public function run() {
        // Disable query logging to avoid out of memory issues.
        DB::connection()->disableQueryLog();

        // Clear existing records from the table.
        DB::table('property_sales')->delete();

        // Get the directory containing this script, which also contains the CSV file to process.
        $dirName = realpath(dirname(__FILE__));

        // Process the CSV file containing the sale information.
        $this->processPropertySaleFile($dirName . "/ElPasoCountyThreeMonthSalesReport.csv");
    }

    /**
     * Adds the property sale information in the specified file to the property_sales table.
     *
     * @param $filename string The path to the CSV file containing the information to add to the table.
     */
    function processPropertySaleFile($filename) {
        echo 'Processing Property Sale File: ' . $filename . "\n";

        $count = 0;
        $file = fopen($filename, 'r');
        while($sale = fgetcsv($file, 0, ",")) {
            // The first record contains the field names, so ignore it.
            if($count > 0) {
                $this->saveSale($sale);
            }
            $count++;
        }
        fclose($file);
    }

    /**
     * Creates a record in the property_sales table with the specified sale data.
     *
     * @param $saleData array The data for an individual property sale.
     */
    function saveSale(&$saleData) {
        $sale = new PropertySale;

        $sale->parcel = $this->getValue($saleData[0]);
        $sale->address = $this->getValue($saleData[1]);
        $sale->community = $this->getValue($saleData[2]);
        $sale->type = $this->getValue($saleData[3]);
        $sale->class = $this->getValue($saleData[4]);
        $sale->acreage = $this->getFloatValue($saleData[7]);
        $sale->zoning = $this->getValue($saleData[8]);
        $sale->building_count = $this->getValue($saleData[9]);
        $sale->year_built = $this->getValue($saleData[10]);
        $sale->sale_date = $this->getDateValue($saleData[14]);
        $sale->sale_price = $this->getIntValue($saleData[15]);

        $sale->save();
    }

    function nullOrEmptyString(&$value) {
        return !isset($value) || trim($value) === '';
    }

    function getValue(&$value) {
        return $this->nullOrEmptyString($value) ? null : $value;
    }

    function getIntValue(&$value) {
        return $this->nullOrEmptyString($value) ? null : intval($value);
    }

    function getFloatValue(&$value) {
        return $this->nullOrEmptyString($value) ? null : floatval($value);
    }

    function getDateValue(&$value) {
        return $this->nullOrEmptyString($value) ? null : date("Y-m-d", strtotime($value));
    }

}