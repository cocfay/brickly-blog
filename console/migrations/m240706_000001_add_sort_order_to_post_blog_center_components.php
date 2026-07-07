<?php

use yii\db\Migration;

class m240706_000001_add_sort_order_to_post_blog_center_components extends Migration
{
    public function up()
    {
        $this->addColumn('{{%PostBlogCenterComponents}}', 'SortOrder', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('{{%PostBlogCenterComponents}}', 'SortOrder');
    }
}
