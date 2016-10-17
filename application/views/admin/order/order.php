<style>

    .widget-header > form {
        width: 75%;
    }
    .pull-right {
    float: right !important;
}
.pagination {
    border-radius: 4px;
    display: inline-block;
    margin: 20px 0;
    padding-left: 0;
    float: right;
}
.pagination > li {
    display: inline;
}
.button1 {
   border-top: 1px solid #96d1f8;
   background: #65a9d7;
   background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#65a9d7));
   background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
   background: -moz-linear-gradient(top, #3e779d, #65a9d7);
   background: -ms-linear-gradient(top, #3e779d, #65a9d7);
   background: -o-linear-gradient(top, #3e779d, #65a9d7);
   padding: 4px 7px;
   -webkit-border-radius: 8px;
   -moz-border-radius: 8px;
   border-radius: 8px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: white;
   font-size: 11px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;
   }
.button1:hover {
   border-top-color: #28597a;
   background: #28597a;
   color: #ccc;
   }
.button1:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }

</style>

<div id="contentHeader">
    <h1>Manage Order</h1>
</div> <!-- #contentHeader -->	
<div class="container">
    <form id="data1" method="post" accept-charset="utf-8" enctype="multipart/form-data" class=""  action="<?php echo base_url() . 'admin/order/manageorder/'; ?>">
    <div class="grid-24">	
        <?php $this->load->view('admin/include/flash'); ?>
        <?php if (validation_errors()) { ?>
            <div class="notify notify-error">
                <a href="javascript:;" class="close">×</a>
                <h3>Error Notifty</h3>
                <?php echo validation_errors(); ?>
            </div>
            <?php
        }
        ?>
        <div class="widget widget-table">
            <div class="widget-header">
                <span class="icon-list"></span>
                <h3 class="icon chart">List of Orders's</h3>
                
                    <div style="width:120px; float: left;">
                        <label for="cardtype">Per Page</label>
<?php $limit1= $this->session->userdata('limit1'); ?>
                        <select id="limit" name="limit" size="1" class="m-wrap xsmall">
                            <option <?php if ($limit1 == 10) echo 'selected' ?>  value="10">10</option>
                            <option <?php if ($limit1 == 25) echo 'selected' ?>  value="25">25</option>
                            <option <?php if ($limit1 == 50) echo 'selected' ?>  value="50">50</option>
                            <option <?php if ($limit1 == 100) echo 'selected' ?>  value="100">100</option>
                        </select>

                    </div>

                    <div style="max-width:500px; float: left; margin-left: 10px;">
                        <div style="float:left">
                            <a href="javascript:sendExportList('<?php echo base_url() . 'admin/order/exportselection/'; ?>')" class="button1""><img src="<?php echo base_url() ?>assets/images/pdf.png" height="15" width="15"> Export selected</a>
                            <a href="javascript:;" id="downlaod" class="button1"> Download All</a>
                            <a href="javascript:;" id="combine" class="button1"> Combine JIGS</a>
                            <a href="javascript:;" id="printjig" class="button1"> Print JIGS</a>
                            <a href="javascript:;" id="printorder" class="button1"> Print Orders</a>
                            <img id="load-coin" style="display:none" src='<?php echo base_url(); ?>assets/images/loaders/facebook.gif'>
                        </div>
                        <div style="float:right;width:100px;margin-top: -6px;">
                            <a href='#' target="_blank" id="pdf-href"><span id='download-text' style="display:none;color:blueviolet;font-weight:bold"> Download</span></a>
                        </div>
                    </div>
<!--                <div style="max-width:500px; float: left; margin-left: 10px;">
                    <button type="button" value="download" id="downlaod"  >Download ALL</button>
                    <button type="button" value="download" id="combine"  >Combine JIGS </button>
                    <button type="button" value="download" id="printjig"  >Print JIGS </button>
                    <button type="button" value="download" id="printorder"  >Print Orders </button>
                </div>-->
  <div style="float: left; margin-left: 10px;">
                        <label for="cardtype">Change Status As</label>

                        <select  name="status" id="status" size="1" class="m-wrap xsmall">
                            <option value="">-Option-</option>
                            <option value="Completed">Completed</option>
                            <option value="Pending">Pending</option>
                            <option value="Under Progress"> Under Progress</option>
                        </select>

                    </div>
                
            </div>
            <!-- .field-group -->
            <div class="widget-content">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Check <br/>
                                <input type="checkbox" style="opacity: 1;" class="group-checkable" data-set="#sample_1 .checkboxes" name='checkall' id='checkall' class="checkall" onchange="checkAll(this)"></th>
                            <th>Order No.</th>
                            <th> Customer Name</th>
                            <th> Transaction ID</th>
<!--       <th> Payment Status</th>-->
                            <th> Amount Paid</th>
                            <th> Order Status</th>
                            <th> Order Date</th>
                            <th> View Order </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($order as $orders) {
                            ?>
                            <tr class="gradeA" orderID="<?php echo $orders['order_id']; ?>">
                                <td class="text-center"><input type="checkbox" style="opacity: 1;" name="chk[]" class="checkboxes tobechecked" value="<?php echo $orders['order_id']; ?>"></td>
                                <td class="text-center"># <?php echo $orders['order_id']; ?></td>
                                <td class="text-center"> <?php echo $orders['fn'] . '&nbsp' . $orders['ln']; ?> </td>
                                <td>  <?php echo $orders['transaction_id']; ?></td>

                                <td class="text-center"> <?php
                        if ($orders['total_paid'] == '0.00') {
                            echo "Free";
                        } else {
                            echo $orders['total_paid'];
                        }
                            ?>
                                </td>

                                <td class="text-center "> 
                                    <?php
                                    if ($orders['checkout_status'] == 'pending') {
                                        echo 'Payment Pending';
                                    } else {
                                        ?>

                                        <form name="order1" action="<?php echo base_url(); ?>admin/order/changestatus/<?php echo $orders['order_id']; ?>/manage" method="post">

                                            <select name="orderstatus" onchange="this.form.submit()" >
                                                <option value="Completed" <?php
                                if ($orders['order_status'] == 'Completed') {
                                    echo 'selected="selected"';
                                }
                                        ?>>Completed</option>
                                                <option value="Pending" <?php
                                                if ($orders['order_status'] == 'Pending') {
                                                    echo 'selected="selected"';
                                                }
                                        ?>>Pending</option>
                                                <option value="Under Progress" <?php
                                                if ($orders['order_status'] == 'Under Progress') {
                                                    echo 'selected="selected"';
                                                }
                                        ?>> Under Progress</option>
                                            </select>
                                        </form>

                                        <?php
                                        //echo $orders['order_status']; 
                                    }
                                    ?></td>

                                <td> <?php echo date('m/d/Y g:i a', strtotime($orders['order_date'])); ?></td>
                                <td class="text-center"> <a href="<?php echo base_url(); ?>admin/order/orderdetail/<?php echo $orders['order_id']; ?>" > View Order  </a></td>
                                <td  class="text-center">
                                    <a onclick="return confirm('Are you sure! You want  to delete this Order ?');"  href="<?php echo base_url(); ?>admin/order/deleteorder/<?php echo $orders['order_id']; ?>" onClick="return confirm('Delete this order?')" ><img src="<?php echo base_url(); ?>assets/images/delete.png" title="Delete Customer" /> </a> 
                                </td>

                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div> <!-- .widget-content -->
        </div> 
    </div>
        </form>
</div>
 <script>
       function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
  $('#downlaod').click(function() {
      $("#data1").attr("action", "<?php echo base_url() . 'admin/order/downloadallpdf/';?>"); 
      $( "#data1" ).submit();
  });
  $('#combine').click(function() {
      $("#data1").attr("action", "<?php echo base_url() . 'admin/order/combinecoins/';?>"); 
      $( "#data1" ).submit();
  });
  $('#printjig').click(function() {
      $("#data1").attr("action", "<?php echo base_url() . 'admin/order/printjigs/';?>"); 
      $( "#data1" ).submit();
  });
  $('#printorder').click(function() {
      $("#data1").attr("action", "<?php echo base_url() . 'admin/order/printOrder/';?>"); 
      $( "#data1" ).submit();
  });
  
  $('#status').change(function(){
      $("#data1").attr("action", "<?php echo base_url() . 'admin/order/changebulkstatus/';?>"); 
      $( "#data1" ).submit();
  });
    $('#limit').change(function(){
      $("#data1").attr("action", "<?php echo base_url() . 'admin/order/manageorder/';?>"); 
      $( "#data1" ).submit();
  });
  
        </script>