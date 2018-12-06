<?php
    function getAllCountries() {
        $conn = mysqli_connect('localhost','root','','countriessearch');
        $query = 'select country, region, population, area, density
         from countries order by country;';
        $result = mysqli_query($conn,$query);
        $countries = array();
        $countries = mysqli_fetch_all($result);
        // Free result set
        mysqli_free_result($result);
        mysqli_close($conn);
        return $countries;
    }

    function getPaginationCountries($page, $lineCount, $search, $sort) {
        $conn = mysqli_connect('localhost','root','','countriessearch');
        $query = 'select country, region, population, area, density 
        from countries'; 
        if($search!='') {
            $query.=' where '.getSearchClause($search);
        }
        $query.=' order by '.getOrderby($sort).' LIMIT '.($page-1)*$lineCount.', '.$lineCount.';';
        $result = mysqli_query($conn,$query);
        $countries = array();
        $countries = mysqli_fetch_all($result);
        // Free result set
        mysqli_free_result($result);
        mysqli_close($conn);
        return $countries;
    }

    function getOrderby($sort){
        switch($sort) {
            case 1:
                return 'country';
            case 2:
                return 'region';
            case 3:
                return 'population';
            case 4:
                return 'area';
            case 5:
                return 'density';
            case -1:
                return 'country desc';
            case -2:
                return 'region desc';
            case -3:
                return 'population desc';
            case -4:
                return 'area desc';
            case -5:
                return 'density desc';
            default:
                return 'country';   
        }
    }

    function countAllCountries($search) {
        $conn = mysqli_connect('localhost','root','','countriessearch');
        $query = 'select count(1)
         from countries'; 
        if($search!='') {
            $query.=' where '.getSearchClause($search).';';
        } else {
            $query.=';';
        }
        $result = mysqli_query($conn,$query);
        $count = mysqli_fetch_row($result)[0];
        // Free result set
        mysqli_free_result($result);
        mysqli_close($conn);
        return $count;
    }

    function getPagination($currPage, $totalpages, $totalrecords, $action, $search) {
        $pagination = '';
        if($currPage>1) {
            $pagination = '<a href="'.$action.'?page='.($currPage-1).'&total='.$totalrecords.'&search='
            .$search.'"><-</a>';
        }
        for($i=1;$i<=$totalpages;$i++) {
            if($i==$currPage) {
                $pagination.='<a>'.$i.'</a>'; 
            } else {
                $pagination.='<a href="'.$action.'?page='.$i.'&total='.$totalrecords.'&search='
                .$search.'">'.$i.'</a>';
            }
        }
        if($currPage<$totalpages) {
            $pagination.= '<a href="'.$action.'?page='.($currPage+1).'&total='.$totalrecords.'&search='
            .$search.'">-></a>';
        }
        return $pagination;
    }

    function getSearchClause($search) {
        $arrSearch = array(',',';');
        $tmpSearch = str_replace($arrSearch,' ',$search);
        $tmpArr = explode(' ', $tmpSearch);
        //remove empty values and keys
        $tmpArr = array_values(array_filter($tmpArr));
        $clause = '';
        for($i=0;$i<sizeof($tmpArr);$i++) {
            if($i>0) {
                $clause.=' or ';
            }
            $clause.='country like \'%'.$tmpArr[$i].'%\' or region like \'%'.$tmpArr[$i].'%\'';
        }
        return $clause;
    }

    function getHeaderCountries($action,$search,$previousSort) {
        return '<tr>
            <th><a href="'.$action.'?search='.$search.'&sort='.($previousSort==1?-1:1).'">Country</a></th>
            <th><a href="'.$action.'?search='.$search.'&sort='.($previousSort==2?-2:2).'">Region</th>
            <th><a href="'.$action.'?search='.$search.'&sort='.($previousSort==3?-3:3).'">Population</th>
            <th><a href="'.$action.'?search='.$search.'&sort='.($previousSort==4?-4:4).'">Area</th>
            <th><a href="'.$action.'?search='.$search.'&sort='.($previousSort==5?-5:5).'">Density</th>
            </tr>';
    }
?>