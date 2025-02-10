<?php
global $product;
$product_id = get_the_ID();
?>

<div class="search-item">
    <!-- Hình ảnh sản phẩm -->
    <img src="<?php echo get_the_post_thumbnail_url($product_id, 'thumbnail'); ?>" alt="<?php the_title(); ?>"
        class="search-item-image" />

    <div class="search-item-info">
        <!-- Tên sản phẩm -->
        <p class="search-item-title">
            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>">
                <?php the_title(); ?>
            </a>
        </p>

        <!-- Giá sản phẩm -->
        <div class="search-item-prices">
            <?php if ($product->is_on_sale()): ?>
                <!-- Hiển thị giá khuyến mãi -->
                <span class="price-current"><?php echo wc_price($product->get_sale_price()); ?></span>
                <!-- Hiển thị giá gốc -->
                <span class="price-old"><?php echo wc_price($product->get_regular_price()); ?></span>
            <?php else: ?>
                <!-- Hiển thị giá thường nếu không có giảm giá -->
                <span class="price-current"><?php echo $product->get_price_html(); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>