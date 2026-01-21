<section class="page-44 faq">
    <div class="container">
        <div class="faq-content">
            <div class="slider">
                <div class="slider-line">
                    <div class="slider-fader">
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="items">
                <?php if (have_rows('faq_items')) : ?>
                    <?php $item_faq_counter = 0; ?>
                    <?php while (have_rows('faq_items')) : the_row(); ?>
                        <?php if (have_rows('faq_item')) : ?>
                            <?php while (have_rows('faq_item')) : the_row(); ?>
                                <div class="item <?php echo $item_faq_counter === 0 ? ' active' : ''; ?>">
                                    <p class="title">
                                        <?php the_sub_field('faq_item_title'); ?>

                                    </p>
                                    <div class="content">
                                        <p class="desc">
                                            <?php the_sub_field('faq_item_text'); ?>
                                        </p>
                                        <a href="<?php the_sub_field('faq_item_link'); ?>" class="link">Learn more about
                                            this point</a>
                                        <button class="btn btn-gradient openPopup" data-pop="popupForm">CONTACT us</button>
                                    </div>
                                </div>
                                <?php $item_faq_counter++; ?>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>