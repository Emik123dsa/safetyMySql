<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Database\Database; 

$config = require_once 'config.php';

$db = new Database($config['db']);

$select = $db->query("SELECT * FROM post");


?>
<style>
.post_wrap_item {
    position: relative;
    max-width: 200px;
    margin: 0 auto;
} 
.post_wrap_item::before {
    content: '';
    position: absolute; 
    width: 100%;
    height: 1px; 
    background: #0c0c0c;
    bottom: 0;
}

</style>
<header class="header">
    <div class="post">
        <div class="container">
            <div class="post_wrap">
                <div class="post_wrap_items">

                <?php foreach($select as $item): ?>
                <div class="post_wrap_item">
                <!-- /.post_wrap_item -->
<h2 class="post_wrap_item_title"><?= $item['title']?></h2>
<!-- /.post_wrap_item_title -->
<p class="post_wrap_item_content"> 
<?= $item['content']?>
</p>
<!-- /.post_wrap_item_content -->
</div>
<?php endforeach;?>

                </div>
                <!-- /.post_wrap_items -->
            </div>
            <!-- /.post_wrap -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.post -->
</header>
<!-- /.header -->

