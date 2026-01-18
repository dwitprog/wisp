<section class="page-46 banner">
    <div class="container">
        <div class="offer">
            <h1 class="title color-white"><?php the_field('banner_title'); ?></h1>
            <p class="desc color-white">
                <?php the_field('banner_text'); ?>
            </p>
        </div>
        <div class="coordinates-wrapper">
            <div class="coordinates">
                <div class="line-top coordinate-axis">
                    <span class="line"></span>
                    <span class="label">
                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M5.34569 16.384C2.84969 18.7307 1.24969 19.904 0.545687 19.904C0.183021 19.904 0.00168747 19.6587 0.00168747 19.168C0.00168747 18.6774 0.193687 17.9627 0.577687 17.024C0.961687 16.0854 1.34569 15.264 1.72969 14.56L2.30569 13.536C3.92702 10.6987 5.15369 8.66137 5.98569 7.42404C6.34835 6.8907 6.80702 6.4427 7.36169 6.08004C7.93769 5.69604 8.47102 5.50404 8.96169 5.50404C9.13235 5.50404 9.21769 5.5787 9.21769 5.72804C9.21769 5.8347 9.14302 6.03737 8.99369 6.33604C8.73769 6.80537 8.10835 7.92537 7.10569 9.69604C6.10302 11.4667 5.50569 12.5334 5.31369 12.896C4.43902 14.432 4.00169 15.456 4.00169 15.968C4.00169 16.16 4.06569 16.256 4.19369 16.256C4.40702 16.256 5.08969 15.7227 6.24169 14.656C7.13769 13.76 8.32169 12.4694 9.79369 10.784C9.85769 10.72 9.91102 10.688 9.95369 10.688C9.99635 10.688 10.0177 10.7307 10.0177 10.816C10.0177 11.2214 9.85769 11.616 9.53769 12C7.95902 13.7494 6.56169 15.2107 5.34569 16.384ZM9.60169 3.68004C9.06835 3.68004 8.80169 3.36004 8.80169 2.72004C8.80169 2.1227 9.02569 1.52537 9.47369 0.928036C9.92169 0.309369 10.4124 3.62396e-05 10.9457 3.62396e-05C11.5857 3.62396e-05 11.9057 0.362703 11.9057 1.08804C11.9057 1.68537 11.6604 2.27204 11.1697 2.84804C10.679 3.4027 10.1564 3.68004 9.60169 3.68004Z"
                                fill="white"/>
                    </svg>

                </span>
                </div>
                <div class="line-right coordinate-axis">
                    <span class="line"></span>
                    <span class="label">
                    R
                </span>
                </div>
            </div>
            <?php if (have_rows('coordinates_list')) : ?>
                <div class="items">
                    <?php while (have_rows('coordinates_list')) : the_row(); ?>
                        <?php if (have_rows('coordinates_item_1')) : ?>
                            <?php while (have_rows('coordinates_item_1')) : the_row(); ?>
                                <div class="item">
                                    <div class="content">
                                        <p class="title">
                                            <?php the_sub_field('coordinates_item_1_title'); ?>
                                        </p>
                                        <p class="desc">
                                            <?php the_sub_field('coordinates_item_1_text'); ?>
                                        </p>
                                    </div>
                                    <span class="line"></span>
                                    <span class="number">1</span>
                                </div>


                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if (have_rows('coordinates_item_2')) : ?>
                            <?php while (have_rows('coordinates_item_2')) : the_row(); ?>
                                <div class="item">
                                    <div class="content">
                                        <p class="title">
                                            <?php the_sub_field('coordinates_item_2_title'); ?>
                                        </p>
                                        <p class="desc">
                                            <?php the_sub_field('coordinates_item_2_text'); ?>
                                        </p>
                                    </div>
                                    <span class="line"></span>
                                    <span class="number">2</span>
                                </div>


                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if (have_rows('coordinates_item_3')) : ?>
                            <?php while (have_rows('coordinates_item_3')) : the_row(); ?>
                                <div class="item">
                                    <div class="content">
                                        <p class="title">
                                            <?php the_sub_field('coordinates_item_3_title'); ?>
                                        </p>
                                        <p class="desc">
                                            <?php the_sub_field('coordinates_item_3_text'); ?>
                                        </p>
                                    </div>
                                    <span class="line"></span>
                                    <span class="number">3</span>
                                </div>


                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if (have_rows('coordinates_item_4')) : ?>
                            <?php while (have_rows('coordinates_item_4')) : the_row(); ?>
                                <div class="item">
                                    <div class="content">
                                        <p class="title">
                                            <?php the_sub_field('coordinates_item_4_title'); ?>
                                        </p>
                                        <p class="desc">
                                            <?php the_sub_field('coordinates_item_4_text'); ?>
                                        </p>
                                    </div>
                                    <span class="line"></span>
                                    <span class="number">4</span>
                                </div>


                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>
<section class="page-46 how-we-work">
    <h2 class="section-title"><?php the_field('how_we_work_section_title'); ?></h2>
    <div class="stages">
        <div class="line-container">
            <div class="line">
                <span class="step step_1"></span>
                <span class="step step_2"></span>
                <span class="step step_3"></span>
            </div>
            <span class="circle">
                    <span>
                        <span></span>
                    </span>
                </span>
        </div>
        <div class="items">
            <?php if (have_rows('how_we_work_list')) : ?>
                <?php $item_counter = 0; ?>
                <?php while (have_rows('how_we_work_list')) : the_row(); ?>
                    <?php if (have_rows('how_we_work_item')) : ?>
                        <?php while (have_rows('how_we_work_item')) : the_row(); ?>
                            <div class="item <?php echo $item_counter === 0 ? ' active' : ''; ?>">
                                <span class="step"></span>
                                <p class="title"><?php the_sub_field('how_we_work_title'); ?></p>
                                <p class="desc">
                                    <?php the_sub_field('how_we_work_text'); ?>
                                </p>
                            </div>


                            <?php
                            $item_counter++;
                        endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>
    <div class="service-knob">
        <picture class="image">
            <source media="(max-width:767.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/service-knob-768.png">
            <source media="(max-width:991.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/service-knob-992.png">
            <source media="(max-width:1199.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/service-knob-1200.png">
            <img src="/wp-content/themes/support-time/assets/img/pages/7/service-knob.png" class="knob "
                 alt="Knob">
        </picture>
        <img src="/wp-content/themes/support-time/assets/img/pages/7/line.png" class="line" alt="Lines">
    </div>
</section>
