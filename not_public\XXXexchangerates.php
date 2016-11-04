<?php


function GetEuros($foreignCurrency, $foreignAmount){


$now = time();
$cache = "erates.xml";
$exchrate[EUR] = 1.00;
$amount = 1000;

# Exchange rates - Grab current rates from European Central Bank

# Check whether we have a recent copy of the data locally

if (($interval = $now - filemtime($cache)) > 3600 * 2) {
    $stuff = file("http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml");
    $trace = "Cache REFRESHED after $interval seconds";
    $fh = fopen($cache, "w");
    foreach ($stuff as $line) {
        fputs($fh, $line);
    }
} else {
    $stuff = file($cache);
    $trace = "Cached information reused aged $interval seconds";
}

# Currency names that we'll use later on

$names = array(USD => "US Dollar", JPY => "Japanese Yen", DKK => "Danish Krone",
    GBP => "Pound Sterling", SEK => "Swedish Krona", CHF => "Swiss Franc", ISK =>
    "Icelandic Krona", NOK => "Norwegian Krone", BGN => "Bulgarian Lev", CYP =>
    "Cyprus Pound", CZK => "Czech Koruna", EEK => "Estonian Kroon", HUF =>
    "Hungarian Forint", LTL => "Lithuanian Litas", LVL => "Latvian Lats", MTL =>
    "Maltese Lira", PLN => "Polish Zloty", ROL => "Romanian Leu", SIT =>
    "Slovenian Tolar", SKK => "Slovakian Koruna", TRL =>
    "Old Turkish Lira (to 2004)", 'TRY'=> "New Turkish Lira (2005)", AUD =>
    "Australian Dollar", CAD => "Canadian Dollar", HKD => "Hong Kong Dollar", NZD =>
    "New Zealand Dollar", SGD => "Singapore Dollar", KRW => "South Korean Won", EUR =>
    "European Euro", ZAR => "South African Rand");

# Extract data from page - conversion rates between each currency and the Euro

foreach ($stuff as $line) {
    ereg("currency='([[:alpha:]]+)'", $line, $gota);
    if (ereg("rate='([[:graph:]]+)'", $line, $gotb)) {
        $exchrate[$gota[1]] = $gotb[1];
    }
}

	return sprintf("%.2f", $foreignAmount * $exchrate[EUR] / $exchrate[$foreignCurrency]);
}


# Sample output - a table showing an amount converted to Euros, Pounds and Dollars
/*
print ("<b>Conversion to Euros, Pounds, US Dollars from other currencies</b><br>");
print ("<center><table cellpadding=5><tr><td>&nbsp;</td><th>Euros</th><th>Pounds</th><th>Dollars</th></tr>");
foreach (array_keys($exchrate) as $to) {
    if ($names[$to] == "")
        $names[$to] = $to;
    print ("<tr><td>$amount $names[$to] is about </td>");
    foreach (array("EUR", "GBP", "USD") as $from) {
        $convertsto = sprintf("%.2f", $amount * $exchrate[$from] / $exchrate[$to]);
        print ("<td align=right>$convertsto</td>");
    }
    print ("<tr>");
}
print ("</table></center>");
*/

	



?>