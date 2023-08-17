<div class="row justify-content-center">
    <div class="col-md-4 ">
        <div class=" alert alert-danger">
            <?php
                foreach (Session::flash('registerError') as $message) {
                    print $message . '<br/>';
                }
            ?>
        </div>
    </div>
</div>
