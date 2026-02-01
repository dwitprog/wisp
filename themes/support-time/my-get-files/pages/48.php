<section class="page-48 contacts" data-header-theme="white">
    <div class="container">
        <h1 class="section-title"><?php the_field('page_title'); ?></h1>
        <div class="mail-and-tel">
            <a href="mailto:<?php the_field('contacts_email'); ?>"
               class="mail"><?php the_field('contacts_email'); ?></a>
            <a href="tel:<?php the_field('contacts_tel'); ?>" class="tel"><?php the_field('contacts_tel'); ?></a>
        </div>
        <?php if (have_rows('social')) : ?>
            <div class="socials">
                <p class="title">Social:</p>
                <div class="socials-items">
                    <?php while (have_rows('social')) : the_row(); ?>
                        <?php if (have_rows('social_item')) : ?>
                            <?php while (have_rows('social_item')) : the_row(); ?>
                                <a href="<?php the_sub_field('social_link'); ?>" class="social-item">
                                    <?php the_sub_field('social_title'); ?>
                                </a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <?php if (have_rows('contacts_images')) : ?>
        <picture class="image">
            <?php while (have_rows('contacts_images')) : the_row(); ?>
                <?php if (get_sub_field('contacts_image_768')) : ?>
                    <source media="(max-width:767.98px)"
                            srcset="<?php the_sub_field('contacts_image_768'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('contacts_image_992')) : ?>
                    <source media="(max-width:991.98px)"
                            srcset="<?php the_sub_field('contacts_image_992'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('contacts_image_1200')) : ?>
                    <source media="(max-width:1199.98px)"
                            srcset="<?php the_sub_field('contacts_image_1200'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('contacts_image_1400')) : ?>
                    <source media="(max-width:1399.98px)"
                            srcset="<?php the_sub_field('contacts_image_1400'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('contacts_image_full')) : ?>
                    <img src="<?php the_sub_field('contacts_image_full'); ?>"
                         alt="<?php the_field('page_title'); ?>">
                <?php endif ?>
            <?php endwhile; ?>
        </picture>
    <?php endif; ?>
</section>
