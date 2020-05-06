<?php
class ModelLocalisationProvince extends Model {
    public function getProvince($province_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "province WHERE province_id = '" . (int)$province_id . "' AND status = '1'");
        return $query->row;
    }

    public function getProvinceByZoneId($zone_id) {
        $province_data = $this->cache->get('province.' . (int)$zone_id);

        if (!$province_data) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "province WHERE zone_id = '" . (int)$zone_id . "' AND status = '1' ORDER BY name");

            $province_data = $query->rows;

            $this->cache->set('province.' . (int)$zone_id, $province_data);
        }

        return $province_data;
    }
}