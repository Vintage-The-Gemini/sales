<?php

?>
<!-- Modal for Adding a Product -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Product</h4>
            </div>
            <div class="modal-body">
                <form action="saveproduct.php" method="post" class="form-group">
                    <div id="ac">
                        <span>Category: </span>
                        <select name="categ" class="form-control" style="margin-bottom: 15px;">
                            <option>Select Category</option>
                            <option>Noodles</option>
                            <option>Canned Goods</option>
                            <option>Shampoo</option>
                            <option>Bath Soap</option>
                            <option>Crackers</option>
                        </select>
                        <span>Product Code: </span><input type="text" name="code" value="<?php echo $pcode ?>" class="form-control" style="margin-bottom: 15px;" required />
                        <span>Brand Name: </span><input type="text" name="bname" class="form-control" style="margin-bottom: 15px;" required />
                        <span>Description Name: </span><input type="text" name="dname" class="form-control" style="margin-bottom: 15px;" required />
                        <span>Product Unit: </span>
                        <select name="unit" class="form-control" style="margin-bottom: 15px;">
                            <option>Select Product Unit</option>
                            <option>Per Pieces</option>
                            <option>Per Box</option>
                            <option>Per Pack</option>
                        </select>
                        <span>Cost: </span><input type="text" name="cost" class="form-control" style="margin-bottom: 15px;" required />
                        <span>SRP: </span><input type="text" name="price" class="form-control" style="margin-bottom: 15px;" required />
                        <span>Supplier: </span>
                        <select name="supplier" class="form-control" style="margin-bottom: 15px;" required>
                            <option>Select Supplier</option>
                            <?php
                            include('connect.php');
                            $result = $db->prepare("SELECT * FROM supliers");
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) {
                            ?>
                                <option><?php echo $row['suplier_name']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span>Quantity: </span><input type="text" name="qty" class="form-control" style="margin-bottom: 15px;" required />
                        <span>Date Delivered: </span><input type="date" name="date_del" class="form-control" style="margin-bottom: 15px;" required />
                        <span>Expiration Date: </span><input type="date" name="ex_date" class="form-control" style="margin-bottom: 15px;" required />
                        <div class="modal-footer" style="margin-top: 20px;">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>