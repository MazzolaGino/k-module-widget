<?php

namespace KModuleWidget\Lib;

class ReleaseRepository
{
    private $table_name;

    public function __construct()
    {
        global $wpdb;

        $this->table_name = 'releases';
    }
    
    // Create
    public function create($data)
    {
        global $wpdb;

        $wpdb->insert(
            $this->table_name,
            array(
                'name' => $data['name'],
                'supports' => $data['supports'],
                'type' => $data['type'],
                'release_date' => $data['date'],
                'url' => $data['url']
            )
        );

        return $wpdb->insert_id;
    }

    // Read
    public function read($id)
    {
        global $wpdb;

        $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->table_name WHERE id = %d",
                $id
            ),
            ARRAY_A
        );

        return $result;
    }

    // Update
    public function update($id, $data)
    {
        global $wpdb;

        $wpdb->update(
            $this->table_name,
            array(
                'name' => $data['name'],
                'supports' => $data['supports'],
                'type' => $data['type'],
                'release_date' => $data['date'],
                'url' => $data['url']
            ),
            array('id' => $id)
        );
    }

    // Delete
    public function delete($id)
    {
        global $wpdb;

        $wpdb->delete(
            $this->table_name,
            array('id' => $id)
        );
    }

    // Find by name
    public function findByName($name)
    {
        global $wpdb;

        $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $this->table_name WHERE name = %s",
                $name
            ),
            ARRAY_A
        );

        return $result;
    }

    // List by release date
    public function listByReleaseDate(string $type)
    {
        global $wpdb;

        $result = $wpdb->get_results(
            "SELECT * FROM $this->table_name WHERE `type` like '$type' ORDER BY release_date",
            ARRAY_A
        );

        return $result;
    }
}
