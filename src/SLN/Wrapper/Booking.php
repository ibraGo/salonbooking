<?php

class SLN_Wrapper_Booking extends SLN_Wrapper_Abstract
{
    function getAmount()
    {
        $post_id = $this->getId();
        $ret     = apply_filters('sln_booking_amount', get_post_meta($post_id, '_sln_booking_amount', true));
        $ret     = empty($ret) ? 0 : floatval($ret);

        return $ret;
    }

    function getDeposit()
    {
        $post_id = $this->getId();
        $ret     = apply_filters('sln_booking_deposit', get_post_meta($post_id, '_sln_booking_deposit', true));
        $ret     = empty($ret) ? 0 : floatval($ret);

        return $ret;
    }

    function getToPayAmount(){
        return $this->getDeposit() > 0 ? $this->getDeposit() : $this->getAmount();
    }

    function getFirstname()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_firstname', get_post_meta($post_id, '_sln_booking_firstname', true));
    }

    function getLastname()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_lastname', get_post_meta($post_id, '_sln_booking_lastname', true));
    }
    function getDisplayName(){
        return $this->getFirstname().' '.$this->getLastname();
    }
    function getEmail()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_email', get_post_meta($post_id, '_sln_booking_email', true));
    }

    function getPhone()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_phone', get_post_meta($post_id, '_sln_booking_phone', true));
    }

    function getAddress()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_address', get_post_meta($post_id, '_sln_booking_address', true));
    }


    function getTime()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_time', new SLN_DateTime(get_post_meta($post_id, '_sln_booking_time', true)));
    }

    function getDate()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_date', new SLN_DateTime(get_post_meta($post_id, '_sln_booking_date', true)));
    }

    function getBookingServices()
    {
        $this->maybeProcessBookingServices();

        $post_id = $this->getId();
        $data = apply_filters('sln_booking_services', get_post_meta($post_id, '_sln_booking_services', true));
        $data = empty($data) ? array() : $data;
        $ret = new SLN_Wrapper_Booking_Services($data);

        return $ret;
    }

    function maybeProcessBookingServices()
    {
        $post_id = $this->getId();
        $servicesProcessed = apply_filters('sln_booking_services_processed', get_post_meta($post_id, '_sln_booking_services_processed', true));

        if(empty($servicesProcessed)){
            $this->evalBookingServices();
        }
    }

    function evalBookingServices()
    {
        $post_id = $this->getId();
        $data    = get_post_meta($post_id, '_sln_booking_services', true);
        $data    = empty($data) ? array() : $data;

        $bookingServices = SLN_Wrapper_Booking_Services::build($data, $this->getStartsAt());
        $ret = $bookingServices->toArrayRecursive();

        update_post_meta($post_id, '_sln_booking_services', $ret);
        update_post_meta($post_id, '_sln_booking_services_processed', 1);
    }

    function getDuration()
    {
        $post_id = $this->getId();
        $ret     = apply_filters('sln_booking_duration', get_post_meta($post_id, '_sln_booking_duration', true));

        if(empty($ret)){
            $ret = '00:00';
        }
        $ret     = SLN_Func::filter($ret, 'time');
        if($ret == '00:00'){
            $ret = $this->evalDuration();
        } 
        return new SLN_DateTime('1970-01-01 ' . $ret);
    }

    function evalDuration(){
//        $this->maybeProcessBookingServices();
        $h = 0;
        $i = 0;
        SLN_Plugin::addLog(__CLASS__.' eval duration of'.$this->getId());
        // TODO: refactoring 'getServices()' to 'getBookingServices()'
        foreach($this->getServices() as $s){
            $d = $s->getDuration();
            $h = $h + intval($d->format('H'));
            $i = $i + intval($d->format('i'));
            SLN_Plugin::addLog(' - service '.$s.' +'.$d->format('H:i'));
        }
        $i += $h*60;
        if($i == 0)
            $i = 60;
        $str = SLN_Func::convertToHoursMins($i);
        update_post_meta($this->getId(), '_sln_booking_duration', $str);
        return $str;
    }

    function evalTotal(){
        $t = 0;
        SLN_Plugin::addLog(__CLASS__.' eval total of'.$this->getId());
        foreach($this->getServices() as $s){
            $d = $s->getPrice();
            $t += $d;
            SLN_Plugin::addLog(' - service '.$s.' +'.$d);
        }
        update_post_meta($this->getId(), '_sln_booking_amount', $t);
        return $t;
    }


    function hasAttendant(SLN_Wrapper_Attendant $attendant)
    {
        return in_array($attendant->getId(), $this->getAttendantsIds());
    }

    function hasService(SLN_Wrapper_Service $service)
    {
        return in_array($service->getId(), $this->getServicesIds());
    }

	/**
     * @param bool|false $unique
     *
     * @return array
     */
    function getAttendantsIds($unique = false){
        $post_id = $this->getId();
        $data     = apply_filters('sln_booking_attendants', get_post_meta($post_id, '_sln_booking_services', true));
        $ret = array();
        if(is_array($data)) {
            foreach($data as $item) {
                $ret[$item['service']] = $item['attendant'];
            }
        }
        return $unique ? array_unique($ret) : $ret;
    }

    /**
     * @return SLN_Wrapper_Attendant|false
     */
    function getAttendant(){
        $atts_ids = $this->getAttendantsIds();
        $att = reset($atts_ids);
        if ($att !== false) {
            $tmp = new SLN_Wrapper_Attendant($att);
            if(!$tmp->isEmpty()){
                return $tmp;
            }
        }
        return false;
    }

    /**
     * @param bool $unique
     *
     * @return SLN_Wrapper_Attendant[]
     */
    function getAttendants($unique = false){
        $ret = array();
        $attIds = $this->getAttendantsIds($unique);
        foreach($attIds as $service_id => $id){
            $tmp = new SLN_Wrapper_Attendant($id);
            if(!$tmp->isEmpty()){
                $ret[$service_id] = $tmp;
            }
        }
        return $ret;
    }
    function getServicesIds()
    {
        $post_id = $this->getId();
        $data     = apply_filters('sln_booking_services', get_post_meta($post_id, '_sln_booking_services', true));
        $ret = array();
        if(is_array($data)) {
            foreach($data as $item) {
                $ret[] = $item['service'];
            }
        }
        return $ret;
    }

	/**
     * @return SLN_Wrapper_Service[]
     */
    function getServices(){
        $ret = array();
        foreach($this->getServicesIds() as $id){
            $tmp = new SLN_Wrapper_Service($id);
            if(!$tmp->isEmpty()){
                $ret[] = $tmp;
            }
        }
        return $ret;
    }

    function getStatus()
    {
        return $this->object->post_status;
    }

    function hasStatus($status)
    {
        return SLN_Func::has($this->getStatus(),$status);
    }

    /**
     * @param $status
     * @return $this
     */
    function setStatus($status)
    {
        $post = array();
        $post['ID'] = $this->getId();
        $post['post_status'] = $status;
        wp_update_post( $post );
        return $this;
    }

    function getTitle()
    {
        return $this->object->post_title;
    }

    function getNote()
    {
        $post_id = $this->getId();

        return apply_filters(
            'sln_booking_note',
            get_post_meta($post_id, '_sln_booking_note', true)
        );
    }
    function getAdminNote()
    {
        $post_id = $this->getId();

        return apply_filters(
            'sln_booking_admin_note',
            get_post_meta($post_id, '_sln_booking_admin_note', true)
        );
    }


    function getTransactionId()
    {
        $post_id = $this->getId();

        return apply_filters(
            'sln_booking_transaction_id',
            get_post_meta($post_id, '_sln_booking_transaction_id', true)
        );
    }
    function getStartsAt(){
        return new SLN_DateTime($this->getDate()->format('Y-m-d').' '.$this->getTime()->format('H:i'));
    }
    function getEndsAt(){
        $start = $this->getStartsAt(); 
        //SLN_Plugin::addLog($this->getId().' duration '.$this->getDuration()->format('H:i'));
        $minutes = SLN_Func::getMinutesFromDuration($this->getDuration());
        //SLN_Plugin::addLog($this->getId().' duration '.$minutes.' minutes');
        if($minutes == 0) $minutes = 60;
        $start->modify('+'.$minutes.' minutes');
        return $start;
    }

    function getRemind()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_remind', get_post_meta($post_id, '_sln_booking_remind', true));
    }

    function setRemind($remind)
    {
        $post_id = $this->getId();

        update_post_meta($post_id, '_sln_booking_remind', $remind);
    }

    function getEmailRemind()
    {
        $post_id = $this->getId();

        return apply_filters('sln_booking_email_remind', get_post_meta($post_id, '_sln_booking_email_remind', true));
    }

    function setEmailRemind($remind)
    {
        $post_id = $this->getId();

        update_post_meta($post_id, '_sln_booking_email_remind', $remind);
    }

    public function getUserData(){
        $this->object->post_author ? get_userdata($this->object->post_author) : null; 
    }
    public function getUserDisplayName(){
        $this->getUserData() ? $this->getUserData()->display_name : '';
    }
    public function getUserId(){
        return $this->object->post_author;
    }

    function isNew()
    {
        return strpos($this->object->post_status, 'sln-b-') !== 0;
    }

    public function markPaid($transactionId){
        update_post_meta($this->getId(), '_sln_booking_transaction_id', $transactionId);
        $this->setStatus(SLN_Enum_BookingStatus::PAID);
    }
    public function getPayUrl(){
        return add_query_arg(
            array(
               'sln_step_page' => 'thankyou',
               'submit_thankyou' => 1,
               'sln_booking_id' => $this->getUniqueId()
            ),
            get_permalink( SLN_Plugin::getInstance()->getSettings()->get('pay'))
        );
    }
    public function getUniqueId(){
        $id = get_post_meta($this->getId(), '_sln_booking_uniqid', true);
        if(!$id){
            $id = md5(uniqid().$this->getId());
            update_post_meta($this->getId(), '_sln_booking_uniqid', $id);
        }
        return $this->getId().'-'.$id;
    }

    // algolplus start
    public function getRating()
    {
        return get_post_meta($this->getId(), '_sln_booking_rating', true);
    }
    public function setRating($rating)
    {
        return update_post_meta($this->getId(), '_sln_booking_rating', $rating);
    }
    // algolplus end
}
