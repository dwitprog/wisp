<section class="page-48 contacts">
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
    <picture class="image">
        <source media="(max-width:991.98px)"
                srcset="/wp-content/themes/support-time/assets/img/pages/48/contacts-992.png">
        <source media="(max-width:1199.98px)"
                srcset="/wp-content/themes/support-time/assets/img/pages/48/contacts-1200.png">
        <img src="/wp-content/themes/support-time/assets/img/pages/48/contacts.png" alt="always in touch">
    </picture>
</section>
