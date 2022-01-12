<?= $this->extend('layouts/main.php')?>

<?= $this->section('body-content')?>
<div class="container">
    <h1>REST</h1>
    <button id="btn">click to send</button>
</div>
<script>
    document.getElementById('btn').addEventListener('click', (e)=>{
        console.log(e.target);
        fetch("<?= site_url('todos')?>")
            .then(res=>res.json)
            .then(data=>console.log(data))
    })
</script>

<?= $this->endSection()?>