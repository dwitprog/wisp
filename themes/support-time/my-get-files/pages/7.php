<section class="page-7 banner" data-header-theme="blur">
    <div class="container">
        <div class="offer">
            <div class="title">
                <h1><?php the_field('banner_title'); ?></h1>
            </div>
            <p class="color-white desc">
                <?php the_field('banner_desc'); ?>
            </p>
            <button class="btn openPopup" data-pop="popupForm">free consultation</button>
        </div>
        <p class="bottom-text color-white">
            <?php the_field('banner_bottom_text'); ?>
        </p>
        <div class="coordinates">
            <div class="line-top coordinate-axis">
                <span class="line"></span>
                <span class="label">
                    <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.34569 16.384C2.84969 18.7307 1.24969 19.904 0.545687 19.904C0.183021 19.904 0.00168747 19.6587 0.00168747 19.168C0.00168747 18.6774 0.193687 17.9627 0.577687 17.024C0.961687 16.0854 1.34569 15.264 1.72969 14.56L2.30569 13.536C3.92702 10.6987 5.15369 8.66137 5.98569 7.42404C6.34835 6.8907 6.80702 6.4427 7.36169 6.08004C7.93769 5.69604 8.47102 5.50404 8.96169 5.50404C9.13235 5.50404 9.21769 5.5787 9.21769 5.72804C9.21769 5.8347 9.14302 6.03737 8.99369 6.33604C8.73769 6.80537 8.10835 7.92537 7.10569 9.69604C6.10302 11.4667 5.50569 12.5334 5.31369 12.896C4.43902 14.432 4.00169 15.456 4.00169 15.968C4.00169 16.16 4.06569 16.256 4.19369 16.256C4.40702 16.256 5.08969 15.7227 6.24169 14.656C7.13769 13.76 8.32169 12.4694 9.79369 10.784C9.85769 10.72 9.91102 10.688 9.95369 10.688C9.99635 10.688 10.0177 10.7307 10.0177 10.816C10.0177 11.2214 9.85769 11.616 9.53769 12C7.95902 13.7494 6.56169 15.2107 5.34569 16.384ZM9.60169 3.68004C9.06835 3.68004 8.80169 3.36004 8.80169 2.72004C8.80169 2.1227 9.02569 1.52537 9.47369 0.928036C9.92169 0.309369 10.4124 3.62396e-05 10.9457 3.62396e-05C11.5857 3.62396e-05 11.9057 0.362703 11.9057 1.08804C11.9057 1.68537 11.6604 2.27204 11.1697 2.84804C10.679 3.4027 10.1564 3.68004 9.60169 3.68004Z"
                            fill="white" />
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
    </div>
    <?php if (have_rows('banner_images')) : ?>
        <picture class="image">
            <?php while (have_rows('banner_images')) : the_row(); ?>
                <?php if (get_sub_field('banner_image_768')) : ?>
                    <source media="(max-width:767.98px)"
                            srcset="<?php the_sub_field('banner_image_768'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('banner_image_992')) : ?>
                    <source media="(max-width:991.98px)"
                            srcset="<?php the_sub_field('banner_image_992'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('banner_image_1200')) : ?>
                    <source media="(max-width:1199.98px)"
                            srcset="<?php the_sub_field('banner_image_1200'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('banner_image_1400')) : ?>
                    <source media="(max-width:1399.98px)"
                            srcset="<?php the_sub_field('banner_image_1400'); ?>">
                <?php endif ?>
                <?php if (get_sub_field('banner_image_full')) : ?>
                    <img src="<?php the_sub_field('banner_image_full'); ?>" class="banner-image"
                         alt="<?php the_field('banner_title'); ?>">
                <?php endif ?>
            <?php endwhile; ?>
        </picture>
    <?php endif; ?>

</section>
<section class="page-7 services" data-header-theme="white">
    <div class="service-knob">
        <picture class="image">
            <source media="(max-width:767.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/service-knob-768.png">
            <source media="(max-width:991.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/service-knob-992.png">
            <source media="(max-width:1199.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/service-knob-1200.png">
            <img src="/wp-content/themes/support-time/assets/img/pages/7/service-knob.png" class="knob step_1"
                 alt="Knob">
        </picture>
        <img src="/wp-content/themes/support-time/assets/img/pages/7/line.png" class="line" alt="Lines">
    </div>
    <div class="list">
        <?php if (have_rows('services')) : ?>
            <?php $item_counter = 0; ?>
            <?php while (have_rows('services')) : the_row(); ?>
                <?php if (have_rows('services_item')) : ?>
                    <?php while (have_rows('services_item')) : the_row(); ?>
                        <div class="item<?php echo $item_counter === 0 ? ' active' : ''; ?>">
                            <p class="title">
                                <?php the_sub_field('services_title'); ?>
                            </p>
                            <div class="content">
                                <p class="desc">
                                    <?php the_sub_field('service_text'); ?>
                                </p>
                                <button class="btn btn-gradient openPopup" data-pop="popupForm">free consultation
                                </button>
                            </div>
                        </div>
                        <?php $item_counter++; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</section>
