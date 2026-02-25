<section class="page-44 faq" data-header-theme="white">
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
                                        <div class="faq_item_text">
                                            <p class="desc"><?php the_sub_field('faq_item_text'); ?></p>
                                        </div>
                                        <div class="faq_item_text_detail" aria-hidden="true"><?php the_sub_field('faq_item_text_detail'); ?></div>
                                        <button type="button" class="link faq-learn-more">Learn more about this point</button>
                                        <button class="btn btn-gradient openPopup" data-pop="popupForm">CONTACT us
                                        </button>
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
