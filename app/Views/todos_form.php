<?= $this->extend('layouts/main.php')?>

<?= $this->section('body-content')?>
<?php if(isset($task)){
    $done = $task->done;
}?>
<?php //dump_obj($task)?>
    <div class="container">
        <h2><?=$title?></h2>

            <?= form_open($action)?>
            <div class="form-group">
                <label for="exampleInputName">Task Name</label>
                <?= form_input(array(
                    'type'=>"text", 
                    'class'=>"form-control", 
                    'id'=>"inpName", 
                    'name'=>'name', 
                    'value'=>isset($task)?$task->name: ''
                ))?>
            </div>
            <div class="form-group">
                <label for="exampleInputDesc">Description</label>
                <?= form_textarea(array(
                    'class'=>"form-control", 
                    'id'=>"inpDesc", 
                    'name'=>'description', 
                    'value'=>isset($task)?$task->description: ''
                ))?>
            </div>

            <div class="form-check">
                <?= form_checkbox(array(
                    'class'=>"form-check-input", 
                    'id'=>"inpDone", 
                    'name'=>'done',
                    'checked'=>isset($done)?$done: 0
                ))?>
                <label class="form-check-label" for="exampleCheck1">Done</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        <?= form_close()?>      
    </div>
    <script>
        const chk = document.getElementById('inpDone')
        chk.addEventListener('change', ()=>{
            // console.log(chk)
            chk.value = (chk.checked)?1: 0
        })
    </script>

<?= $this->endSection()?>