<section class="page-7 platforms" data-header-theme="gradient1">
    <div class="container">
        <h2 class="section-title color-white"><?php the_field('platforms_section_title'); ?></h2>
        <div class="items grid st-grid-column-lg-2">
            <?php if (have_rows('platforms')) : ?>
                <?php while (have_rows('platforms')) : the_row(); ?>
                    <?php if (have_rows('platform_item')) : ?>
                        <?php while (have_rows('platform_item')) : the_row(); ?>
                            <div class="item">
                                <?php if (get_sub_field('platform_logo_default')) : ?>
                                    <img src="<?php the_sub_field('platform_logo_default'); ?>" class="default"
                                         alt="" />
                                <?php endif ?>
                                <?php if (get_sub_field('platform_logo_hover')) : ?>
                                    <img src="<?php the_sub_field('platform_logo_hover'); ?>" class="hover" alt="" />
                                <?php endif ?>
                                <p class="desc">
                                    <?php the_sub_field('platform_text'); ?>
                                </p>
                                <?php
                                $platform_link = get_sub_field('platform_link');
                                $platform_target = add_query_arg("platform", $platform_link, "/platforms/");
                                ?>
                                <a href="<?php echo esc_url($platform_target); ?>" class="btn  btn-center">learn
                                    more</a>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="swiper swiper-content">
        <div class="swiper-wrapper ">
            <?php if (have_rows('platforms_slider')) : ?>
                <?php while (have_rows('platforms_slider')) : the_row(); ?>
                    <?php if (have_rows('platforms_slide')) : ?>
                        <?php while (have_rows('platforms_slide')) : the_row(); ?>
                            <div class="swiper-slide">
                                <p class="title"><?php the_sub_field('platforms_slide_title'); ?></p>
                                <p class="desc"><?php the_sub_field('platforms_slide_text'); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
                <?php while (have_rows('platforms_slider')) : the_row(); ?>
                    <?php if (have_rows('platforms_slide')) : ?>
                        <?php while (have_rows('platforms_slide')) : the_row(); ?>
                            <div class="swiper-slide">
                                <p class="title"><?php the_sub_field('platforms_slide_title'); ?></p>
                                <p class="desc"><?php the_sub_field('platforms_slide_text'); ?></p>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <picture>
            <source media="(max-width:991.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/platforms-lines-992.svg">
            <source media="(max-width:1199.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/pages/7/platforms-lines-1200.svg">
            <img class="line" src="/wp-content/themes/support-time/assets/img/pages/7/platforms-lines.png" alt="Line">
        </picture>

        <div class="navigation">
            <button class="swiper-prev swiper-btn">
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.5015 1.11279V16.9729M15.8984 2.76712V15.9529C15.8984 16.9297 14.8078 17.5401 13.9352 17.0518L2.15591 10.4589C1.28337 9.97049 1.28337 8.74958 2.15591 8.26122L13.9352 1.6683C14.8078 1.17994 15.8984 1.79039 15.8984 2.76712Z"
                        stroke="white" stroke-width="3" />
                </svg>
            </button>
            <div class="controls-btn play">
                <svg class="pause" width="14" height="22" viewBox="0 0 14 22" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <line x1="2" y1="2" x2="2" y2="20" stroke="white" stroke-width="4" stroke-linecap="round" />
                    <line x1="12" y1="2" x2="12" y2="20" stroke="white" stroke-width="4" stroke-linecap="round" />
                </svg>
                <svg class="start" width="18" height="19" viewBox="0 0 18 19" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.2425 8.26113C16.1151 8.7495 16.1151 9.9704 15.2425 10.4588L3.46322 17.0517C2.59068 17.54 1.5 16.9296 1.5 15.9529V2.76704C1.5 1.79031 2.59068 1.17985 3.46322 1.66822L15.2425 8.26113Z"
                        fill="white" stroke="white" stroke-width="3" />
                </svg>
            </div>
            <button class="swiper-next swiper-btn">
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.8969 1.11279V16.9729M1.5 2.76712V15.9529C1.5 16.9297 2.59068 17.5401 3.46322 17.0518L15.2425 10.4589C16.1151 9.97049 16.1151 8.74958 15.2425 8.26122L3.46322 1.6683C2.59068 1.17994 1.5 1.79039 1.5 2.76712Z"
                        stroke="white" stroke-width="3" />
                </svg>
            </button>
        </div>
    </div>
