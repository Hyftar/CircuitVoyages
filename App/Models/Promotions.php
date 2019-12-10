<?php

namespace app\Models;

use PDO;

class Promotions extends \Core\Model
{
    protected $id;
    protected $start_date;
    protected $end_date;
    protected $promotion_type_id;
    protected $promo_code;
    protected $value;
    protected $description;
    protected $availability_number;

    public function __construct($id,$start_date,$end_date,$promotion_type_id,$promo_code,$value,$description,$availability_number)
    {
        $this->id = $id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->promotion_type_id = $promotion_type_id;
        $this->promo_code = $promo_code;
        $this->value = $value;
        $this->description = $description;
        $this->availability_number = $availability_number;
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of start_date
     */
    public function getStart_date()
    {
        return $this->start_date;
    }

    /**
     * Set the value of start_date
     *
     * @return  self
     */
    public function setStart_date($start_date)
    {
        $this->start_date = $start_date;

        return $this;
    }

    /**
     * Get the value of end_date
     */
    public function getEnd_date()
    {
        return $this->end_date;
    }

    /**
     * Set the value of end_date
     *
     * @return  self
     */
    public function setEnd_date($end_date)
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * Get the value of promotion_type_id
     */
    public function getPromotion_type_id()
    {
        return $this->promotion_type_id;
    }

    /**
     * Set the value of promotion_type_id
     *
     * @return  self
     */
    public function setPromotion_type_id($promotion_type_id)
    {
        $this->promotion_type_id = $promotion_type_id;

        return $this;
    }

    /**
     * Get the value of promo_code
     */
    public function getPromo_code()
    {
        return $this->promo_code;
    }

    /**
     * Set the value of promo_code
     *
     * @return  self
     */
    public function setPromo_code($promo_code)
    {
        $this->promo_code = $promo_code;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of availability_number
     */
    public function getAvailability_number()
    {
        return $this->availability_number;
    }

    /**
     * Set the value of availability_number
     *
     * @return  self
     */
    public function setAvailability_number($availability_number)
    {
        $this->availability_number = $availability_number;

        return $this;
    }
}
