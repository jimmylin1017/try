<div class="container">
	<div class="header clearfix">
        <nav class="nav nav-pills justify-content-end">
        	<a class="nav-link active" href="#">Home</a>
            <?php
            
                $tableName = "web_topmenu";
                $myPDO = MyPDO::getInstance();
                $result = $myPDO->searchAll($tableName);
                
                foreach($result as $row) {
                    echo '<a class="nav-link" href="' . $row['link'] . '">' . $row['column_name'] . '<span class="sr-only">(current)</span></a>';
                }
            
            ?>
        </nav>
    </div>
</div>

<style type="text/css">
.nav {
	margin-bottom: 1.5rem;
}
</style>