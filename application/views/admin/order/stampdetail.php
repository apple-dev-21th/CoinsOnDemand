<div id="contentHeader">
    <h1>STAMPS Detail</h1>
</div> <!-- #contentHeader -->	
<div class="container">
    <div class="grid-24">	

        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">STAMPS Detail</h3>		
            </div>
            <div class="widget-content">
                <table class="table table-bordered table-striped data-table">
                    <?php
                    $i=1;
                    foreach ($detail as $details) {  
                       $type ='Service -'.$i;
                        echo "<tr class = 'odd gradeX'><td><table>";
                        echo '<div class="widget-header"><span class="icon-list"></span><h3 class="icon chart">'.$type.'</h3></div>';
                        foreach ($details as $key => $value) { ?>
                            <tr class = "odd gradeX">
                            <td width='20%'><?php echo $key; ?></td>
                            <td><?php echo $value; ?></td>
                            </tr>
                          
                  <?php       }
                        echo '</table></td></tr>';
                  $i++;  }
                    ?>
                    </tbody>
                </table>
            </div> <!-- .widget-content -->
        </div> 
    </div>
</div>