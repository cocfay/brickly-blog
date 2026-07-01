<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../common/config/bootstrap.php';

$config = require __DIR__ . '/../common/config/main.php';
unset($config['components']['urlManagerCpanel']);

(new \yii\web\Application($config));

use common\models\PostBlog;
use yii\helpers\Inflector;

echo "<pre>Generando slugs...\n\n";

$posts = PostBlog::find()->where(['Slug' => null])->orWhere(['Slug' => ''])->all();
$count = count($posts);
echo "Posts sin slug: $count\n\n";

foreach ($posts as $post) {
    $title = $post->title ?: $post->VTitle ?: "post-$post->PostBlogID";
    $baseSlug = Inflector::slug($title);
    $slug = $baseSlug;
    $counter = 1;
    while (PostBlog::find()->where(['Slug' => $slug])->andWhere(['!=', 'PostBlogID', $post->PostBlogID])->exists()) {
        $slug = $baseSlug . '-' . ++$counter;
    }
    $post->Slug = $slug;
    if ($post->save(false)) {
        echo "OK: #$post->PostBlogID -> $slug\n";
    } else {
        echo "ERROR: #$post->PostBlogID -> " . json_encode($post->getErrors()) . "\n";
    }
}

echo "\nListo.\n</pre>";
