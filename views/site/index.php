<?php
/**
 * @var string $message
 * @var string $title
 * @var array $latestProducts
 */
?>

<section class="home d-flex flex-column">
    <div class="home-title">
        <a href="#" class="home-btn mt-4">ALL PRODUCTS</a>
    </div>
    <div class="home-recomendation">
        <div class="rec-title">
            <h3><span>Popular Accessories</span></h3>
        </div>
    </div>
    <div class="home-cards d-flex gap-4">
<!--        {% for product in products %}-->
        <a href="" class="home-card d-flex flex-column align-items-center text-center">
            <img src="" class="card-img" alt="">
            <h5 class="title-card">
<!--                {{ product.name }}-->
            </h5>
<!--            {% if product.discount %}-->
            <div class="cart-discount d-flex gap-2">
                <p class="line">$
<!--                    {{ product.price }}-->
                </p>
                <p class="price pt-2">$
<!--                    {{ product.sell_price }}-->
                </p>
            </div>
<!--            {% else %}-->
            <p class="price">$
<!--                {{ product.price }}-->
            </p>
<!--            {% endif %}-->
        </a>
<!--        {% endfor %}-->
    </div>
</section>
<img src="/static/img/logogot.png" class="logogothic" alt="">
<img src="/static/img/subtitlee.png" class="subtitlee" alt="">
