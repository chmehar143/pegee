<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function firstname($firstname) {
        return $this->whereBeginsWith('first_name', $firstname);
    }

    public function lastname($lastname) {
        return $this->whereBeginsWith('lastname', $lastname);
    }

    public function email($email) {
        return $this->where('email', $email);
    }

    public function phoneno($phoneno) {
        return $this->whereBeginsWith('phone_no', $phoneno);
    }

    public function gender($gender) {
        return $this->where('gender', $gender);
    }

    public function status($status) {
        return $this->where('status', $status);
    }

}
