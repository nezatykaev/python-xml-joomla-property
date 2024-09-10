<?php
$data = json_decode(file_get_contents('php://input'), true);
$conn = new PDO('mysql:host=localhost;dbname=sunnyl_DB_ffproperty;charset=utf8', 'sunnyl_USER_lion_max', '+fKYhH{hWVK@');

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties (type, category, commercial_type, creation_date, last_update_date, manually_added, mortgage, haggle, description, new_flat, floor, floors_total, building_name, building_type, building_state, building_phase, building_section, built_year, ready_quarter, lift, parking, ceiling_height, nmarket_complex_id, nmarket_building_id, electric_capacity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
$stmt->execute([
    $data['type'], 
    $data['category'], 
    $data['commercial-type'],
    $data['creation-date'], 
    $data['last-update-date'],
    $data['manually-added'],
    $data['mortgage'],
    $data['haggle'],
    $data['description'],
    $data['new-flat'],
    $data['floor'],
    $data['floors-total'],
    $data['building-name'],
    $data['building-type'],
    $data['building-state'],
    $data['building-phase'],
    $data['building-section'],
    $data['built-year'],
    $data['ready-quarter'],
    $data['lift'],
    $data['parking'],
    $data['ceiling-height'],
    $data['nmarket-complex-id'],
    $data['nmarket-building-id'],
    $data['electric-capacity']
]);
$propertie_id = $conn->lastInsertId();

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_sales_agent (phone, organization, email, category, propertie_id) VALUES (?, ?, ?, ?, ?);');
$stmt->execute([
    $data['sales-agent']['phone'],
    $data['sales-agent']['organization'],
    $data['sales-agent']['email'],
    $data['sales-agent']['category'],
    $propertie_id
]);

foreach ($data['image'] as &$img) {
    $stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_image (image, propertie_id) VALUES (?, ?);');
    $stmt->execute([
        $img,
        $propertie_id
    ]);

}

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_kitchen_space (value, unit, propertie_id) VALUES (?, ?, ?);');
$stmt->execute([
    $data['kitchen-space']['value'],
    $data['kitchen-space']['unit'],
    $propertie_id
]);

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_living_space (value, unit, propertie_id) VALUES (?, ?, ?);');
$stmt->execute([
    $data['living-space']['value'],
    $data['living-space']['unit'],
    $propertie_id
]);

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_area (value, unit, propertie_id) VALUES (?, ?, ?);');
$stmt->execute([
    $data['area']['value'],
    $data['area']['unit'],
    $propertie_id
]);

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_price (value, currency, propertie_id) VALUES (?, ?, ?);');
$stmt->execute([
    $data['price']['value'],
    $data['price']['currency'],
    $propertie_id
]);

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_location (country, region, locality_name, sub_locality_name, non_admin_sub_locality, address, apartment, latitude, longitude, propertie_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
$stmt->execute([
    $data['location']['country'],
    $data['location']['region'],
    $data['location']['locality-name'],
    $data['location']['sub-locality-name'],
    $data['location']['non-admin-sub-locality'],
    $data['location']['address'],
    $data['location']['apartment'],
    $data['location']['latitude'],
    $data['location']['longitude'],
    $propertie_id
]);
$location_id = $conn->lastInsertId();

$stmt = $conn->prepare('INSERT INTO r82aw_spproperty_properties_metro (name, time_on_foot, location_id) VALUES (?, ?, ?);');
$stmt->execute([
    $data['location']['metro']['name'],
    $data['location']['metro']['time-on-foot'],
    $location_id
]);
?>