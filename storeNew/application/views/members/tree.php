<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <?php $this->load->view('messages'); ?>
        <h4 class="ml-2">Genealogy</h4>
        <button class="my-1 btn btn-amazon" onclick="window.history.back()">Back</button>
        <button class="my-1 btn btn-amazon" style="float: right;" onclick="window.history.forward()">Forward</button>
        <iframe src="<?php echo site_url('members/treeFrame/'.$this->uri->segment(3)); ?>" style="border: none; width: 100%; height: 33em;" title="Genealogy"></iframe>
    </div>
</div>