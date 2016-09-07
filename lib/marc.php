<?php
// Converts a MARC record in standard string format to an Associative Array
class Text_Marc
{
    function toArray($sMarc)
    {
        $aMarc = array();

        $rs = explode("\n", $sMarc);
        foreach ($rs as $record) {
            // Determine Element Key
            $key = substr($record, 0, 3);

            // Determine Element Value
            // is this valid?
            if (intval($key) >= 10) { 
                $value = substr($record, 7);
            } else {
                $value = substr($record, 4);
            }

            // Seperate Subfields into an array
            $regexp = '/(\$. )/';
            if (preg_match($regexp, $value)) {
                $value = preg_split($regexp, $value, -1, PREG_SPLIT_NO_EMPTY);
            }
 
            // Build Array
            if ($key != null) {
                if (array_key_exists($key, $aMarc)) {
                    $tmp = $aMarc[$key];
                    if (is_array($tmp)) {
                        $aMarc[$key] = array_push($tmp, $value);
                    } else {
                        $aMarc[$key] = array($tmp, $value);
                    }
                } else {
                    $aMarc[$key] = $value;
                }
            }
        }
  
        return $aMarc;
    }
}

?>
