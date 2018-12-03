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

    function getPaginationCountries($page, $lineCount, $search) {
        $conn = mysqli_connect('localhost','root','','countriessearch');
        $query = 'select country, region, population, area, density 
        from countries'; 
        if($search!='') {
            $query.=' where country like \'%'.$search.'%\' or region like \'%'.$search.'%\'';
        }
        $query.=' order by country LIMIT '.($page-1)*$lineCount.', '.$lineCount.';';
        $result = mysqli_query($conn,$query);
        $countries = array();
        $countries = mysqli_fetch_all($result);
        // Free result set
        mysqli_free_result($result);
        mysqli_close($conn);
        return $countries;
    }

    function countAllCountries($search) {
        $conn = mysqli_connect('localhost','root','','countriessearch');
        $query = 'select count(1)
         from countries'; 
        if($search!='') {
            $query.=' where country like \'%'.$search.'%\' or region like \'%'.$search.'%\';';
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
            $pagination = '<a href="'.$action.'?page='.($currPage-1).'&total='.$totalrecords.'
            &search='.$search.'"><-</a>';
        }
        for($i=1;$i<=$totalpages;$i++) {
            if($i==$currPage) {
                $pagination.='<a>'.$i.'</a>'; 
            } else {
                $pagination.='<a href="'.$action.'?page='.$i.'&total='.$totalrecords.'
                &search='.$search.'">'.$i.'</a>';
            }
        }
        if($currPage<$totalpages) {
            $pagination.= '<a href="'.$action.'?page='.($currPage+1).'&total='.$totalrecords.'
            &search='.$search.'">-></a>';
        }
        return $pagination;
    }
?>