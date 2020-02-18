<?php declare(strict_types=1);


require_once __DIR__ . '/vendor/autoload.php';

use Database\Database; 

$config = require_once 'config.php';

$db = new Database($config['db']);

$select = $db->query("SELECT * FROM post ORDER BY id DESC");


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

p {
    margin: 0;
    padding: 0;
}

.form_post_wrap {
    display: flex; 
    justify-content: center; 
    align-items: center;
}

body {
    display: flex;
    justify-content: space-around;
    max-width: 370px; 
    width: 100%;
    margin: 0 auto;
}

.container {
    margin: 0 auto; 
    max-width: 1170px; 
    width: 100%;
}

.form_post {
   
    position: fixed;
    
}

.form_post_form_item {
    margin: 10px 0;
    position: relative;
}

#textarea {
    width: 100%;
    max-width: 175px;
}

.form_post_form_button {
    position: relative;
}

.loading::after {
    position: absolute; 
    content: ''; 
    top: 50%;
    left: 50%; 
    
    border: 2px solid #0c0c0c; 
    transform: translate(-50%, -50%) rotate(0deg);
    
    border-radius: 50%; 
    width: 10px;
    height: 10px; 
    animation: rotation 1s ease infinite;
}

@keyframes rotation {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
        border-top: 2px solid transparent;
    }
    1% {
        transform: translate(-50%, -50%) rotate(360deg);
        border-right: 2px solid transparent;
    }
    100% {
        transform: translate(-50%, -50%) rotate(0deg);
       
    }
    
}
.loading::after {
    
}

.form_post_form_button.loading span {
    opacity: 0;
    visibility: hidden;
}

.form_post_button span {
    opacity: 1;
    visibility: visible;
}

</style>

<body>
    

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

<main class="main">
    <section class="form_post">
        <div class="container">
            <div class="form_post_wrap">
                <form name="post" class="form_post_form">
                    <div class="form_post_form_item">
                        <label for="title">Title</label>
                        <p class="form_post_form_title">
                        <!-- /.form_post_form_title -->
                        <input type="text" name="title">
                        </p>
                    </div>
                    <div class="form_post_form_item">
                            <label for="content">About</label>
                            <p class="form_post_form_textarea"> 
                            <textarea name="content" id="textarea"></textarea>
                            </p>
                    </div>
<div class="form_post_form_item">
    <button id ="buttonPost" class="form_post_form_button"> <span> Send a Post</span>

         </button> 
    <!-- /.form_post_form_button --></div>
<!-- /.form_post_form_item -->
                </form>
                <!-- /.form_post -->
            </div>
            <!-- /.form_post_wrap -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.form_post -->
</main>
<!-- /.main -->

<script type="text/javascript">
var post = {
    sendPost : function() {
    
    

   

    document.forms.post.onsubmit = function(e) {
        
        e.preventDefault();
        buttonSelector.classList.add('loading');
    var title = document.forms.post.title.value; 
    var content = document.forms.post.content.value; 
    
    title = encodeURIComponent(title);
    content = encodeURIComponent(content);
  
    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'src/Post.php'); 

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); 

    xhr.onreadystatechange = function() {
        if (xhr.status === 200 && xhr.readyState === 4 ) {
            buttonSelector.classList.remove('loading');
            //location.reload();
        }
    }
   ;
    xhr.send('title=' + title + '&content=' + content);
    
}
}
}
const buttonSelector = document.getElementById('buttonPost');

    buttonSelector.addEventListener('on', post.sendPost());


</script>
</body>

