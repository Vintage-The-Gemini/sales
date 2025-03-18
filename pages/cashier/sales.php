<?php
require_once('auth.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SKYNET IMS</title>

  <link rel="shortcut icon" href="logo.jpg">

  <!-- CSS Styles (Use direct file paths) -->
  <style>
    /* Basic styling in case external CSS fails to load */
    body {
      background-color: #f8f8f8;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .navbar {
      background-color: #337ab7;
      border-color: #2e6da4;
      color: white;
    }

    .navbar-brand {
      color: white !important;
    }

    #page-wrapper {
      padding: 20px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      padding: 8px;
      border: 1px solid #ddd;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #f9f9f9;
    }

    .btn-primary {
      background-color: #337ab7;
      border-color: #2e6da4;
      color: white;
      padding: 6px 12px;
      cursor: pointer;
    }

    .btn-danger {
      background-color: #d9534f;
      border-color: #d43f3a;
      color: white;
      padding: 6px 12px;
      cursor: pointer;
    }

    .form-control {
      display: block;
      width: 100%;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
  </style>

  <!-- Bootstrap Core CSS -->
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Facebox CSS -->
  <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

  <!-- jQuery and Facebox -->
  <script src="lib/jquery.js" type="text/javascript"></script>
  <script src="src/facebox.js" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage: 'src/loading.gif',
        closeImage: 'src/closelabel.png'
      })
    })
  </script>

</head>

<body>

  <?php include('navfixed.php'); ?>

  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Payment | <?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?> </h1>
      </div>

      <div id="maintable">
        <div style="margin-top: -19px; margin-bottom: 21px;">
        </div>

        <!-- Enable error reporting for debugging -->
        <?php
        // Uncomment these lines to see errors
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        ?>

        <form action="incoming.php" method="post" class="form-group">
          <input type="hidden" name="pt" class="form-control" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" />
          <input type="hidden" name="invoice" class="form-control" value="<?php echo isset($_GET['invoice']) ? $_GET['invoice'] : ''; ?>" />

          <div class="panel panel-primary">
            <div class="panel-heading">Add Product to Sale</div>
            <div class="panel-body">
              <label>Select a Product</label><br />
              <select name="product" style="width:100%;" class="form-control">
                <option value="">-- Select Product --</option>
                <?php
                include('connect.php');
                try {
                  $result = $db->prepare("SELECT * FROM products");
                  $result->execute();
                  for ($i = 0; $row = $result->fetch(); $i++) {
                ?>
                    <option value="<?php echo $row['product_code']; ?>"
                      <?php
                      if ($row['qty_left'] == 0) {
                        echo 'disabled';
                      }
                      ?>>
                      <?php echo $row['product_code']; ?>
                      - <?php echo $row['product_name']; ?>
                      - <?php echo $row['description_name']; ?>
                      - Qty: <?php echo $row['qty_left']; ?>
                    </option>
                <?php
                  }
                } catch (PDOException $e) {
                  echo "Error: " . $e->getMessage();
                }
                ?>
              </select>
              <br />

              <div class="row">
                <div class="col-md-4">
                  <label>Number of Items</label>
                  <input type="number" name="qty" value="1" min="1" class="form-control" autocomplete="off" />
                </div>
                <div class="col-md-4">
                  <label>Discount</label>
                  <input type="text" name="discount" value="0" class="form-control" autocomplete="off" />
                </div>
                <div class="col-md-4">
                  <label>Value Add Tax</label>
                  <input type="text" name="vat" value=".12" class="form-control" autocomplete="off" />
                </div>
              </div>
              <br>
              <input type="submit" class="btn btn-primary" value="Add Product" />
            </div>
          </div>
        </form>

        <div class="panel panel-default">
          <div class="panel-heading">Current Order Items</div>
          <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Product Code</th>
                  <th>Brand Name</th>
                  <th>Description</th>
                  <th>Category</th>
                  <th>Qty</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $id = isset($_GET['invoice']) ? $_GET['invoice'] : '';
                include('connect.php');
                $total = 0;
                try {
                  $result = $db->prepare("SELECT * FROM sales_order WHERE invoice= :userid");
                  $result->bindParam(':userid', $id);
                  $result->execute();
                  $count = $result->rowCount();

                  if ($count > 0) {
                    for ($i = 0; $row = $result->fetch(); $i++) {
                ?>
                      <tr class="record">
                        <td><?php echo $row['product']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo isset($row['dname']) ? $row['dname'] : ''; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td>
                          <?php
                          $ppp = $row['price'];
                          echo number_format($ppp, 2);
                          ?>
                        </td>
                        <td>
                          <?php
                          $ddd = $row['discount'];
                          echo number_format($ddd, 2);
                          ?>
                        </td>
                        <td>
                          <?php
                          $dfdf = $row['amount'];
                          echo number_format($dfdf, 2);
                          $total += $dfdf;
                          ?>
                        </td>
                        <td>
                          <a href="delete.php?id=<?php echo $row['transaction_id']; ?>&invoice=<?php echo $_GET['invoice']; ?>&dle=<?php echo $_GET['id']; ?>&qty=<?php echo $row['qty']; ?>&code=<?php echo $row['product']; ?>" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash"></i> Delete
                          </a>
                        </td>
                      </tr>
                    <?php
                    }
                  } else {
                    ?>
                    <tr>
                      <td colspan="9" align="center">No items added yet</td>
                    </tr>
                <?php
                  }
                } catch (PDOException $e) {
                  echo "Error: " . $e->getMessage();
                }
                ?>

                <?php if ($count > 0): ?>
                  <tr>
                    <td colspan="7" align="right"><strong>Total:</strong></td>
                    <td><strong><?php echo number_format($total, 2); ?></strong></td>
                    <td></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>

            <?php if ($count > 0): ?>
              <div class="text-center">
                <a rel="facebox" class="btn btn-success btn-lg" href="checkout.php?pt=<?php echo $_GET['id'] ?>&invoice=<?php echo $_GET['invoice'] ?>&total=<?php echo $total ?>&cashier=<?php echo $session_cashier_name ?>">
                  <i class="fa fa-check-circle"></i> Check Out
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <!-- /#page-wrapper -->

  <!-- jQuery -->
  <script src="../../vendor/jquery/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

  <!-- Custom Theme JavaScript -->
  <script src="../../dist/js/sb-admin-2.js"></script>

</body>

</html>