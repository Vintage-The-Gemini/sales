<?php
include('connect.php');
$id = $_GET['id'];
$result = $db->prepare("SELECT * FROM products WHERE product_id= :userid");
$result->bindParam(':userid', $id);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
?>

	<div class="container" style="width: 100%;">
		<div class="row">
			<div class="col-md-12">
				<form action="saveeditproduct.php" method="post" class="form-group">
					<div id="ac">
						<input type="hidden" name="memi" value="<?php echo $id; ?>" />

						<div class="form-group">
							<label>Product Code:</label>
							<input type="text" name="code" class="form-control" value="<?php echo $row['product_code']; ?>" />
						</div>

						<div class="form-group">
							<label>Brand Name:</label>
							<input type="text" name="bname" class="form-control" value="<?php echo $row['product_name']; ?>" />
						</div>

						<div class="form-group">
							<label>Description Name:</label>
							<input type="text" name="dname" class="form-control" value="<?php echo $row['description_name']; ?>" />
						</div>

						<div class="form-group">
							<label>Cost:</label>
							<input type="text" name="cost" class="form-control" value="<?php echo $row['cost']; ?>" />
						</div>

						<div class="form-group">
							<label>Price:</label>
							<input type="text" name="price" class="form-control" value="<?php echo $row['price']; ?>" />
						</div>

						<div class="form-group">
							<label>Supplier:</label>
							<select name="supplier" class="form-control">
								<option><?php echo $row['supplier']; ?></option>
								<?php
								$results = $db->prepare("SELECT * FROM supliers");
								$results->execute();
								for ($i = 0; $rows = $results->fetch(); $i++) {
								?>
									<option><?php echo $rows['suplier_name']; ?></option>
								<?php
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label>Category:</label>
							<select name="categ" class="form-control">
								<option><?php echo $row['category']; ?></option>
								<option>Noodles</option>
								<option>Canned Goods</option>
								<option>Shampoo</option>
								<option>Bath Soap</option>
							</select>
						</div>

						<div class="form-group">
							<button class="btn btn-primary btn-block" type="submit">Update Product</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
}
?>