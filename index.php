<?php
    $title = 'Search Countries';
    include_once('header.php');
    include_once('menu.php');
    require_once('countriescs.php');

    $page = (isset($_GET['page']) ? $_GET['page'] : 1);
    $search = (isset($_GET['search']) ? $_GET['search'] : '');
    $total = (isset($_GET['total']) ? $_GET['total'] : countAllCountries($search));
    $linecount = 10;
?>

    <form method="get" action="<?php $_SERVER['PHP_SELF']?>" class="search">
        <label for="search">Search</label>
        <input type="text" name="search" id="search" value="<?php echo $search;?>">
        <input type="submit" name="submit" id="submit" value="Search">
    </form>

<?php
    $countries = getPaginationCountries($page, $linecount, $search);
    echo '<label>Total:'.$total.'</label>';
    echo '<table><tr><th>Country</th><th>Region</th><th>Population</th><th>Area</th><th>Density</th></tr>';
    foreach($countries as $country) {
        echo '<tr><td>'.$country[0].'</td><td>'.$country[1].'</td>
        <td>'.$country[2].'</td><td>'.$country[3].'</td>
        <td>'.$country[4].'</td></tr>';
    }
    echo '</table>';
    $totalpages = ceil($total/$linecount);
    echo '<div class="pagination">';
    echo getPagination($page, $totalpages, $total, $_SERVER['PHP_SELF'], $search);
    echo '</div>';
    include_once('footer.php');
    $totalpages = 0;
?>

