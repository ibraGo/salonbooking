<?php
/**
 * @var string               $content
 * @var SLN_Shortcode_Salon $salon
 */
//$labels = array(
//    'date'      => __('date', 'sln'),
//    'services'  => __('services', 'sln'),
//    'secondary' => __('secondary', 'sln'),
//    'details'   => __('details', 'sln'),
//    'summary'   => __('summary', 'sln'),
//    'thankyou'  => __('thankyou', 'sln'),
//);
?>
<div id="sln-salon" class="sln-bootstrap">
    <?php
    if ($trial_exp)
        echo '<span class="sln_notice">' . __('Your free version is expired - upgrade to PRO', 'sln') . '</span>';

    ?>
    <div>
        <h1><?php _e('Book an appointment', 'sln'); ?>
            <svg class="icocal" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"
                 preserveAspectRatio="xMinYMin meet" width="100%" height="100%"
                 style="width: 24px; height: 24px;">
                <path
                    d="M0 916.021l0 -738.234q0 -35.154 24.413 -59.567t59.567 -24.413l134.757 0l0 -62.496q0 -13.671 8.789 -22.46t22.46 -8.789 22.46 8.789 8.789 22.46l0 62.496l187.488 0l0 -62.496q0 -13.671 8.789 -22.46t22.46 -8.789 22.46 8.789 8.789 22.46l0 62.496l187.488 0l0 -62.496q0 -13.671 8.789 -22.46t22.46 -8.789 22.46 8.789 8.789 22.46l0 62.496l134.757 0q35.154 0 59.567 24.413t24.413 59.567l0 738.234q0 35.154 -24.413 59.567t-59.567 24.413l-831.978 0q-35.154 0 -59.567 -24.413t-24.413 -59.567zm62.496 0q0 9.765 5.859 15.624t15.624 5.859l831.978 0q9.765 0 15.624 -5.859t5.859 -15.624l0 -738.234q0 -9.765 -5.859 -15.624t-15.624 -5.859l-134.757 0l0 62.496q0 13.671 -8.789 22.46t-22.46 8.789 -22.46 -8.789 -8.789 -22.46l0 -62.496l-187.488 0l0 62.496q0 13.671 -8.789 22.46t-22.46 8.789 -22.46 -8.789 -8.789 -22.46l0 -62.496l-187.488 0l0 62.496q0 13.671 -8.789 22.46t-22.46 8.789 -22.46 -8.789 -8.789 -22.46l0 -62.496l-134.757 0q-9.765 0 -15.624 5.859t-5.859 15.624l0 738.234zm156.24 -134.757l0 -93.744l124.992 0l0 93.744l-124.992 0zm0 -156.24l0 -93.744l124.992 0l0 93.744l-124.992 0zm0 -156.24l0 -93.744l124.992 0l0 93.744l-124.992 0zm218.736 312.48l0 -93.744l124.992 0l0 93.744l-124.992 0zm0 -156.24l0 -93.744l124.992 0l0 93.744l-124.992 0zm0 -156.24l0 -93.744l124.992 0l0 93.744l-124.992 0zm218.736 312.48l0 -93.744l124.992 0l0 93.744l-124.992 0zm0 -156.24l0 -93.744l124.992 0l0 93.744l-124.992 0zm0 -156.24l0 -93.744l124.992 0l0 93.744l-124.992 0z"></path>
            </svg>
        </h1>
        <?php
        /*
          <ul class="salon-bar nav nav-pills nav-justified thumbnail">
          <?php $i = 0;
          foreach ($salon->getSteps() as $step) : $i++; ?>
          <li <?php echo $step == $salon->getCurrentStep() ? 'class="active"' : ''?>>
          <?php echo $i ?>. <?php echo $labels[$step] ?>
          </li>
          <?php endforeach ?>
          </ul>
         */

        ?>
<?php echo $content ?>
    </div>
</div>
