
        <a data-salon-data="<?php echo $ajaxData.'&mode='.$paymentMethod->getMethodKey() ?>" data-salon-toggle="direct"
        href="<?php echo $payUrl ?>" class="btn btn-primary">
            <?php $deposit = $plugin->getBookingBuilder()->getLastBooking()->getDeposit(); ?> 
            <?php if($deposit > 0): ?>
                <?php echo sprintf(__('Pay %s as a deposit with %s', 'sln'), $plugin->format()->money($deposit), $paymentMethod->getMethodLabel()) ?>
            <?php else : ?>
                <?php sprintf(_e('Pay with %s', 'sln'), $paymentMethod->getMethodLabel()) ?>
            <?php endif ?>
        </a>