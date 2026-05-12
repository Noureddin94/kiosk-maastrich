<!-- Start Menu -->

<section class="bg-success-menu" id="menu">
    <h1 class="heading"> <span>Menu</span><?php echo $lang['menu H1'] ?></h1>
    <div class="container img_menu">
        <div class="table-responsive" data-aos="fade-up" data-aos-duration="1000" data-aos-offset="200" data-aos-delay="500">
            <table class="table caption-top table-success table-striped table-hover">
                <?php
                // SQL query to select the category
                $category = "SELECT * FROM tb_category WHERE id = :categoryId";
                $stmt = $pdo->prepare($category);
                $stmt->bindValue(':categoryId', 17, PDO::PARAM_INT);
                $stmt->execute();
                ?>
                <caption class="p-3 text-white text-center fs-2 text-uppercase">
                    <?php
                    if ($stmt->rowCount()) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo $row['category_' . $_SESSION['lang']];
                        }
                    } else {
                    ?>
                <tr>
                    <td colspan="6">
                        <div class="error">No Category to Display.</div>
                    </td>
                </tr>
            <?php
                    }
            ?>
            </caption>
            <tbody class="fs-4">
                <?php
                //loop through categories and display them in a list
                // Query to get all food from the first category
                $elements_cat = "SELECT c.category_{$_SESSION['lang']} AS category_title, f.title_{$_SESSION['lang']}, f.description_{$_SESSION['lang']}, f.price
                    FROM tb_category AS c
                    JOIN tb_food AS f ON c.id = f.category_id
                    WHERE c.id = :categoryId
                    ORDER BY c.id;";
                $stmt = $pdo->prepare($elements_cat);
                // Bind the parameter
                // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':categoryId', 17, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount()) {
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                        // $id = $row['id'];
                        $title = $row['title_' . $_SESSION['lang']];
                        $description = $row['description_' . $_SESSION['lang']];
                        $price = $row['price'];
                        $category_title = $row['category_title'];
                ?>
                        <tr>
                            <th><?php echo $title; ?></th>
                            <td><?php echo $description; ?></td>
                            <td class="fw-bold">€<?php echo $price; ?></td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6">
                            <div class="error">No Food To Display.</div>
                        </td>
                    </tr>
                <?php
                    exit();
                }
                ?>
            </tbody>
            </table>
        </div>
        <div class="row d-flex mt-5" data-aos="fade-up" data-aos-duration="1000" data-aos-offset="200" data-aos-delay="500">
            <div class="table-responsive col-lg-6 col-xl-6">
                <table class="table caption-top table-success table-striped table-hover">
                    <?php
                    // SQL query to select the category
                    $category2 = "SELECT * FROM tb_category WHERE id = :categoryId";
                    $stmt = $pdo->prepare($category2);
                    $stmt->bindValue(':categoryId', 18, PDO::PARAM_INT);
                    $stmt->execute();
                    ?>
                    <caption class="p-3 text-white text-center fs-2 text-uppercase">
                        <?php
                        if ($stmt->rowCount()) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo $row['category_' . $_SESSION['lang']];
                            }
                        } else {
                        ?>
                    <tr>
                        <td colspan="6">
                            <div class="error">No Category to Display.</div>
                        </td>
                    </tr>
                <?php
                        }
                ?>
                </caption>
                <tbody class="fs-4">
                    <?php
                    // loop through categories and display them in a list
                    // Query to get all food from the first category
                    $elements_cat = "SELECT c.category_{$_SESSION['lang']} AS category_title, f.title_{$_SESSION['lang']}, f.price
                    FROM tb_category AS c
                    JOIN tb_food AS f ON c.id = f.category_id
                    WHERE c.id = :categoryId
                    ORDER BY c.id;";
                    $stmt = $pdo->prepare($elements_cat);
                    $stmt->bindValue(':categoryId', 18, PDO::PARAM_INT);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows as $row) {
                            // $id = $row['id'];
                            $title = $row['title_' . $_SESSION['lang']];
                            $price = $row['price'];
                    ?>
                            <tr>
                                <th><?php echo $title; ?></th>
                                <td class="fw-bold">€<?php echo $price; ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6">
                                <div class="error">No Drinks Added.</div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                </table>
            </div>
            <div class="table-responsive col-lg-6 col-xl-6">
                <table class="table caption-top table-success table-striped table-hover">
                    <?php
                    // SQL query to select the category
                    $category3 = "SELECT * FROM tb_category WHERE id = :categoryId";
                    $stmt = $pdo->prepare($category3);
                    $stmt->bindValue(':categoryId', 19, PDO::PARAM_INT);
                    $stmt->execute();
                    ?>
                    <caption class="p-3 text-white text-center fs-2 text-uppercase">
                        <?php
                        if ($stmt->rowCount()) {

                            while ($row3 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo $row3['category_' . $_SESSION['lang']];
                            }
                        } else {
                        ?>
                    <tr>
                        <td colspan="6">
                            <div class="error">No Category to Display.</div>
                        </td>
                    </tr>
                <?php
                        }
                ?>
                </caption>
                <tbody class="fs-4">
                    <?php
                    // loop through categories and display them in a list
                    // Query to get all food from the first category
                    $elements_cat = "SELECT c.category_{$_SESSION['lang']} AS category_title, f.title_{$_SESSION['lang']}, f.price
                    FROM tb_category AS c
                    JOIN tb_food AS f ON c.id = f.category_id
                    WHERE c.id = :categoryId
                    ORDER BY c.id;";
                    $stmt = $pdo->prepare($elements_cat);
                    $stmt->bindValue(':categoryId', 19, PDO::PARAM_INT);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows as $row) {
                            $title = $row['title_' . $_SESSION['lang']];
                            $price = $row['price'];
                    ?>
                            <tr>
                                <th><?php echo $title; ?></th>
                                <td class="fw-bold">€<?php echo $price; ?></td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6">
                                <div class="error">No Drinks Added.</div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- End Menu -->