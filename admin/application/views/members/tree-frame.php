<?php
ini_set("display_errors", 1);
?>
<link rel="stylesheet" href="<?php echo base_url('../'); ?>portal_assets/bootstrap/css/bootstrap.min.css">
<style>
    body {
        font-family: Calibri, Segoe, "Segoe UI", "Gill Sans", "Gill Sans MT", sans-serif;
        width: 150%;
    }

    /* It's supposed to look like a tree diagram */
    .tree,
    .tree ul,
    .tree li {
        list-style: none;
        margin: 0;
        padding: 0;
        position: relative;
    }

    .tree {
        margin: 0 0 1em;
        text-align: center;
    }

    .tree,
    .tree ul {
        display: table;
    }

    .tree ul {
        width: 100%;
    }

    .tree li {
        display: table-cell;
        padding: .5em 0;
        vertical-align: top;
    }

    /* _________ */
    .tree li:before {
        outline: solid 1px #666;
        content: "";
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
    }

    .tree li:first-child:before {
        left: 50%;
    }

    .tree li:last-child:before {
        right: 50%;
    }

    .tree code,
    .tree span {
        /* border: solid .1em #666; */
        border-radius: .2em;
        display: inline-block;
        /* margin: 0 .2em .5em; */
        padding: .2em .5em;
        position: relative;
    }

    /* If the tree represents DOM structure */
    .tree code {
        font-family: monaco, Consolas, 'Lucida Console', monospace;
    }

    /* | */
    .tree ul:before,
    .tree code:before,
    .tree span:before {
        outline: solid 1px #666;
        content: "";
        height: .5em;
        left: 50%;
        position: absolute;
    }

    .tree ul:before {
        top: -.5em;
    }

    .tree code:before,
    .tree span:before {
        top: -.55em;
    }

    /* The root node doesn't connect upwards */
    .tree>li {
        margin-top: 0;
    }

    .tree>li:before,
    .tree>li:after,
    .tree>li>code:before,
    .tree>li>span:before {
        outline: none;
    }
</style>

<?php
$vendorId = $this->uri->segment(3);
$currentParent = $ROOT_EPIN;
function giveMeMyChildrens($parent, $level) {
    $instance = &get_instance();
    return $instance->Crud->ciRead('users', " `position_under` = '$parent' AND `level_from_top` = '$level'");
}
?>

