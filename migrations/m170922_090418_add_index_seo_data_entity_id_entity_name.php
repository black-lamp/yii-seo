<?php

use yii\db\Migration;

class m170922_090418_add_index_seo_data_entity_id_entity_name extends Migration
{
    public function safeUp()
    {
        $this->createIndex('seo_data_entity_id_entity_name', 'seo_data', ['entity_id', 'entity_name']);
    }

    public function safeDown()
    {
        $this->dropIndex('seo_data_entity_id_entity_name', 'seo_data');
    }
}
