<?php
class ModelLocalisationDistrict extends Model {
    public function getDistrict($province_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "district WHERE province_id = '" . (int)$province_id . "' AND status = '1'");
        return $query->row;
    }

    public function getDistrictByProvinceId($province_id) {
        $district_data = $this->cache->get('district.' . (int)$province_id);

        if (!$district_data) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "district WHERE province_id = '" . (int)$province_id . "' AND status = '1' ORDER BY name");

            $district_data = $query->rows;

            $this->cache->set('district.' . (int)$province_id, $district_data);
        }

        return $district_data;
    }
}