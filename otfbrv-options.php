<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Widget title'); ?></p>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="form-control widefat" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Layout view'); ?></p>
        <select class="form-control widefat" name="<?php echo $this->get_field_name('layout') ?>">
            <option value="1"<?php selected('1', $layout); ?>><?php echo otfbrv_e('Slider layout'); ?></option>
            <option value="2"<?php selected('2', $layout); ?>><?php echo otfbrv_e('List layout'); ?></option>
            <option value="3"<?php selected('3', $layout); ?>><?php echo otfbrv_e('Grid layout'); ?></option>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Review limit'); ?></p>
        <input type="number" id="<?php echo $this->get_field_id('reviewlimit'); ?>" name="<?php echo $this->get_field_name('reviewlimit'); ?>" value="<?php echo $reviewlimit; ?>" class="form-control widefat" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Review columns with grid layout'); ?></p>
        <input type="number" id="<?php echo $this->get_field_id('reviewcolumns'); ?>" name="<?php echo $this->get_field_name('reviewcolumns'); ?>" value="<?php echo $reviewcolumns; ?>" class="form-control widefat" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Show reviews without comment'); ?></p>
        <select class="form-control widefat" name="<?php echo $this->get_field_name('reviewempty') ?>">
            <option value="1"<?php selected('1', $reviewempty); ?>><?php echo otfbrv_e('Yes'); ?></option>
            <option value="0"<?php selected('0', $reviewempty); ?>><?php echo otfbrv_e('No'); ?></option>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Show reviews from'); ?></p>
        <select class="form-control widefat" name="<?php echo $this->get_field_name('reviewstar') ?>">
            <option value="1"<?php selected('1', $reviewstar); ?>><?php echo otfbrv_e('1 star'); ?></option>
            <option value="2"<?php selected('2', $reviewstar); ?>><?php echo otfbrv_e('2 star'); ?></option>
            <option value="3"<?php selected('3', $reviewstar); ?>><?php echo otfbrv_e('3 star'); ?></option>
            <option value="4"<?php selected('4', $reviewstar); ?>><?php echo otfbrv_e('4 star'); ?></option>
            <option value="5"<?php selected('5', $reviewstar); ?>><?php echo otfbrv_e('5 star'); ?></option>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Image width(px)'); ?></p>
        <input type="number" id="<?php echo $this->get_field_id('imagewidth'); ?>" name="<?php echo $this->get_field_name('imagewidth'); ?>" value="<?php echo $imagewidth; ?>" class="form-control widefat" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Image height(px)'); ?></p>
        <input type="number" id="<?php echo $this->get_field_id('imageheight'); ?>" name="<?php echo $this->get_field_name('imageheight'); ?>" value="<?php echo $imageheight; ?>" class="form-control widefat" />
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p><?php echo otfbrv_e('Widget class'); ?></p>
        <input type="text" id="<?php echo $this->get_field_id('widgetclass'); ?>" name="<?php echo $this->get_field_name('widgetclass'); ?>" value="<?php echo $widgetclass; ?>" class="form-control widefat" />
    </div>
</div>