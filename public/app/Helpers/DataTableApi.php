<?php

namespace App\Helpers;

use App\Estagio;
use Illuminate\Support\Facades\Log;

use App\Helpers\List_Util;

class DataTableApi
{

    public function __construct()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: *');
    }

    public function inits($data = [], $columns = [])
    {
        $columnsDefault = $columns;
        if (isset($_REQUEST['columnsDef']) && is_array($_REQUEST['columnsDef'])) {
            foreach ($_REQUEST['columnsDef'] as $field) {
                $columnsDefault[$field] = true;
            }
        }
        // filter by general search keyword
        if (isset($_REQUEST['search']['value']) && $_REQUEST['search']['value']) {
            $data = $this->arraySearch($data, $_REQUEST['search']['value']);
        }

        //filter by specific column keywork
        if (isset($_REQUEST['columns']) && is_array($_REQUEST['columns'])) {
            foreach ($_REQUEST['columns'] as $column) {
                if (isset($column['search']['value']) && $column['search']['value']) {
                    $data = $this->filterKeyword($data, $column['search'], $column['data']);
                }
            }
        }
        // count data
        $totalRecords = $totalDisplay = count($data);
 
        //Sort data
        if (isset($_REQUEST['order'][0]['column']) && $_REQUEST['order'][0]['dir'] && $totalRecords > 0) {

            $column = $_REQUEST['order'][0]['column'];
            $columnName = $_REQUEST['columns'][$column]['data'];
            $dir = $_REQUEST['order'][0]['dir'];


            //iterate over $data, on first element get the key of the column to sort by, end cycle
            foreach ($data as $value) {
                if(!is_array($value))
                    $column = array_search($columnName, array_keys($value->toArray()));
                else 
                    $column = array_search($columnName, array_keys($value));
                break;
            }

            usort($data, function ($a, $b) use ($column, $dir, $columnName) {

                //check if $a and $b are arrays or objects
                if(!is_array($a))
                    $a = $a->toArray();
                if(!is_array($b))
                    $b = $b->toArray();

                //get values in column with $columnName
                $a = array_slice($a, $column, 1);
                $b = array_slice($b, $column, 1);

                $a = array_pop($a);
                $b = array_pop($b);

                if ($dir === 'asc') {
                    return $a > $b ? 1 : -1;
                } else {
                    return $a < $b ? 1 : -1;
                }
            });
        }

        // pagination length
        if (isset($_REQUEST['length'])) {
            $data = array_splice($data, $_REQUEST['start'], $_REQUEST['length']);
        }

        $data = $this->reformat($data);

        $result = [
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data' => $data,
        ];

        return json_encode($result, JSON_PRETTY_PRINT);
    }


    public function filterKeyword($data, $search, $field = '')
    {

        if (isset($search['value'])) {
            $filter = $search['value'];
        } else
            $filter = '';

        if (!empty($filter)) {
            if (!empty($field)) {
                //add here a filter for specific field type if needed
                //like $data = $this->filterByDateRange($data, $filter, $field);

                $data = array_filter($data, function ($a) use ($field, $filter) {
                    return (bool) preg_match("/$filter/i", $a[$field]);
                });
            } else {
                // general filter
                $data = array_filter($data, function ($a) use ($filter) {
                    return (bool) preg_grep("/$filter/i", (array) $a);
                });
            }
        }

        return $data;
    }

    public function filterByDateRange($data, $filter, $field)
    {
        // filter by range
        if (!empty($range = array_filter(explode('|', $filter)))) {
            $filter = $range;
        }

        if (is_array($filter)) {
            foreach ($filter as &$date) {
                // hardcoded date format
                $date = date_create_from_format('m/d/Y', stripcslashes($date));
            }
            // filter by date range
            $data = array_filter($data, function ($a) use ($field, $filter) {
                // hardcoded date format
                $current = date_create_from_format('m/d/Y', $a[$field]);
                $from = $filter[0];
                $to = $filter[1];
                if ($from <= $current && $to >= $current) {
                    return true;
                }

                return false;
            });
        }

        return $data;
    }


    /**
     * @param  array  $data
     *
     * @return array
     */
    public function reformat($data): array
    {
        return array_map(function ($item) {

            return $item;
        }, $data);
    }
    /**
     * arraySearch takes two parameters, $haystack and $needle, and returns an array. It first checks if the $haystack is empty, and if so, returns an empty array. If the $haystack is an object, it converts it to an array. It then iterates through the elements of the $haystack and calls the function arrayContains on each element, passing in the needle as a parameter. If arrayContains returns true for any element, that element is added to the result array which is then returned.
     * @param  array  $haystack Array to search
     * @param  string  $needle   String to search for
     * @return array            Array of results
     */
    public function arraySearch($haystack, $needle): array
    {
        $result = [];
        if (empty($haystack))
            return $result;
        if (is_object($haystack))
            $haystack = $haystack->toArray();

        foreach ($haystack as $element) {
            if ($this->arrayContains($element, $needle))
                $result[] = $element;
        }
        return $result;
    }
    /**
     * arrayContains takes three parameters: $haystack, $needle and $depth. It returns a boolean value. It first checks if the depth is greater than 10 or if the haystack is empty; if either of these conditions are true it returns false. If the haystack is an object it converts it to an array. It then iterates through each element of the haystack; if any of them are arrays it recursively calls itself with increased depth; otherwise it checks if the needle is present in that element using stripos(). If either condition is true it returns true; otherwise false.
     * @param  array  $haystack Array to search
     * @param  string  $needle   String to search for
     * @param  int  $maxDepth  Maximum depth of recursion, default max is 10
     * @param  int  $depth     Depth of recursion, shouldn't be set manually
     * @return bool            True if needle is found, false if not
     * 
     */
    public function arrayContains($haystack, $needle, $maxDepth = 10, $depth = 0): bool
    {

        if ($depth > 10 || empty($haystack))
            return false; //Added stop condition
        if (is_object($haystack))
            $haystack = $haystack->toArray();
        foreach ($haystack as $element) {

            if (is_object($element))
                $element = $element->toArray();
            if (is_array($element)) {
                if ($this->arrayContains($element, $needle, $maxDepth, $depth + 1))
                    return true;
            } elseif (stripos($element, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}