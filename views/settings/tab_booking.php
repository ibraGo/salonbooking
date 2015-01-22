<?php
/**
 * @param $this SLN_Admin_Settings
 */
function sln_availability_row($prefix, $row)
{
    ?>
    <div class="col-md-12">
        <?php foreach (SLN_Func::getDays() as $k => $day) : ?>
            <div class="form-group">
                <label>
                    <?php SLN_Form::fieldCheckbox(
                        $prefix . "[days][{$k}]",
                        $row['days'][$k]
                    ) ?>
                    <?php echo substr($day, 0, 3) ?></label>
            </div>
        <?php endforeach ?>
        <div class="pull-right">
            <?php foreach (array(0, 1) as $i) : ?>
                <?php foreach (array('from' => __('From', 'sln'), 'to' => __('To', 'sln')) as $k => $v) : ?>
                    <div class="form-group">
                        <label for="<?php echo SLN_Form::makeID($prefix . "[$k][$i]") ?>">
                            <?php echo $v ?>
                        </label>
                        <?php SLN_Form::fieldTime($prefix . "[$k][$i]", $row[$k][$i]) ?>
                    </div>
                <?php endforeach ?>
            <?php endforeach ?>
        </div>
    </div>
<?php
}

?>
<div class="sln-tab" id="sln-tab-booking">
    <div class="row form-inline">
        <div class="col-md-6">
            <div class="form-group">
                <label for="salon_settings[parallels]">
                    <?php _e('How many people you can attend during a single time session?', 'sln') ?>
                </label>
                <?php echo SLN_Form::fieldNumeric(
                    "salon_settings[parallels_hour]",
                    $this->getOpt('parallels_hour'),
                    array('min' => 1, 'max' => 20)
                ) ?>
                <p class="help-block"><?php _e(
                        'Set this option carefully because will affect the number of bookings you can accept for the same <strong>time session</strong>.',
                        'sln'
                    ) ?></p>
            </div>
<?php /*
            <div class="form-group">
                <label for="salon_settings[parallels]">
                    <?php _e('How many people you can serve at the same day?', 'sln') ?>
                </label>
                <?php echo SLN_Form::fieldNumeric(
                    "salon_settings[parallels_day]",
                    $this->getOpt('parallels_day'),
                    array('min' => 0, 'max' => 100)
                ) ?>
                <p class="help-block"><?php _e(
                        'Set this option carefully because will affect the number of bookings you can accept for the same <strong>day</strong>.<br/>Leave 0 to disable this limit',
                        'sln'
                    ) ?></p>
            </div>
*/?>
        </div>
        <div class="col-md-6"></div>
            <div class="clearfix"></div>
            <div class="sln-separator"></div>

        <div class="col-md-7">
                <div class="form-group">
                    <strong>
                        <?php _e('Bookings are allowed from', 'sln') ?>
                    <?php $field = "salon_settings[hours_before_from]"; ?>
                    <?php echo SLN_Form::fieldSelect(
                        $field,
                        SLN_Func::getIntervalItems(),
                        $this->getOpt('hours_before_from'),
                        array(),
                        true
                    ) ?>

                        <?php _e('To a maximum of', 'sln') ?>

                    <?php $field = "salon_settings[hours_before_to]"; ?>
                    <?php echo SLN_Form::fieldSelect(
                        $field,
                        SLN_Func::getIntervalItems(),
                        $this->getOpt('hours_before_to'),
                        array(),
                        true
                    ) ?>
 
                        <?php _e('in advance', 'sln') ?>
                   </strong>
            </div>
        </div>
        <div class="col-md-5">
            <?php $field = "salon_settings[interval]"; ?>
            <div class="row">
                <label for="<?php echo SLN_Form::makeID($field) ?> ">
                    <?php _e('Define the interval in minutes between time definition', 'sln') ?>
                </label>
                <?php echo SLN_Form::fieldSelect(
                    $field,
                    array('5', '10', '15', '30', '60'),
                    $this->getOpt('interval') ? $this->getOpt('interval') : 15
                ) ?>
            </div>
        </div>
<br/>
            <div class="clearfix"></div>
        <div class="sln-separator"></div>
        <?php
        $key            = 'available';
        $label          = __('Online booking available on', 'sln');
        $availabilities = $this->getOpt('availabilities');
        ?>
        <div class="form-group">
            <label><?php echo $label ?></label>

            <p class="help-block">Leave blank if you want booking available everydays at every hour</p>
        </div>
        <div id="sln-availabilities">
            <div class="items">
                <?php foreach ($availabilities as $k => $row): ?>
                    <div class="item">
                        <div class="row form-inline">
                            <div class="col-md-10">
                                <?php sln_availability_row("salon_settings[availabilities][$k]", $row); ?>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-block btn-danger" data-collection="remove">
                                    <i class="glyphicon glyphicon-minus"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="col-md-2 pull-right">
                <button data-collection="addnew" class="btn btn-block btn-primary"><i
                        class="glyphicon glyphicon-plus"></i> <?php _e(
                        'Add new'
                    ) ?>
                </button>
            </div>
            <div data-collection="prototype" data-count="<?php echo count($availabilities) ?>">
                <div class="row form-inline">
                    <div class="col-md-10">
                        <?php sln_availability_row("salon_settings[availabilities][__new__]", $row); ?>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-danger" data-collection="remove">
                            <i class="glyphicon glyphicon-minus"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="sln-separator"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php _e('Disable online booking', 'sln') ?>
                            <?php SLN_Form::fieldCheckbox(
                                "salon_settings[disabled]",
                                $this->getOpt('disabled')
                            ) ?>
                        </label>

                        <p class="help-block">
                            <?php _e(
                                'If checked the booking user will see a message with the reason of disabled booking.',
                                'sln'
                            ) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="<?php echo SLN_form::makeID("salon_settings[disabled_message]") ?>"><?php _e(
                                'Message on disabled booking',
                                'sln'
                            ) ?></label>
                        <?php SLN_Form::fieldTextarea(
                            "salon_settings[disabled_message]",
                            $this->getOpt('disabled_message'),
                            array(
                                'attrs' => array(
                                    'placeholder' => 'Write a message',
                                    'rows'        => 5,
                                    'class'       => 'form-control',
                                    'style'       => 'width: 100%;'
                                )
                            )
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="sln-separator"></div>
        <div class="row">
            <div class="col-md-6">
                <?php $this->row_input_checkbox(
                    'confirmation',
                    __('Bookings Confirmation', 'sln'),
                    array('help' => __('Select this if you want to confirm every single booking'))
                ); ?>
            </div>
            <div class="col-md-6">
                <?php $this->row_input_page('thankyou', __('Thank you page', 'sln')); ?>
            </div>
        </div>
    </div>