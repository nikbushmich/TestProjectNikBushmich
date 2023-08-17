<div class="row justify-content-center">
    <div class="col-md-4 ">
        <div class=" alert alert-success">
            <?php
                foreach (Session::flash('successCreateUser') as $message) {
                    print $message . '<br/>';
                }
            ?>
        </div>
    </div>
</div>
