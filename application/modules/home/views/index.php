<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home | Vicky Marketing</title>
  <!-- Bootstrap CSS -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicon.png">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">

</head>
<body>

  <!-- Navigation Bar -->

  <nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo base_url(); ?>"> <img src="<?php echo base_url(); ?>assets/logo.png" id="logo" /></a>
    <div class="form-inline">
      <a class="btn btn-outline-secondary" href="<?php echo admin_url(); ?>">Login</a>
    </div>
  </nav>

  <!-- Products Datatable -->
  <div class="container mt-5">
    <h2 class="mb-4">Products List</h2>
    <div class="row">
      <div class="col-lg-12 mb-3">
        <form class="form-inline" action="<?php echo base_url(); ?>home/products" method="get">
          <div class="form-group">
            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Enter a keyword" value="<?php echo @$_GET['keyword']; ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="productId" id="productId" placeholder="Enter a product ID" value="<?php echo @$_GET['productId']; ?>">
          </div>
          <div class="form-group">
            <select class="form-control" name="market" id="market">
              <option value="" selected>Choose a market</option>
              <?php foreach (get_markets() as $market) { ?>
                <option value='<?php echo $market['id']; ?>' <?php if($market['id'] == @$_GET['market']) { ?> selected <?php } ?>> <?php echo $market['name']; ?> </option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <select class="form-control" name="productType" id="productType">
              <option value="" selected>Choose a product type</option>
              <?php foreach (get_producttypes() as $producttype) { ?>
                <option value='<?php echo $producttype['id']; ?>' <?php if($producttype['id'] == @$_GET['productType']) { ?> selected <?php } ?>> <?php echo $producttype['name']; ?> </option>
              <?php } ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Search Now</button>
        </form>
      </div>
    </div>

    <?php if(count($products) > 0) { ?>

      <?php if (isset($links)) { ?>
        <nav class="mb-2" aria-label="Page navigation example">
          <?php echo $links ?>
        </nav>
      <?php } ?>

      <ul class="list-group shadow mb-3">

        <?php foreach ($products as $product) { ?>

          <li class="list-group-item">

            <form action="" type="post" id="uploadimage<?php echo $product['id']; ?>">

              <div class="media align-items-lg-center flex-column flex-lg-row p-3">

                <div class="media-body order-2 order-lg-1">
                  <h5 class="mt-0 font-weight-bold mb-2">
                    <?php echo $product['keyword']; ?>
                  </h5>

                  <p class="font-italic text-muted mb-0 small"><?php echo $product['sale_limit']; ?> daily sale limit | <?php echo $product['overall_sale_limit']; ?> Total sale limit</p>

                  <div class="d-flex align-items-center justify-content-between mt-1">

                    <h6 class="font-weight-bold my-2">
                      <?php echo $product['market_name']; ?>
                    </h6>

                    <ul class="list-inline small">

                      <li class="list-inline-item m-0">
                        Product ID = <i class="text-success"><?php echo $product['id']; ?></i>
                      </li>

                      <input type="hidden" name="hidden_name" id="hidden_name<?php echo $product['id']; ?>" value="<?php echo $product['keyword']; ?>">

                      <input type="hidden" name="hidden_id" id="hidden_id<?php echo $product['id']; ?>" value="<?php echo $product['id']; ?>">

                    </ul>

                  </div>

                </div>

                <?php if(!empty($product['picture'])) { ?>

                  <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $product['picture']; ?>" id="<?php echo $product['id']; ?>" alt="" style="cursor:pointer; width: 100px;" onclick="showimage(this.id)" class="ml-lg-5 order-1 order-lg-2" />

                <?php } elseif(!empty($product['amz_picture'])) { ?>

                  <img src="<?php echo base_url(); ?>assets/pictures/<?php echo $product['amz_picture']; ?>" id="<?php echo $product['id']; ?>" alt="" style="cursor:pointer; width: 100px;" onclick="showimage(this.id)" class="ml-lg-5 order-1 order-lg-2" />

                <?php } ?>

              </div>

            </form>
          </li>

        <?php } ?>

      </ul>

    <?php } else { ?>
      <p class="text-danger">Products not found.</p>
    <?php } ?>

    <?php if(!empty($_GET)) { ?>
      <div>
        <a href="<?php echo base_url(); ?>" class="btn btn-info mb-3">Clear Search</a>
      </div>
    <?php } ?>

    <?php if (isset($links)) { ?>
      <nav class="mb-5" aria-label="Page navigation example">
        <?php echo $links ?>
      </nav>
    <?php } ?>

  </div>

  <div style="clear: both;"></div>

  <footer class="bg-light pt-5 pb-5">
    <div class="container">
      <p class="float-right">
        <a href="#">Back to top</a>
      </p>
      <p class="font-weight-bold">If you have any query please contact us at </p>
      <p><b>Email:</b> <a href="mailto:Joblessali4@gmail.com">Joblessali4@gmail.com</a></p>
      <p><b>Phone:</b> <a href="tel:+923024020551">+923024020551</a></p>
      <p>© <?php echo date('Y') ?> Vicky Marketing</p>
    </div>
  </footer>

  <div id="pic_myModal" class="pic_modal">
    <span class="pic_close">&times;</span>
    <img class="pic_modal-content" id="img01">
    <div id="caption"></div>
  </div>

  <!-- Bootstrap JS -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript">

    $('.page-item a').addClass("page-link");

    function showimage(id){
      var modal = document.getElementById('pic_myModal');
      var img = document.getElementById(id);
      var comp_img=img.src;
      var replaced_image;
      replaced_image = comp_img.replace("s.jpg", "l.jpg");
      if(replaced_image.includes("s.png")){
        replaced_image = comp_img.replace("s.png", "l.png");
      }
      var modalImg = document.getElementById("img01");
      var captionText = document.getElementById("caption");
      modal.style.display = "block";
      modalImg.src = replaced_image;
      captionText.innerHTML = img.alt;
      var span = document.getElementsByClassName("pic_close")[0];
      span.onclick = function() {
        modal.style.display = "none";
      }
    }
  </script>
</body>
</html>