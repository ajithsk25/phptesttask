Welcome to the Currency Solutions Test Pack.

Your test pack includes:
* This readme file
* The bank statement file (statement.csv)
* The skeleton class (Bootstrap.php)


Objective:
We want to parse the bank statement to deduce the total value of payments made on 6 March 2011 for
each currency.  All lines of the bank statement that represent a payment will contain a payment 
reference in one of it's narratives.  A payment reference is guaranteed to be the letters "PAY" 
then 6 digits and then two more letters (e.g. PAY000001YB).  The currencies that we deal with for 
the purpose of this exercise are GBP, EUR, USD and CAD. 
If there is another currenciy in a bank statement, it also should be in the oputput.


Sample Output:

Totals
GBP 3,432.21
USD 14,432.34
EUR 43,543.23
CAD 2,321.34


Instructions:
* Complete the skeleton class so that running "php Bootstrap.php statement.csv" on the commandline 
  will parse the bank statement file and output the sample output above.
* You may add additional classes and files to complete the task.
* Please return the completed test pack including any additional files as a single zip archive.
* Execution of a script should not take longer than 30 seconds.
* Completion of this task should not take longer than 2 hours of your time.
* We want to check your application architecture skills so use the OOP paradigm please.
* We ask you not to publish your solution to this task anywhere.
