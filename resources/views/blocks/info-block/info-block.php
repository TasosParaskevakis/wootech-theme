<?php
$attributes = $attributes ?? [];

$title = $attributes['title'] ?? 'Default Title';
$tagline = $attributes['tagline'] ?? 'Short Description';
$description = $attributes['description'] ?? 'Detailed description of the block';
$image = $attributes['image'] ?? '';
$url = $attributes['url'] ?? '#';
$position = $attributes['position'] ?? 'left';
?>

<div class="info-block <?= esc_attr($position); ?>">
  <?php if ($image): ?>
    <img src="<?= esc_url($image); ?>" alt="Info Image">
  <?php endif; ?>
  <div class="info-content">
    <h2><?= esc_html($title); ?></h2>
    <p><?= esc_html($tagline); ?></p>
    <p><?= esc_html($description); ?></p>
    <a href="<?= esc_url($url); ?>">Learn More</a>
  </div>
</div>