</section>
<section class="page-7 project-stages" data-header-theme="white">
    <h2 class="section-title"><?php the_field('project_stages_section-title'); ?></h2>
    <div class="content">
        <div class="stages">
            <div class="line-container">
                <div class="line"></div>

            </div>
            <div class="items">
                <?php if (have_rows('project_stages_list')) : ?>

                    <?php while (have_rows('project_stages_list')) : the_row(); ?>
                        <?php if (have_rows('project_stages_item')) : ?>
                            <?php while (have_rows('project_stages_item')) : the_row(); ?>
                                <div class="item ">
                                    <div class="step"><span></span></div>
                                    <p class="title"> <?php the_sub_field('project_stages_item_title'); ?></p>
                                    <p class="desc">
                                        <?php the_sub_field('project_stages_item_text'); ?>
                                    </p>
                                </div>

                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="image">
        <picture>
            <source media="(max-width:991.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/repeat-elements/project-stages/project-stages-992.png">
            <source media="(max-width:1199.98px)"
                    srcset="/wp-content/themes/support-time/assets/img/repeat-elements/project-stages/project-stages-1200.png">
            <img src="/wp-content/themes/support-time/assets/img/repeat-elements/project-stages/project-stages.png"
                 alt="<?php the_field('project_stages_section-title'); ?>">

        </picture>
        <div class="text">
            <img src="/wp-content/themes/support-time/assets/img/repeat-elements/project-stages/i.svg" alt="i"
                 class="i active">
            <img src="/wp-content/themes/support-time/assets/img/repeat-elements/project-stages/r.svg" alt="r"
                 class="r">
        </div>
    </div>


</section>
<section class="page-7 have-a-questions" data-header-theme="gradient1">
    <div class="container">
        <div class="content">
            <div class="section-title">
                <h2 class="color-white">have a question?</h2>
            </div>
            <div class="lines">
                <div class="line line-left"></div>
                <div class="line line-bottom"></div>
            </div>
            <p class="subtitle color-white">
                We guarantee complete confidentiality of your data
            </p>
            <form class="form">
                <div class="input-wrapper input-wrapper_name">
                    <span class="required">*</span>
                    <input name="name" type="text" placeholder="NAME">
                </div>
                <div class="input-wrapper input-wrapper_email">
                    <span class="required">*</span>
                    <input name="email" type="email" placeholder="E-MAIL">
                </div>
                <textarea name="message" class="message" placeholder="MESSAGE"></textarea>

                <div class="bottom-wrapper">
                    <div class="select-services custom-select">
                        <span class="required">*</span>
                        <div class="custom-select_top">
                            <p class="custom-select_title">Service of interest</p>
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1.svg"
                                class="arrow arrow_default active" alt="arrow">
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1-active.svg"
                                class="arrow arrow_active" alt="arrow">
                        </div>
                        <div class="custom-select_list">
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="services[]" value="not defined"
                                       id="services_1">
                                <label for="services_1">
                                    <span>
                                    </span>
                                    not defined
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="services[]" value="Consulting services" id="services_2">
                                <label for="services_2">
                                    <span>
                                    </span>
                                    Consulting services
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="services[]" value="Strategy services" id="services_3">
                                <label for="services_3">
                                    <span>
                                    </span>
                                    Strategy services
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="services[]" value="Audit services" id="services_4">
                                <label for="services_4">
                                    <span>
                                    </span>
                                    Audit services
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="services[]" value="Performance marketing services"
                                       id="services_5">
                                <label for="services_5">
                                    <span>
                                    </span>
                                    Performance marketing services
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="services[]" value="Full Service"
                                       id="services_6">
                                <label for="services_6">
                                    <span>
                                    </span>
                                    Full Service
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="select-services-price custom-select">
                        <span class="required">*</span>
                        <div class="custom-select_top">
                            <p class="custom-select_title">Planning budget</p>
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1.svg"
                                class="arrow arrow_default active" alt="arrow">
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1-active.svg"
                                class="arrow arrow_active" alt="arrow">
                        </div>
                        <div class="custom-select_list">
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="not defined"
                                       id="services_price_1">
                                <label for="services_price_1">
                                    <span>
                                    </span>
                                    not defined
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="5 000 $"
                                       id="services_price_2">
                                <label for="services_price_2">
                                    <span>
                                    </span>
                                    5 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="10 000 $"
                                       id="services_price_3">
                                <label for="services_price_3">
                                    <span>
                                    </span>
                                    10 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="15 000 $"
                                       id="services_price_4">
                                <label for="services_price_4">
                                    <span>
                                    </span>
                                    15 000 $
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-and-social">
                        <button class="btn-send" type="submit">
                            <span class="gradient-text">SEND</span>
                        </button>
                        <div class="social-list">
                                                                <?php get_template_part('template-parts/form-social-icons', null, ['variant' => 'form', 'uid' => 'p7-form']); ?>
                        </div>
                    </div>
                </div>
                <?php get_template_part('template-parts/form-honeypot'); ?>
                <label class="consent form-consent-desktop-only">
                    <input type="checkbox" name="consent" value="1" autocomplete="new-password" autocorrect="off" autocapitalize="off" spellcheck="false" data-lpignore="true" data-1p-ignore="true" data-bwignore="true" data-form-type="other">
                    <span>By clicking the Send button you give your consent to processing of digital data</span>
                </label>
            </form>
        </div>
        <div class="after-send">
            <div class="after-send-content">
                <p class="h2">
                    We will contact you to discuss further cooperation.
                </p>
                <div class="social-list">
                                                <?php get_template_part('template-parts/form-social-icons', null, ['variant' => 'success', 'uid' => 'p7-success']); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="page-7 faq" data-header-theme="gradient2">
    <h2 class="section-title color-white"><?php the_field('faq_section_title'); ?></h2>
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
                                        <button type="button" class="btn faq-learn-more">learn more</button>
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
