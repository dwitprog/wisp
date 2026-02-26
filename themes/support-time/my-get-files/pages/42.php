<section class="page-42 platforms" data-header-theme="white">
    <div class="platforms-swiper-thumbs swiper">
        <?php if (have_rows('platforms')) : ?>
            <div class="swiper-wrapper">
                <?php while (have_rows('platforms')) : the_row(); ?>
                    <?php if (have_rows('platforms_item')) : ?>
                        <?php while (have_rows('platforms_item')) : the_row(); ?>
                            <div class="swiper-slide item">
                                <img src="<?php the_sub_field('platforms_logo_default'); ?>" class="default"
                                     alt="<?php the_sub_field('platforms_title'); ?>">
                                <img src="<?php the_sub_field('platforms_logo_hover'); ?>" class="active"
                                     alt="<?php the_sub_field('platforms_title'); ?>">
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <div class="navigation">
            <button class="swiper-prev swiper-btn">
                <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.0001 0.733643V11.6465M10.9062 1.87194V10.9448C10.9062 11.6168 10.1558 12.0369 9.55541 11.7008L1.45038 7.16442C0.85001 6.82839 0.850009 5.98831 1.45038 5.65228L9.55541 1.11588C10.1558 0.779845 10.9062 1.19988 10.9062 1.87194Z"
                        stroke="url(#paint0_linear_781_87989)" stroke-width="2" />
                    <defs>
                        <linearGradient id="paint0_linear_781_87989" x1="5.95318" y1="0.733643" x2="5.95318"
                                        y2="11.8191" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#130839" />
                            <stop offset="0.360577" stop-color="#282251" />
                            <stop offset="0.764423" stop-color="#793971" />
                            <stop offset="1" stop-color="#CC7897" />
                        </linearGradient>
                    </defs>
                </svg>
            </button>
            <div class="swiper-pagination"></div>
            <button class="swiper-next swiper-btn">
                <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.9061 0.733643V11.6465M1 1.87194V10.9448C1 11.6168 1.75047 12.0369 2.35084 11.7008L10.4559 7.16442C11.0562 6.82839 11.0562 5.98831 10.4559 5.65228L2.35084 1.11588C1.75047 0.779845 1 1.19988 1 1.87194Z"
                        stroke="url(#paint0_linear_781_87988)" stroke-width="2" />
                    <defs>
                        <linearGradient id="paint0_linear_781_87988" x1="5.95307" y1="0.733643" x2="5.95307"
                                        y2="11.8191" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#130839" />
                            <stop offset="0.360577" stop-color="#282251" />
                            <stop offset="0.764423" stop-color="#793971" />
                            <stop offset="1" stop-color="#CC7897" />
                        </linearGradient>
                    </defs>
                </svg>
            </button>
        </div>
    </div>
    <div class="swiper platforms-swiper-main">

        <?php if (have_rows('platforms')) : ?>
            <div class="swiper-wrapper swiper-wrapper_2">
                <?php while (have_rows('platforms')) : the_row(); ?>
                    <?php if (have_rows('platforms_item')) : ?>
                        <?php while (have_rows('platforms_item')) : the_row(); ?>
                            <div class="swiper-slide item-desc"
                                 data-platform="<?php the_sub_field('data_platform'); ?>">
                                <div class="desc-wrapper">
                                    <p class="title"><?php the_sub_field('platforms_title'); ?></p>
                                    <p class="desc">
                                        <?php the_sub_field('platforms_text'); ?>
                                    </p>
                                    <?php
                                    $platform_link = trim((string) get_sub_field('platforms_link'));
                                    $show_link = $platform_link !== '' && $platform_link !== '#';
                                    if ($show_link) : ?>
                                    <a href="<?php echo esc_url($platform_link); ?>" class="link">
                                        Learn what we can do with it
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_781_87984)">
                                                <path
                                                    d="M11.2 8.54028e-07H15.4667C15.6081 8.54028e-07 15.7438 0.0561912 15.8438 0.156211C15.9438 0.25623 16 0.391885 16 0.533334V4.8C16.0002 4.90562 15.969 5.00892 15.9104 5.0968C15.8518 5.18469 15.7685 5.25319 15.6709 5.29364C15.5733 5.33408 15.4659 5.34465 15.3624 5.32399C15.2588 5.30333 15.1637 5.25238 15.0891 5.1776L13.3333 3.4208L0.910933 15.8443L0.155733 15.0891L12.5792 2.66667L10.8224 0.910934C10.7476 0.836343 10.6967 0.741226 10.676 0.637644C10.6554 0.534062 10.6659 0.426678 10.7064 0.329107C10.7468 0.231535 10.8153 0.14817 10.9032 0.0895793C10.9911 0.0309888 11.0944 -0.000188122 11.2 8.54028e-07Z"
                                                    fill="black" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_781_87984">
                                                    <rect width="16" height="16" fill="white"
                                                          transform="matrix(-1 0 0 1 16 0)" />
                                                </clipPath>
                                            </defs>
                                        </svg>

                                    </a>
                                    <?php endif; ?>
                                    <button class="btn btn-gradient openPopup" data-pop="popupForm">start using</button>
                                </div>
                                <?php if (get_sub_field('platforms_logo_desc')) : ?>
                                    <img src="<?php the_sub_field('platforms_logo_desc'); ?>"
                                         alt="<?php the_sub_field('platforms_title'); ?>" />
                                <?php else: ?>
                                    <img src="<?php the_sub_field('platforms_logo_default'); ?>"
                                         alt="<?php the_sub_field('platforms_title'); ?>" />
                                <?php endif ?>


                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>


    </div>
</section>
