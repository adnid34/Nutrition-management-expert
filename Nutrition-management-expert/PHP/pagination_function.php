<!-- PAGINATION -->
<?php

    $row = $DB_con->query($queryCount)->fetchColumn();
    $rows = $row;

    $page_rows = $pageRows; // number of result per page

    $last = ceil($rows/$page_rows);
    if($last < 1){
        $last = 1;
    }

    if(isset($_GET['pr'])){
        $page_rows = $_GET['pr'];
    }
    $pagenum = 1;
    if(isset($_GET['pn'])){
        $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
    }
    if ($pagenum < 1){ 
        $pagenum = 1; 
    } else if ($pagenum > $last) { 
        $pagenum = $last; 
    }

    $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
    $query = $DB_con->prepare($queryResult . " " . $limit); 
    $query->execute(); 

    $pagination = '';
    
        if ($pagenum > 1) {
            $previous = $pagenum - 1;
            $pagination .= '<a class = "page_a page_first" href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'&pr='.$page_rows.'" aria-label="Previous"><span aria-hidden="true">Previous</span></a>';
            for($i = $pagenum-4; $i < $pagenum; $i++){
                if($i > 0){
                    $pagination .= '<a class = "page_a" href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&pr='.$page_rows.'">'.$i.'<span class="sr-only">(current)</span></a> &nbsp; ';
                }
            }
        }else{
            $pagination .= '<a class = "page_a page_first page_disabled" aria-label="Previous"><span aria-hidden="true">Previous</span></a>';
        }


        $pagination .= '<a class = "page_active page_a">'.$pagenum.' </a>';
        for($i = $pagenum+1; $i <= $last; $i++){
            $pagination .= '<a class = "page_a" href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&pr='.$page_rows.'">'.$i.'</a> &nbsp; ';
            if($i >= $pagenum+4){
                break;
            }
        }

        if ($pagenum != $last) {
            $next = $pagenum + 1;
            $pagination .= '<a class = "page_a page_last" href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'&pr='.$page_rows.'" aria-label="Next"><span aria-hidden="true">Next</span>
          </a> ';
        }else{
            $pagination .= '<a class = "page_a page_last page_disabled" aria-label="Next"><span aria-hidden="true">Next</span>
          </a> ';
        }

    echo $pagination;

    
?>
<!-- END PAGINATION -->