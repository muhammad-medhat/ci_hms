<?= $this->extend('layouts/main.php')?>

<?= $this->section('body-content')?>


<div class="container">
    <h2><?-$title?></h2>
    <ul class="list-group">
        <?php //var_dump($todos)?>
        <?php foreach($todos as $t){ ?>
            <li class="list-group-item">
                
            
                <div class="todo-row d-flex">
                    <div class="data col">
                        <input type="checkbox" <?= ($t->done == 0)? '': 'checked' ?> />
                        <span><?= $t->id?></span>
                        <span><?= $t->name?></span>
                        <span><?= $t->description?></span>                        
                    </div>
                    <div class="ops col">
                        <span><?= anchor(site_url("todos/update/$t->id"), 'Update...')?></span>
                        <span><?= anchor(site_url("todos/Delete/$t->id"), 'Delete')?></span>
                    </div>
                    
                </div>

            </li>
        <?php } ?>
    </ul>

</div>

<div class="text-center m-t-1">
        <?= $pager->links()?>
</div>



<?= $this->endSection()?>