<center>

    <?php if ($this->uri->segment(3) && strlen($this->uri->segment(3)) == 8) { ?>
    <?php $rootEpinData = $this->Crud->ciRead('users', " `epin` = '$ROOT_EPIN'"); ?>
        <?php $this->load->view('messages'); ?>
        <ul class="tree">
            <li>
                <code>
                    <a style="font-size: 7pt;" href="<?php echo base_url('members/treeFrame/' . $rootEpinData[0]->epin); ?>">
                        <div class="card text-white bg-<?php echo $rootEpinData[0]->is_active == 1 ? 'success' : 'danger'; ?> mb-3" style="max-width: 15rem; max-height: 12rem;">
                            <div class="card-header"><?php echo $rootEpinData[0]->epin; ?></div>
                            <p class="card-title mt-1">
                                Name: <?php echo $rootEpinData[0]->name; ?><br />
                                Referrer: <?php echo strlen($rootEpinData[0]->referral_code) < 8 ? 'BRANCH' : $rootEpinData[0]->referral_code; ?><br />
                                Joined on: <?php echo date('d-M-y', $rootEpinData[0]->joined_on); ?>
                            </p>
                        </div>
                    </a>
                </code>
                <ul>
                    <?php foreach (giveMeMyChildrens($currentParent, $myLevel + 1) as $key) { ?>
                        <li>
                            <code>
                                <a style="font-size: 7pt;" href="<?php echo base_url('members/treeFrame/' . $key->epin); ?>">
                                    <div class="card text-white bg-<?php echo $key->is_active == 1 ? 'success' : 'danger'; ?> mb-3" style="max-width: 15rem; max-height: 12rem;">
                                        <div class="card-header"><?php echo $key->epin; ?></div>
                                        <p class="card-title mt-1">
                                            Name: <?php echo $key->name; ?><br />
                                            Referrer: <?php echo $key->referral_code; ?><br />
                                            Joined on: <?php echo date('d-M-y', $key->joined_on); ?>
                                        </p>
                                    </div>
                                </a>
                            </code>
                            <ul>
                                <?php
                                foreach (giveMeMyChildrens($key->epin, $myLevel + 2) as $key2) { ?>
                                    <li>
                                        <code>
                                            <a style="font-size: 7pt;" href="<?php echo base_url('members/treeFrame/' . $key2->epin); ?>">
                                                <div class="card text-white bg-<?php echo $key2->is_active == 1 ? 'success' : 'danger'; ?> mb-3" style="max-width: 15rem; max-height: 12rem;">
                                                    <div class="card-header"><?php echo $key2->epin; ?></div>
                                                    <p class="card-title mt-1">
                                                        Name: <?php echo $key2->name; ?><br />
                                                        Referrer: <?php echo $key2->referral_code; ?><br />
                                                        Joined on: <?php echo date('d-M-y', $key2->joined_on); ?>
                                                    </p>
                                                </div>
                                            </a>
                                        </code>
                                        <ul>
                                            <?php foreach (giveMeMyChildrens($key2->epin, $myLevel + 3) as $key3) { ?>
                                                <li>
                                                    <code>
                                                        <a style="font-size: 7pt;" href="<?php echo base_url('members/treeFrame/' . $key3->epin); ?>">
                                                            <div class="card text-white bg-<?php echo $key3->is_active == 1 ? 'success' : 'danger'; ?> mb-3" style="max-width: 15rem; max-height: 12rem;">
                                                                <div class="card-header"><?php echo $key3->epin; ?></div>
                                                                <p class="card-title mt-1">
                                                                    Name: <?php echo $key3->name; ?><br />
                                                                    Referrer: <?php echo $key3->referral_code; ?><br />
                                                                    Joined on: <?php echo date('d-M-y', $key3->joined_on); ?>
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </code>
                                                    <ul>
                                                        <?php foreach (giveMeMyChildrens($key3->epin, $myLevel + 4) as $key4) { ?>
                                                            <li><code>
                                                                    <a style="font-size: 7pt;" href="<?php echo base_url('members/treeFrame/' . $key4->epin); ?>">
                                                                        <div class="card text-white bg-<?php echo $key4->is_active == 1 ? 'success' : 'danger'; ?> mb-3" style="max-width: 15rem; max-height: 12rem;">
                                                                            <div class="card-header"><?php echo $key4->epin; ?></div>
                                                                            <p class="card-title mt-1">
                                                                                Name: <?php echo $key4->name; ?><br />
                                                                                Referrer: <?php echo $key4->referral_code; ?><br />
                                                                                Joined on: <?php echo date('d-M-y', $key4->joined_on); ?>
                                                                            </p>
                                                                        </div>
                                                                    </a>
                                                                </code>
                                                                <ul>
                                                                    <?php foreach (giveMeMyChildrens($key4->epin, $myLevel + 5) as $key5) { ?>
                                                                        <li>
                                                                            <code>
                                                                                <a style="font-size: 7pt;" href="<?php echo base_url('members/treeFrame/' . $key4->epin); ?>">
                                                                                    <div class="card text-white bg-<?php echo $key4->is_active == 1 ? 'success' : 'danger'; ?> mb-3" style="max-width: 15rem; max-height: 12rem;">
                                                                                        <div class="card-header"><?php echo $key4->epin; ?></div>
                                                                                        <p class="card-title mt-1">
                                                                                            Name: <?php echo $key4->name; ?><br />
                                                                                            Referrer: <?php echo $key4->referral_code; ?><br />
                                                                                            Joined on: <?php echo date('d-M-y', $key4->joined_on); ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </a>
                                                                            </code>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    <?php } else { ?>
        <ul class="tree">
            <li>
                <code>
                    <a style="font-size: 7pt;">
                        <div class="card text-white bg-success mb-3" style="max-width: 15rem; max-height: 12rem;">
                            <div class="card-header">BRANCH</div>
                        </div>
                    </a>
                </code>
                <ul>
                    <li>
                        <ul>
                            <?php foreach ($this->Crud->ciRead('users', " `position_under` = '$vendorId'") as $key) { ?>
                                <li>
                                    <code>
                                        <a style="font-size: 7pt;" href="<?php echo base_url('members/treeFrame/' . $key->epin); ?>">
                                            <div class="card text-white bg-<?php echo $key->is_active == 1 ? 'success' : 'danger'; ?> mb-3" style="max-width: 15rem; max-height: 12rem;">
                                                <div class="card-header"><?php echo $key->epin; ?></div>
                                                <p class="card-title mt-1">
                                                    Name: <?php echo $key->name; ?><br />
                                                    Referrer: <?php echo $key->referral_code; ?><br />
                                                    Joined on: <?php echo date('d-M-y', $key->joined_on); ?>
                                                </p>
                                            </div>
                                        </a>
                                    </code>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    <?php } ?>
</center>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="<?php echo base_url('../'); ?>portal_assets/bootstrap/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>