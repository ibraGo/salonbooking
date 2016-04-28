<div class="row sln-summary">
    <div class="col-md-12">
        <div class="row sln-summary-row">
            <div class="col-xs-12 sln-data-desc">
                <?php
                if(current_user_can('manage_options')) {
                    ?>
                    <input class="sln-edit-text" id="<?php _e('Date and time booked', 'salon-booking-system') ?>"
                           value="<?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Date and time booked', 'salon-booking-system')); ?>" />
                    <?php
                } else {
                    ?>
                    <span class="label"><?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Date and time booked', 'salon-booking-system')); ?></span>
                    <?php
                }
                ?>
            </div>
            <div class="col-xs-12 sln-data-val">
                <?php echo $plugin->format()->date($datetime); ?> / <?php echo $plugin->format()->time($datetime) ?>
            </div>
            <div class="col-xs-12"><hr></div>
        </div>
        <?php if($attendants = $bb->getAttendants()) :  ?>
            <div class="row sln-summary-row">
                <div class="col-xs-12 sln-data-desc">
                    <?php
                    if(current_user_can('manage_options')) {
                        ?>
                        <input class="sln-edit-text" id="<?php _e('Assistants', 'salon-booking-system') ?>"
                               value="<?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Assistants', 'salon-booking-system')); ?>" />
                        <?php
                    } else {
                        ?>
                        <span class="label"><?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Assistants', 'salon-booking-system')); ?></span>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-xs-12 sln-data-val"><?php $names = array(); foreach(array_unique($attendants) as $att) { $names[] = $att->getName(); } echo implode(', ', $names); ?></div>
                <div class="col-xs-12"><hr></div>
            </div>
        <?php // IF ASSISTANT // END
        endif ?>
        <div class="row sln-summary-row">
            <div class="col-xs-12 sln-data-desc">
                <?php
                if(current_user_can('manage_options')) {
                    ?>
                    <input class="sln-edit-text" id="<?php _e('Services booked', 'salon-booking-system') ?>"
                           value="<?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Services booked', 'salon-booking-system')); ?>" />
                    <?php
                } else {
                    ?>
                    <span class="label"><?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Services booked', 'salon-booking-system')); ?></span>
                    <?php
                }
                ?>
            </div>
            <div class="col-xs-12 sln-data-val">
                <ul class="sln-list--dashed">
                    <?php foreach ($bb->getServices() as $service): ?>
                        <li> <span class="service-label"><?php echo $service->getName(); ?></span>
                            <?php if($showPrices){?>
                                <small> (<?php echo $plugin->format()->money($service->getPrice()) ?>)</small>
                            <?php } ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-md-12"><hr></div>
        </div>
    </div>
    <div class="col-md-12 sln-total">
        <hr>
        <?php if($showPrices){?>
            <h3 class="col-xs-6 sln-total-label"><?php _e('Total amount', 'salon-booking-system') ?></h3>
            <h3 class="col-xs-6 sln-total-price"><?php echo $plugin->format()->money(
                    $plugin->getBookingBuilder()->getTotal()
                ) ?> </h3>
        <?php }; ?>
    </div>
    <div class="col-md-12 sln-input sln-input--simple">
        <?php
        if(current_user_can('manage_options')) {
            ?>
            <input class="sln-edit-text" id="<?php _e('Do you have any message for us?', 'salon-booking-system') ?>"
                   value="<?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Do you have any message for us?', 'salon-booking-system')); ?>" />
            <?php
        } else {
            ?>
            <label><?php echo SLN_Plugin::getInstance()->getSettings()->getCustomText(__('Do you have any message for us?', 'salon-booking-system')); ?></label>
            <?php
        }
        ?>
        <?php SLN_Form::fieldTextarea(
            'sln[note]',
            $bb->get('note'),
            array('attrs' => array('placeholder' => __('Leave a message', 'salon-booking-system')))
        ); ?>
    </div>
    <div class="col-md-12">
        <p><strong><?php _e('Terms & conditions','salon-booking-system')?></strong></p>

        <p><?php echo $plugin->getSettings()->get('gen_timetable')
            /*_e(
                'In case of delay of arrival. we will wait a maximum of 10 minutes from booking time. Then we will release your reservation',
                'salon-booking-system'
            )*/ ?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 sln-input sln-input--action">
        <label for="login_name">&nbsp;</label>
        <?php $nextLabel = __('Finalise', 'salon-booking-system');
        include "_form_actions.php" ?>
    </div>
</div>
