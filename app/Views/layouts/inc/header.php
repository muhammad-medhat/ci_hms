<nav>
    <ul class="nav">
        <li class="nav-item"><?= anchor(base_url('todos'),'Show todos', 'class="nav-link"'  )?>
        <li class="nav-item"><?= anchor(base_url('todos/insert'), 'Add', 'class="nav-link"' )?>
    </ul>
</nav>

<?php if(isset($alert) and $alert != '') { ?>
    <div class="alert <?= $alert->class?>" role="alert">
        <?= $alert->message?>
    </div>
<?php } ?>
<?php if(session()->get('success')){ ?>
    <div class="alert alert-success">
        <?= session()->get('success')?>
    </div>
<?php } ?>
<?php if(session()->get('error')){ ?>
    <div class="alert alert-danger">
        <?= session()->get('error')?>
    </div>
<?php } ?>

