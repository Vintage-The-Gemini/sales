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

    <link rel="shortcut icon" href="logoc.jpg">

    <!-- jQuery - ONLY LOAD ONE VERSION -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Facebox CSS -->
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

    <!-- Print CSS -->
    <link rel="stylesheet" type="text/css" media="print" href="print.css" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
    function productcode()
    {
        $chars = "003232303232023232023456789";
        srand((float)microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }
    $pcode = 'P-' . productcode();
    ?>

    <!-- Facebox JS - Use the already loaded jQuery -->
    <script src="src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('a[rel*=facebox]').facebox({
                loadingImage: 'src/loading.gif',
                closeImage: 'src/closelabel.png'
            });
        });
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include('navfixed.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">PRODUCT LIST</h1>
            </div>
            <div id="maintable">
                <div style="margin-top: -19px; margin-bottom: 21px;">
                    <a href="#add" data-toggle="modal" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Product
                    </a>

                    <!-- Include the Add Product Modal -->
                    <?php include 'addproduct.php'; ?>

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Brand Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Cost</th>
                                <th>SRP</th>
                                <th>Supplier</th>
                                <th width="10%">Quantity Left</th>
                                <th width="10%">Product Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            function formatMoney($number, $fractional = false)
                            {
                                if ($fractional) {
                                    $number = sprintf('%.2f', $number);
                                }
                                while (true) {
                                    $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
                                    if ($replaced != $number) {
                                        $number = $replaced;
                                    } else {
                                        break;
                                    }
                                }
                                return $number;
                            }

                            include('connect.php');
                            $result = $db->prepare("SELECT * FROM products ORDER BY product_name");
                            $result->execute();
                            for ($i = 0; $row = $result->fetch(); $i++) {
                            ?>
                                <tr class="record">
                                    <td><?php echo $row['product_code']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['description_name']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td align="right"><?php
                                                        $pcost = $row['cost'];
                                                        echo formatMoney($pcost, true);
                                                        ?></td>
                                    <td align="right"><?php
                                                        $pprice = $row['price'];
                                                        echo formatMoney($pprice, true);
                                                        ?></td>
                                    <td><?php echo $row['supplier']; ?></td>
                                    <td align="right"><?php echo $row['qty_left']; ?></td>
                                    <td><?php echo $row['unit']; ?></td>
                                    <td>
                                        <a rel="facebox" class="btn btn-primary btn-sm" href="editproduct.php?id=<?php echo $row['product_id']; ?>">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                        <a href="#" data-id="<?php echo $row['product_id']; ?>" data-name="<?php echo $row['product_name']; ?>" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <a href="" onclick="window.print()" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                    <a href="product_exp.php" class="btn btn-primary"><i class="fa fa-calendar"></i> View Product Expiration</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

    <!-- Product deletion script with SweetAlert -->
    <script type="text/javascript">
        $(function() {
            $(".delete-btn").click(function() {
                // Save the link in a variable called element
                var element = $(this);
                // Find the id and name of the product
                var del_id = element.data("id");
                var product_name = element.data("name");

                // Show SweetAlert2 confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You're about to delete product '" + product_name + "'. This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Built a url to send
                        var info = 'id=' + del_id;

                        // Send delete request
                        $.ajax({
                            type: "GET",
                            url: "deleteproduct.php",
                            data: info,
                            success: function() {
                                // Show success message
                                Swal.fire(
                                    'Deleted!',
                                    'The product has been deleted.',
                                    'success'
                                );

                                // Animate the row removal
                                element.parents(".record").animate({
                                    backgroundColor: "#fbc7c7"
                                }, "fast").animate({
                                    opacity: "hide"
                                }, "slow");
                            },
                            error: function() {
                                // Show error message
                                Swal.fire(
                                    'Error!',
                                    'There was a problem deleting the product.',
                                    'error'
                                );
                            }
                        });
                    }
                });

                return false;
            });
        });
    </script>
</body>

</html>