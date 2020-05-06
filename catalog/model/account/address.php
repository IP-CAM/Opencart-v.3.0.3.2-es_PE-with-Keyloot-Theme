<?php
class ModelAccountAddress extends Model {
    private function sql_update($table,$where,$data,$fields){
		$cols = array();
        foreach($fields as $field){
            if (array_key_exists($field,$data)){
                $cols[] = "$field = '".$this->db->escape($data[$field])."'";
            }
        }
		$sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";
		return $sql;
	}
    private function sql_insert($tablename,$data,$fields){
        $f = array();
        foreach($fields as $field){
            if (array_key_exists($field,$data)){
                $f[$field] = $this->db->escape($data[$field]);
            }
        }
        $key = array_keys($f);
        $val = array_values($f);
        $query = "INSERT INTO {$tablename} (" . implode(', ', $key) . ") "
                 . "VALUES ('" . implode("', '", $val) . "')";
        return $query;

    }
	public function addAddress($customer_id, $data) {
	    $fields = [
            'customer_id',
            'firstname',
            'lastname',
            'company',
            'address_1',
            'address_2',
            'postcode',
            'city',
            'zone_id',
            'country_id',
            'province_id',
            'district_id',
        ];
        $data['customer_id'] = (int)$customer_id;
	    $sql_insert = $this->sql_insert(DB_PREFIX . "address",$data,$fields);
        $this->db->query($sql_insert);
		$address_id = $this->db->getLastId();
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '') . "' WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

		if (!empty($data['default'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		}

		return $address_id;
	}

	public function editAddress($address_id, $data) {
	    $fields = [
            'firstname',
            'lastname',
            'company',
            'address_1',
            'address_2',
            'postcode',
            'city',
            'zone_id',
            'country_id',
            'province_id',
            'district_id',
        ];
	    $sql_update = $this->sql_update(DB_PREFIX . "address","address_id  = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'",$data,$fields);
        $this->db->query($sql_update);
		$this->db->query("UPDATE " . DB_PREFIX . "address SET custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '') . "' WHERE address_id  = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
		if (!empty($data['default'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}
	}

	public function deleteAddress($address_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

            $province_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "province` WHERE province_id = '" . (int)$address_query->row['province_id'] . "'");

			if ($province_query->num_rows) {
				$province = $province_query->row['name'];
				$province_code = $province_query->row['code'];
			} else {
				$province = '';
				$province_code = '';
			}

            $district_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "district` WHERE district_id = '" . (int)$address_query->row['district_id'] . "'");

			if ($district_query->num_rows) {
				$district = $district_query->row['name'];
				$district_code = $district_query->row['code'];
				$district_ubigeo = $district_query->row['ubigeo'];
			} else {
				$district = '';
				$district_code = '';
				$district_ubigeo = '';
			}


			$address_data = array(
				'address_id'     => $address_query->row['address_id'],
				'firstname'      => $address_query->row['firstname'],
				'lastname'       => $address_query->row['lastname'],
				'company'        => $address_query->row['company'],
				'address_1'      => $address_query->row['address_1'],
				'address_2'      => $address_query->row['address_2'],
				'postcode'       => $address_query->row['postcode'],
				'city'           => $address_query->row['city'],
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
                'province_id'    => $address_query->row['province_id'],
				'province'       => $province,
				'province_code'  => $province_code,
                'district_id'    => $address_query->row['district_id'],
				'district'       => $district,
				'district_code'  => $district_code,
				'district_ubigeo'=> $district_ubigeo,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format,
				'custom_field'   => json_decode($address_query->row['custom_field'], true)
			);

			return $address_data;
		} else {
			return false;
		}
	}

	public function getAddresses() {
		$address_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		foreach ($query->rows as $result) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$result['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$result['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}

            $province_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "province` WHERE province_id = '" . (int)$result['province_id'] . "'");

			if ($province_query->num_rows) {
				$province = $province_query->row['name'];
				$province_code = $province_query->row['code'];
			} else {
				$province = '';
				$province_code = '';
			}

            $district_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "district` WHERE district_id = '" . (int)$result['district_id'] . "'");

			if ($district_query->num_rows) {
				$district = $district_query->row['name'];
				$district_code = $district_query->row['code'];
				$district_ubigeo = $district_query->row['ubigeo'];
			} else {
				$district = '';
				$district_code = '';
				$district_ubigeo = '';
			}

			$address_data[$result['address_id']] = array(
				'address_id'     => $result['address_id'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'company'        => $result['company'],
				'address_1'      => $result['address_1'],
				'address_2'      => $result['address_2'],
				'postcode'       => $result['postcode'],
				'city'           => $result['city'],
				'zone_id'        => $result['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
                'province_id'    => $result['province_id'],
				'province'       => $province,
				'province_code'  => $province_code,
                'district_id'    => $result['district_id'],
				'district'       => $district,
				'district_code'  => $district_code,
				'district_ubigeo'=> $district_ubigeo,
				'country_id'     => $result['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format,
				'custom_field'   => json_decode($result['custom_field'], true)

			);
		}

		return $address_data;
	}

	public function getTotalAddresses() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->row['total'];
	}
}
