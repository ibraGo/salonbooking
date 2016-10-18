<?php if(isset($manageBookingsLink) && $manageBookingsLink && $plugin->getSettings()->getBookingmyaccountPageId()): ?>
    <?php $forAdmin = isset($forAdmin) ? $forAdmin : false; ?>
    <?php if(isset($customer) || (!$forAdmin && isset($booking) && ($customer = $booking->getCustomer()))): ?>
        <tr style="font-family: Arial, Helvetica, sans-serif; color: #888;">
            <td height="80" valign="middle" bgcolor="#f2f2f2">
                <hr style="border: solid 1px #fff; margin: 0 16px;">
                <table width="502" border="0" align="left" cellpadding="0" cellspacing="0"  style="margin-left: 49px; margin-right: 49px;">
                    <tbody>
                    <tr>
                        <td width="272" align="center" valign="middle">
                            <p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#666666; font-weight:normal;">
                                <?php
                                _e('Manage your reservations accessing your personal page', 'salon-booking-system');
                                ?>
                            </p>
                        </td>

                        <td align="right" valign="top">
                            <p style="padding-left: 20px;">
                                <a href="<?php echo home_url().'/'.$customer->generateHash(); ?>"style="
                                                text-transform: uppercase;
                                                display: inline-block;
                                                padding: 10px 20px;
                                                margin-bottom: 0;
                                                font-size: 12px;
                                                font-weight: 400;
                                                line-height: 1.42857143;
                                                text-align: center;
                                                white-space: nowrap;
                                                vertical-align: middle;
                                                -ms-touch-action: manipulation;
                                                touch-action: manipulation;
                                                cursor: pointer;
                                                -webkit-user-select: none;
                                                -moz-user-select: none;
                                                -ms-user-select: none;
                                                user-select: none;
                                                background-image: none;
                                                border: 1px solid transparent;
                                                border-radius: 3px;
                                                color: #fff;
                                                background-color: #0d569f;
                                                text-decoration: none;"><?php _e('Manage Bookings','salon-booking-system'); ?></a>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    <?php endif; ?>
<?php endif; ?>

<tr style="font-family: Arial, Helvetica, sans-serif; color: #888;">
    <td height="60" align="middle" valign="middle" bgcolor="#f2f2f2">
        <hr style="border: solid 1px #fff; margin: 0 16px;">
        <p style="margin-left: 49px; margin-right: 49px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#666666;"><?php _e('Booking system is provided by <b>Salon Booking Wordpress Plugin</b>','salon-booking-system'); ?></p>
    </td>
</tr>

</table>
</body>
</html>