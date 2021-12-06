<div class="card-body login-card-body">

    <div class="row" style="margin-top: 1em;">
        <div class="col-3">
        </div>
        <div class="col-6">

            <?php
            if ($this->session->flashdata('danger')) {
                echo '<div class="alert alert-danger fade show" role="alert">
                            <div class="alert-text">' . $this->session->flashdata('danger') . '</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">x</i></span>
                                </button>
                            </div>
                        </div>';
            }
            ?>
            <?php
            if ($this->session->flashdata('success')) {
                echo '<div class="alert alert-success fade show" role="alert">
                            <div class="alert-text">' . $this->session->flashdata('success') . '</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">x</i></span>
                                </button>
                            </div>
                        </div>';
            }
            ?>
            <form action="<?php echo site_url('settings/updateProfile'); ?>" method="post">
                <center>
                    <h4>Profile</h4>
                </center>
                <div class="row">
                    <div class="col-sm-4">
                        <b>Name</b>: <?= $PROFILE[0]->name; ?>
                    </div>
                    <div class="col-sm-4">
                        <b>ePin</b>: <?= $PROFILE[0]->epin; ?>
                    </div>
                    <div class="col-sm-4">
                        <b>Position under</b>: <?= strlen($PROFILE[0]->position_under) < 8 ? 'BRANCH' : $PROFILE[0]->position_under; ?>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-sm-4">
                        <b>Phone</b>: <?= $PROFILE[0]->phone; ?>
                    </div>
                    <div class="col-sm-4">
                        <b>Email</b>: <?= $PROFILE[0]->email; ?>
                    </div>
                    <div class="col-sm-4">
                        <b>Address</b>: <?= $PROFILE[0]->address; ?>
                    </div>
                </div>
                <div class="input-group my-3">
                    <input type="email" required name="email" class="form-control" value="<?php echo $PROFILE[0]->email; ?>" placeholder="Enter email">
                </div>
                <div class="input-group my-3">
                    <input type="text" required name="address" class="form-control" value="<?php echo $PROFILE[0]->address; ?>" placeholder="Enter address">
                </div>
                <button type="submit" name="change" class="btn btn-primary btn-block">Update</button>
        </div>
    </div>
</form>
</div>