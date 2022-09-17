
<!-- add cart item send post data with session  -->


<!-- add cart post.php with session  -->


<?php
  if(isset($_POST['add_to_cart'])){
      $_SESSION['cart'][] = array(
          'product_id' => $_POST['product_id'],
          'phar_email' => $_POST['phar_email'],
          'product_name' => $_POST['product_name'],
          'product_image' => $_POST['product_image'],
          'total_price' => $_POST['total_price'],
          'product_qantity' => $_POST['product_qantity'],
      );
      $_SESSION['addcart'] = $_POST['product_name'].' Add To Cart';
      $p_id = $_POST['product_id'];
      header('Location: product.php'.'?product&id='.$p_id);

  }
  if(isset($_POST['direct_buy'])){
      $_SESSION['cart'][] = array(
          'product_id' => $_POST['product_id'],
          'phar_email' => $_POST['phar_email'],
          'product_name' => $_POST['product_name'],
          'product_image' => $_POST['product_image'],
          'product_price' => $_POST['product_price'],
          'total_price' => $_POST['total_price'],
          'product_qantity' => $_POST['product_qantity'],
      );
      header('Location: add-cart.php');
  }


  if(isset($_GET['empty'])){
      unset($_SESSION['cart']);
      header('Location: add-cart.php');
  }

  if(isset($_GET['remove'])){
      $id = $_GET['remove'];
      foreach($_SESSION['cart'] as $k => $part){
          if($id == $part['product_id']){
              unset($_SESSION['cart'][$k]);
              header('Location: add-cart.php');
          }
      }

  }
?>


<!-- add cart item view with session  -->

 <?php if(isset($_SESSION['cart'])) :?>
    <?php foreach($_SESSION['cart'] as $k => $item) :?>
        <tr>
            <td>
                <?php
                $product_id = $item['product_id'];
                    $products = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM drugs_pharmacy WHERE id = '$product_id'"))        
                ?>
                <a class="product-details-main single-product-main" href="https://www.evna.care/product.php?product&id=<?=$products['id'];?>">
                    <div class="product-img single-product-view">
                        <img src="https://www.evna.care/uploads/drugs_product/<?=$products['image'];?>" class="img-fluid" alt="">
                    </div>
                    <div class="product-details">
                        <h5><?=$products['name'];?></h5>
                        <?php 
                            if($products['measurement'] != NULL){ ?>
                                <p class="mg">Mg: <?=$products['measurement'];?></p>
                            <?php }
                        ?>

                        <p class="price"><?php echo (isset($_SESSION['fr'])) ?  $trans['Price'] : 'Price'; ?>: $
                            <?php
                                if($products['offer_price'] == NULL){
                                    echo $products['price'];    
                                }
                                elseif($products['offer_price'] == '0'){
                                    echo $products['price'];
                                }
                                else{
                                    echo $products['offer_price'];
                                }
                            ?>
                        </p>
                    </div>
                </a>
            </td>
            <!-- <td><?php echo $item['product_name']; ?></td> -->
            <td><?php echo $item['product_qantity']; ?></td>
            <td><?php echo '$'.$item['total_price']; 
                            $pro = $item['total_price'];
                            $total = $total + $pro;?></td>
            <td><a href="add-cart-post.php?remove=<?php echo $item['product_id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a></td>
        </tr>
        <?php $last_product_id = $item['product_id']; ?>
    <?php endforeach ?>
<?php endif ?>
