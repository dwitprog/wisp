<section class="page-7 banner">
    <div class="container">
        <div class="offer">
            <div class="title">
                <h1><?php the_field('banner_title'); ?></h1>
            </div>
            <p class="color-white desc">
                <?php the_field('banner_desc'); ?>
            </p>
            <button class="btn">free consultation</button>
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
    <picture class="image">
        <source media="(max-width:767.98px)"
            srcset="/wp-content/themes/support-time/assets/img/pages/7/banner-768.png">
        <source media="(max-width:991.98px)"
            srcset="/wp-content/themes/support-time/assets/img/pages/7/banner-992.png">
        <source media="(max-width:1199.98px)"
            srcset="/wp-content/themes/support-time/assets/img/pages/7/banner-1200.png">
        <source media="(max-width:1399.98px)"
            srcset="/wp-content/themes/support-time/assets/img/pages/7/banner-1400.png">
        <img src="/wp-content/themes/support-time/assets/img/pages/7/banner.png" class="banner-image"
            alt="Imagined Efciency">
    </picture>
</section>
<section class="page-7 services">
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
                                <button class="btn btn-gradient">free consultation</button>
                            </div>
                        </div>
                        <?php $item_counter++; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</section>
<section class="page-7 platforms">
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
                                <a href="<?php the_sub_field('platform_link'); ?>" class="btn  btn-center">learn
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
            <div class="swiper-bullets">
                <span></span><span></span><span></span>
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
<section class="page-7 project-stages">
    <h2 class="section-title"><?php the_field('project_stages_section-title'); ?></h2>
    <div class="content">
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
                <?php if (have_rows('project_stages_list')) : ?>
                    <?php $item_project_stages_counter = 0; ?>
                    <?php while (have_rows('project_stages_list')) : the_row(); ?>
                        <?php if (have_rows('project_stages_item')) : ?>
                            <?php while (have_rows('project_stages_item')) : the_row(); ?>
                                <div class="item ">
                                    <span class="step"></span>
                                    <p class="title"> <?php the_sub_field('project_stages_item_title'); ?></p>
                                    <p class="desc">
                                        <?php the_sub_field('project_stages_item_text'); ?>
                                    </p>
                                </div>
                                <?php $item_project_stages_counter++; ?>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <picture class="image">
        <source media="(max-width:991.98px)"
            srcset="/wp-content/themes/support-time/assets/img/pages/7/project-stages-992.png">
        <source media="(max-width:1199.98px)"
            srcset="/wp-content/themes/support-time/assets/img/pages/7/project-stages-1200.png">
        <img src="/wp-content/themes/support-time/assets/img/pages/7/project-stages.png" alt="">
    </picture>

