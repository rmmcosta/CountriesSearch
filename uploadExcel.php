<?php
    $title = 'Upload Countries';
    include_once('header.php');
    include_once('menu.php');
?>

    <form method="post" action="submitExcel.php" class="uploadFile" enctype="multipart/form-data">
        <fieldset>
            <legend>Upload</legend>
            <label for="excel"><i class="fa fa-file-excel"></i>Excel</label>
            <input type="file" name="excel" id="excel" accept=".xls,.xlsx">
            <input type="submit" name="submit" value="Upload">
        </fieldset>
    </form>

<?php
    include_once('footer.php');
?>