<?php

require 'ParseCSVException.php';

/**
 * @author <ajith.sk25@gmail.com>
 * @package test
 *
 */
class Bootstrap
{
    // defines default currencies with total as zero
    private static $currencyArr = [
        'GBP' => 0, 
        'EUR' => 0, 
        'USD' => 0, 
        'CAD' => 0
    ]; 

    // defines the headers in CSV
    private static $headerArr = [
        'Date', 
	'Narrative 1', 
        'Narrative 2', 
        'Narrative 3', 
        'Narrative 4', 
        'Narrative 5', 
        'Type', 
        'Credit', 
	'Debit', 
        'Currency'
    ];

    // defines the regular expression to be checked in narrators
    private static $paymentReferencePattern = '/[PAY]\d{6}[a-zA-Z]{2}/';

    // date to be parsed from CSV
    public static $parseDate;
    
    /**
     * Parses the statement CSV and returns the totals for each currency
     *
     * @param string $csvFile Path name for CSV file
     *
     * @return array
     */
    public static function parseStatementCSV($csvFile)
    {
         try {
	     $row = 1;
	     $formattedParseDate = self::formatDate(self::$parseDate);
             $currencyArr = self::$currencyArr;
	     if (!file_exists($csvFile)) {
	         throw new ParseCSVException('CSV file not found!');
             }
	     $handle = fopen($csvFile, "r");
             if (false !== $handle) {
                 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                     // checks if first row is header
                     if($row==1) {
                         $num = count($data);
                         if(self::$headerArr !== $data) {
			     throw new ParseCSVException('Invalid headers in CSV!');
                         }
        	     } else {
                         // combines narrator values to an array
		         $narratorArr = [$data[1], $data[2], $data[3], $data[4], $data[5]];

                         // checks if payment reference matches in any of the narrator values
          	         if(preg_grep(self::$paymentReferencePattern, $narratorArr)) {
                             if($formattedParseDate == self::formatDate($data[0])) {
                                 // checks if currency exists else add new currency
                                 if(!array_key_exists($data[9], $currencyArr)) {
                                     $currencyArr[$data[9]] = 0;
                                 }

                                 // add total for each currency
			         $currencyArr[$data[9]] += $data[8];
            	    	     }
          	        }
        	    }
       	            $row++;
	        }

                fclose($handle);
            } else {
	        throw new ParseCSVException('Failed opening CSV file!');
	    }

            return $currencyArr;

	} catch (ParseCSVException $e) {
	    throw new ParseCSVException($e->getMessage());
	}
    }
    
    /**
     * Formats the date to d-m-Y
     *
     * @param string $date Date string
     *
     * @return string
     */
    public static function formatDate($date)
    {
        date_default_timezone_set('UTC');
        $dt = new DateTime(str_replace('/', '-', $date));
        
	return $dt->format('d-m-Y');
    }
    
    /**
     * Gets the total of each currency
     *
     * @param array $argv
     */
    public static function main($argv)
    {	
	try {
            // checks if CSV path name is passed
            if (!empty($argv[1])) {
                $output = self::parseStatementCSV($argv[1]);
                echo "Totals\n";

        	foreach ($output as $currency => $total) {
            	    echo $currency . " " . $total . "\n";
        	}
	    } else {
		throw new Exception("Argument missing for CSV path name!");
	    }
	} catch (ParseCSVException $e) {
	    echo "Error::" . $e->getMessage() . "\n";
	} catch (Exception $e) {
	    echo "Error::" . $e->getMessage() . "\n";
	}
    }
}

// Date to be parsed from statement CSV
Bootstrap::$parseDate = '6 March 2011'; // can pass date in d-m-Y, d/m/Y formats
Bootstrap::main($argv);