</section>
<section class="page-7 have-a-questions">
    <div class="container">
        <div class="content">
            <div class="section-title">
                <h2 class="color-white">have a questions</h2>
            </div>
            <div class="lines">
                <div class="line line-left"></div>
                <div class="line line-bottom"></div>
            </div>
            <p class="subtitle color-white">
                we guarantee complete confidentiality of your data
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
                                <input type="checkbox" class="onlyOne" name="services[]" value="Full service"
                                    id="services_6">
                                <label for="services_6">
                                    <span>
                                    </span>
                                    Full service
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
                                <input type="checkbox" name="servicesPrice[]" value="100 000 $" id="services_price_2">
                                <label for="services_price_2">
                                    <span>
                                    </span>
                                    100 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="servicesPrice[]" value="150 000 $" id="services_price_3">
                                <label for="services_price_3">
                                    <span>
                                    </span>
                                    150 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="servicesPrice[]" value="200 000 $" id="services_price_4">
                                <label for="services_price_4">
                                    <span>
                                    </span>
                                    200 000 $
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-and-social">
                        <button class="btn-send" type="submit">
                            <span class="gradient-text">SEND</span>
                        </button>
                        <div class="social-list">
                            <a href="#">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.65625 18.2169L2.82504 13.9684C2.10688 12.722 1.72975 11.3085 1.73159 9.87002C1.72328 5.33727 5.4043 1.65625 9.92831 1.65625C12.124 1.65625 14.1856 2.50752 15.738 4.06036C16.5031 4.82154 17.1096 5.727 17.5223 6.72427C17.935 7.72153 18.1456 8.79076 18.1421 9.87002C18.1421 14.3941 14.4611 18.0751 9.93659 18.0751C8.5594 18.0751 7.21546 17.7326 6.0134 17.0736L1.65625 18.2169ZM6.20567 15.5961L6.45616 15.7462C7.50754 16.3684 8.70663 16.697 9.92831 16.6978C13.6846 16.6978 16.7482 13.6348 16.7482 9.87788C16.7482 8.05841 16.0389 6.33923 14.7531 5.05401C14.1209 4.41818 13.369 3.91377 12.541 3.56984C11.7129 3.22591 10.8249 3.04927 9.92831 3.05009C6.1636 3.05058 3.10097 6.11369 3.10097 9.87051C3.10097 11.1558 3.46006 12.4166 4.14451 13.5017L4.30302 13.7605L3.61026 16.281L6.20567 15.5961Z"
                                        fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.88209 6.43137C7.7319 6.0889 7.56506 6.08058 7.42319 6.08058C7.29794 6.07227 7.16389 6.07227 7.02202 6.07227C6.88894 6.07227 6.6634 6.12217 6.47162 6.33107C6.27935 6.53948 5.75391 7.03215 5.75391 8.04194C5.75391 9.05224 6.48826 10.0287 6.58855 10.1623C6.68835 10.2959 8.00733 12.4324 10.0944 13.2592C11.8302 13.9436 12.181 13.81 12.5567 13.768C12.932 13.7264 13.7671 13.2758 13.9423 12.7915C14.1091 12.3159 14.1091 11.8986 14.0592 11.8149C14.0093 11.7318 13.8669 11.6813 13.6669 11.5728C13.458 11.4729 12.4565 10.972 12.2647 10.905C12.0724 10.8384 11.9388 10.8051 11.8053 11.0052C11.6717 11.2142 11.2793 11.6731 11.1546 11.8066C11.0372 11.9402 10.9124 11.9568 10.7119 11.8565C10.5035 11.7567 9.84392 11.5395 9.05919 10.8384C8.4496 10.2954 8.0406 9.6197 7.91536 9.41964C7.79892 9.21073 7.89872 9.10209 8.00733 9.00182C8.09931 8.91032 8.21624 8.76011 8.31653 8.6432C8.41631 8.52578 8.4496 8.43428 8.52495 8.30072C8.59152 8.16718 8.55823 8.04193 8.5083 7.94213C8.45796 7.85015 8.06604 6.84037 7.88209 6.43137Z"
                                        fill="white" />
                                    <path opacity="0.3"
                                        d="M1.65625 18.2169L2.82504 13.9684C2.10688 12.722 1.72975 11.3085 1.73159 9.87002C1.72328 5.33727 5.4043 1.65625 9.92831 1.65625C12.124 1.65625 14.1856 2.50752 15.738 4.06036C16.5031 4.82154 17.1096 5.727 17.5223 6.72427C17.935 7.72153 18.1456 8.79076 18.1421 9.87002C18.1421 14.3941 14.4611 18.0751 9.93659 18.0751C8.5594 18.0751 7.21546 17.7326 6.0134 17.0736L1.65625 18.2169ZM6.20567 15.5961L6.45616 15.7462C7.50754 16.3684 8.70663 16.697 9.92831 16.6978C13.6846 16.6978 16.7482 13.6348 16.7482 9.87788C16.7482 8.05841 16.0389 6.33923 14.7531 5.05401C14.1209 4.41818 13.369 3.91377 12.541 3.56984C11.7129 3.22591 10.8249 3.04927 9.92831 3.05009C6.1636 3.05058 3.10097 6.11369 3.10097 9.87051C3.10097 11.1558 3.46006 12.4166 4.14451 13.5017L4.30302 13.7605L3.61026 16.281L6.20567 15.5961Z"
                                        fill="white" />
                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.88209 6.43137C7.7319 6.0889 7.56506 6.08058 7.42319 6.08058C7.29794 6.07227 7.16389 6.07227 7.02202 6.07227C6.88894 6.07227 6.6634 6.12217 6.47162 6.33107C6.27935 6.53948 5.75391 7.03215 5.75391 8.04194C5.75391 9.05224 6.48826 10.0287 6.58855 10.1623C6.68835 10.2959 8.00733 12.4324 10.0944 13.2592C11.8302 13.9436 12.181 13.81 12.5567 13.768C12.932 13.7264 13.7671 13.2758 13.9423 12.7915C14.1091 12.3159 14.1091 11.8986 14.0592 11.8149C14.0093 11.7318 13.8669 11.6813 13.6669 11.5728C13.458 11.4729 12.4565 10.972 12.2647 10.905C12.0724 10.8384 11.9388 10.8051 11.8053 11.0052C11.6717 11.2142 11.2793 11.6731 11.1546 11.8066C11.0372 11.9402 10.9124 11.9568 10.7119 11.8565C10.5035 11.7567 9.84392 11.5395 9.05919 10.8384C8.4496 10.2954 8.0406 9.6197 7.91536 9.41964C7.79892 9.21073 7.89872 9.10209 8.00733 9.00182C8.09931 8.91032 8.21624 8.76011 8.31653 8.6432C8.41631 8.52578 8.4496 8.43428 8.52495 8.30072C8.59152 8.16718 8.55823 8.04193 8.5083 7.94213C8.45796 7.85015 8.06604 6.84037 7.88209 6.43137Z"
                                        fill="white" />
                                </svg>

                            </a>
                            <a href="#">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.16016 8.66558L10.6073 13.5009C11.7165 14.3327 13.2415 14.3327 14.3508 13.5009L20.7979 8.66553"
                                        stroke="white" stroke-width="2.07971" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M19.7588 6.58594H5.20081C4.05221 6.58594 3.12109 7.51706 3.12109 8.66565V19.0642C3.12109 20.2128 4.05221 21.1439 5.20081 21.1439H19.7588C20.9074 21.1439 21.8385 20.2128 21.8385 19.0642V8.66565C21.8385 7.51706 20.9074 6.58594 19.7588 6.58594Z"
                                        stroke="white" stroke-width="2.07971" stroke-linecap="round" />
                                    <path opacity="0.3"
                                        d="M19.7588 6.58594H5.20081C4.05221 6.58594 3.12109 7.51706 3.12109 8.66565V19.0642C3.12109 20.2128 4.05221 21.1439 5.20081 21.1439H19.7588C20.9074 21.1439 21.8385 20.2128 21.8385 19.0642V8.66565C21.8385 7.51706 20.9074 6.58594 19.7588 6.58594Z"
                                        stroke="white" stroke-width="2.07971" stroke-linecap="round" />
                                    <path opacity="0.3"
                                        d="M4.16016 8.66558L10.6073 13.5009C11.7165 14.3327 13.2415 14.3327 14.3508 13.5009L20.7979 8.66553"
                                        stroke="white" stroke-width="2.07971" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </a>
                            <a href="#">
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M18.1012 9.33526C18.1012 14.4909 14.0491 18.6705 9.0506 18.6705C4.05209 18.6705 0 14.4909 0 9.33526C0 4.17954 4.05209 0 9.0506 0C14.0491 0 18.1012 4.17954 18.1012 9.33526ZM9.37489 6.8917C8.49463 7.26937 6.73525 8.05101 4.09682 9.23668C3.66837 9.41246 3.44394 9.58442 3.42351 9.75245C3.38898 10.0366 3.73391 10.1485 4.2036 10.3008C4.2675 10.3215 4.33369 10.343 4.40155 10.3657C4.86366 10.5206 5.48528 10.7019 5.80843 10.7091C6.10156 10.7157 6.42873 10.591 6.78993 10.3352C9.25515 8.61878 10.5277 7.75125 10.6075 7.73249C10.6639 7.71933 10.742 7.70271 10.7949 7.75125C10.8479 7.79979 10.8426 7.89165 10.837 7.9163C10.8029 8.0666 9.44892 9.36494 8.74822 10.0368C8.52983 10.2463 8.37488 10.3948 8.34321 10.4288C8.27225 10.5048 8.19994 10.5767 8.13043 10.6457C7.70116 11.0726 7.37914 11.3927 8.14826 11.9155C8.51789 12.1667 8.81357 12.3744 9.10862 12.5817C9.43082 12.8081 9.75221 13.0338 10.1681 13.315C10.274 13.3866 10.3752 13.461 10.4737 13.5334C10.8487 13.8092 11.1855 14.0569 11.6018 14.0174C11.8436 13.9945 12.0934 13.7599 12.2203 13.0603C12.5202 11.407 13.1095 7.82481 13.2457 6.34873C13.2577 6.21941 13.2427 6.0539 13.2306 5.98124C13.2185 5.90858 13.1933 5.80506 13.1017 5.72842C12.9933 5.63767 12.826 5.61853 12.751 5.61983C12.4106 5.62608 11.8883 5.81339 9.37489 6.8917Z"
                                        fill="white" />
                                </svg>

                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="page-7 faq">
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
                                        <p class="desc">
                                            <?php the_sub_field('faq_item_text'); ?>
                                        </p>
                                        <a href="<?php the_sub_field('faq_item_link'); ?>" class="btn">learn more</a>
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