<section class="page-46 banner" data-header-theme="gradient1">
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
                                    <span class="number"></span>
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
                                    <span class="number"></span>
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
                                    <span class="number"></span>
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
                                    <span class="number"></span>
                                </div>


                            <?php endwhile; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>
<section class="page-46 how-we-work" data-header-theme="white">
    <h2 class="section-title"><?php the_field('how_we_work_section_title'); ?></h2>
    <div class="content how-we-work__layout">
        <div class="stages">
            <div class="line-container">
                <div class="line">

                </div>
            </div>
            <div class="items">
            <?php if (have_rows('how_we_work_list')) : ?>

                <?php while (have_rows('how_we_work_list')) : the_row(); ?>
                    <?php if (have_rows('how_we_work_item')) : ?>
                        <?php while (have_rows('how_we_work_item')) : the_row(); ?>
                            <div class="item">
                                <div class="step"><span></span></div>
                                <p class="title"><?php the_sub_field('how_we_work_title'); ?></p>
                                <p class="desc">
                                    <?php the_sub_field('how_we_work_text'); ?>
                                </p>
                            </div>


                        <?php

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
                <img src="/wp-content/themes/support-time/assets/img/pages/7/service-knob.png" class="knob step_2"
                     alt="Knob">
            </picture>
            <img src="/wp-content/themes/support-time/assets/img/pages/7/line.png" class="line" alt="Lines">
        </div>
        <div class="have-a-questions st-inline-contact">
            <div class="content">
                <div class="section-title">
                    <h2>Contact us</h2>
                </div>

                <form class="form" autocomplete="off" data-autocomplete-guarded="true">
                    <div class="autocomplete-guard" aria-hidden="true" style="position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden;">
                        <input type="text" name="fake-username" autocomplete="new-password" tabindex="-1" autocorrect="off" autocapitalize="off" spellcheck="false" data-lpignore="true" data-1p-ignore="true" data-bwignore="true" data-form-type="other" data-autocomplete-locked="true" readonly data-field="fake-username">
                        <input type="password" name="fake-password" autocomplete="new-password" tabindex="-1" autocorrect="off" autocapitalize="off" spellcheck="false" data-lpignore="true" data-1p-ignore="true" data-bwignore="true" data-form-type="other" data-autocomplete-locked="true" readonly data-field="fake-password">
                    </div>
                    <div class="input-wrapper input-wrapper_name">
                        <span class="required">*</span>
                        <input name="name" type="text" autocomplete="off" readonly
                               onfocus="this.removeAttribute('readonly')" placeholder="NAME">
                    </div>
                    <div class="input-wrapper input-wrapper_email">
                        <span class="required">*</span>
                        <input name="email" type="email" autocomplete="off" readonly
                               onfocus="this.removeAttribute('readonly')" placeholder="E-MAIL">
                    </div>
                    <textarea name="message" class="message" placeholder="MESSAGE"></textarea>

                    <div class="bottom-wrapper">
                        <?php
                        if (function_exists('get_field')) {
                            $date_1 = get_field('date_1', 'option');
                            $date_2 = get_field('date_2', 'option');
                            $date_3 = get_field('date_3', 'option');
                        } else {
                            $date_1 = $date_2 = $date_3 = null;
                        }
                        if (empty($date_1) || empty($date_2) || empty($date_3)) {
                            $d0 = new DateTimeImmutable('now', wp_timezone());
                            $d1 = $d0->add(new DateInterval('P1D'));
                            $d2 = $d0->add(new DateInterval('P2D'));
                            $date_1 = $date_1 ?: $d0->format('Y-m-d');
                            $date_2 = $date_2 ?: $d1->format('Y-m-d');
                            $date_3 = $date_3 ?: $d2->format('Y-m-d');
                        }
                        $fmt = function ($d) {
                            $dt = DateTime::createFromFormat('Y-m-d', $d);
                            return $dt ? $dt->format('M j, Y') : $d;
                        };
                        $date_options = array(
                            array('label' => $fmt($date_1), 'value' => $date_1),
                            array('label' => $fmt($date_2), 'value' => $date_2),
                            array('label' => $fmt($date_3), 'value' => $date_3),
                        );
                        $date_options_json = wp_json_encode($date_options);
                        ?>

                        <div class="select-services custom-select">
                            <span class="required">*</span>
                            <div class="custom-select_top">
                                <p class="custom-select_title" data-default-title="Service of interest">Service of interest</p>
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
                                           id="services_how_1">
                                    <label for="services_how_1">
                                    <span>
                                    </span>
                                        not defined
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" name="services[]" value="Consulting services"
                                           id="services_how_2">
                                    <label for="services_how_2">
                                    <span>
                                    </span>
                                        Consulting services
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" name="services[]" value="Strategy services"
                                           id="services_how_3">
                                    <label for="services_how_3">
                                    <span>
                                    </span>
                                        Strategy services
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" name="services[]" value="Audit services"
                                           id="services_how_4">
                                    <label for="services_how_4">
                                    <span>
                                    </span>
                                        Audit services
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" name="services[]" value="Performance marketing services"
                                           id="services_how_5">
                                    <label for="services_how_5">
                                    <span>
                                    </span>
                                        Performance marketing services
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" class="onlyOne" name="services[]" value="Full Service"
                                           id="services_how_6">
                                    <label for="services_how_6">
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
                                <p class="custom-select_title" data-default-title="Planning budget">Planning budget</p>
                                <img
                                    src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1.svg"
                                    class="arrow arrow_default active" alt="arrow">
                                <img
                                    src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1-active.svg"
                                    class="arrow arrow_active" alt="arrow">
                            </div>
                            <div class="custom-select_list">
                                <div class="custom-select_item">
                                    <input type="checkbox" class="onlyOne" name="servicesPrice[]"
                                           value="not defined"
                                           id="services_price_how_1">
                                    <label for="services_price_how_1">
                                    <span>
                                    </span>
                                        not defined
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="100 000 $"
                                           id="services_price_how_2">
                                    <label for="services_price_how_2">
                                    <span>
                                    </span>
                                        100 000 $
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="150 000 $"
                                           id="services_price_how_3">
                                    <label for="services_price_how_3">
                                    <span>
                                    </span>
                                        150 000 $
                                    </label>
                                </div>
                                <div class="custom-select_item">
                                    <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="200 000 $"
                                           id="services_price_how_4">
                                    <label for="services_price_how_4">
                                    <span>
                                    </span>
                                        200 000 $
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="select-booking-datetime custom-select" data-date-options="<?php echo esc_attr($date_options_json); ?>">
                            <input type="hidden" name="booking_date[]" class="booking-date-hidden" value="">
                            <input type="hidden" name="booking_slot[]" class="booking-slot-hidden" value="">
                            <div class="custom-select_top">
                                <p class="custom-select_title" data-default-title="MEETING DATE">MEETING DATE</p>
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/img/repeat-elements/form/custom-checkbox-arrow-1.svg" class="arrow arrow_default active" alt="arrow">
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/img/repeat-elements/form/custom-checkbox-arrow-1-active.svg" class="arrow arrow_active" alt="arrow">
                            </div>
                            <div class="custom-select_list" data-booking-datetime-list></div>
                        </div>
                    </div>

                    <div class="bottom-send">
                        <div class="btn-and-social">
                            <button class="btn-send" type="submit">
                                <span class="gradient-text">SEND</span>
                            </button>
                            <div class="social-list">
                                <a href="https://wa.me/+19715347250" target="_blank" rel="noopener noreferrer">
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
                                            stroke-linejoin="round"></path>
                                        <path
                                            d="M19.7588 6.58594H5.20081C4.05221 6.58594 3.12109 7.51706 3.12109 8.66565V19.0642C3.12109 20.2128 4.05221 21.1439 5.20081 21.1439H19.7588C20.9074 21.1439 21.8385 20.2128 21.8385 19.0642V8.66565C21.8385 7.51706 20.9074 6.58594 19.7588 6.58594Z"
                                            stroke="white" stroke-width="2.07971" stroke-linecap="round"></path>
                                        <path opacity="0.3"
                                              d="M19.7588 6.58594H5.20081C4.05221 6.58594 3.12109 7.51706 3.12109 8.66565V19.0642C3.12109 20.2128 4.05221 21.1439 5.20081 21.1439H19.7588C20.9074 21.1439 21.8385 20.2128 21.8385 19.0642V8.66565C21.8385 7.51706 20.9074 6.58594 19.7588 6.58594Z"
                                              stroke="white" stroke-width="2.07971" stroke-linecap="round"></path>
                                        <path opacity="0.3"
                                              d="M4.16016 8.66558L10.6073 13.5009C11.7165 14.3327 13.2415 14.3327 14.3508 13.5009L20.7979 8.66553"
                                              stroke="white" stroke-width="2.07971" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </svg>
                                </a>
                                <a href="https://t.me/ComplexWisps" target="_blank" rel="noopener noreferrer">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M26.0696 3.99558C25.7487 4.01939 25.4337 4.09469 25.1366 4.21858H25.1326C24.8476 4.33158 23.4926 4.90158 21.4326 5.76558L14.0506 8.87458C8.75363 11.1046 3.54663 13.3006 3.54663 13.3006L3.60863 13.2766C3.60863 13.2766 3.24963 13.3946 2.87463 13.6516C2.64243 13.7983 2.44295 13.9913 2.28863 14.2186C2.10463 14.4886 1.95663 14.9016 2.01163 15.3286C2.10163 16.0506 2.56963 16.4836 2.90563 16.7226C3.24563 16.9646 3.56963 17.0776 3.56963 17.0776H3.57763L8.46063 18.7226C8.67963 19.4256 9.94863 23.5976 10.2536 24.5586C10.4336 25.1326 10.6086 25.4916 10.8276 25.7656C10.9323 25.9056 11.0586 26.0226 11.2066 26.1166C11.2835 26.1628 11.3662 26.1984 11.4526 26.2226L11.4026 26.2106C11.4176 26.2146 11.4296 26.2266 11.4406 26.2306C11.4806 26.2416 11.5076 26.2456 11.5586 26.2536C12.3316 26.4876 12.9526 26.0076 12.9526 26.0076L12.9876 25.9796L15.8706 23.3546L20.7026 27.0616L20.8126 27.1086C21.8196 27.5506 22.8396 27.3046 23.3786 26.8706C23.9216 26.4336 24.1326 25.8746 24.1326 25.8746L24.1676 25.7846L27.9016 6.65558C28.0076 6.18358 28.0346 5.74158 27.9176 5.31258C27.7976 4.8781 27.5189 4.50448 27.1366 4.26558C26.8161 4.07058 26.4443 3.97651 26.0696 3.99558ZM25.9686 6.04558C25.9646 6.10858 25.9766 6.10158 25.9486 6.22258V6.23358L22.2496 25.1636C22.2336 25.1906 22.2066 25.2496 22.1326 25.3086C22.0546 25.3706 21.9926 25.4096 21.6676 25.2806L15.7576 20.7496L12.1876 24.0036L12.9376 19.2136L22.5936 10.2136C22.9916 9.84358 22.8586 9.76558 22.8586 9.76558C22.8866 9.31158 22.2576 9.63258 22.2576 9.63258L10.0816 17.1756L10.0776 17.1556L4.24163 15.1906V15.1866L4.22663 15.1836L4.25663 15.1716L4.28863 15.1556L4.31963 15.1446C4.31963 15.1446 9.53063 12.9486 14.8276 10.7186C17.4796 9.60158 20.1516 8.47658 22.2066 7.60858C23.4254 7.09559 24.6454 6.58558 25.8666 6.07858C25.9486 6.04658 25.9096 6.04558 25.9686 6.04558Z" fill="white"></path>
</svg>

                                </a>
                            </div>
                        </div>

                        <label class="consent form-consent-desktop-only">
                            <input type="checkbox" name="consent" value="1" autocomplete="new-password" autocorrect="off" autocapitalize="off" spellcheck="false" data-lpignore="true" data-1p-ignore="true" data-bwignore="true" data-form-type="other">
                            <span>By clicking the Send button you give your consent to processing of digital data</span>
                        </label>
                    </div>
                </form>
            </div>

            <div class="after-send">
                <div class="after-send-content">
                    <div class="title-social">
                        <p class="h2">
                            We will contact you to discuss further cooperation.
                        </p>
                        <div class="social-list">
                            <a href="https://wa.me/+19715347250" target="_blank" rel="noopener noreferrer">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.64062 29.0337L4.50341 22.2625C3.35883 20.276 2.75776 18.0232 2.7607 15.7306C2.74746 8.50638 8.61419 2.63965 15.8245 2.63965C19.3239 2.63965 22.6097 3.99638 25.0838 6.47128C26.3033 7.68443 27.2699 9.12752 27.9276 10.7169C28.5853 12.3064 28.9211 14.0105 28.9154 15.7306C28.9154 22.9409 23.0487 28.8077 15.8377 28.8077C13.6427 28.8077 11.5008 28.2618 9.58496 27.2115L2.64062 29.0337Z"
                                        fill="url(#paint0_linear_1269_1031)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_1269_1031" x1="15.778" y1="2.63965"
                                                        x2="15.778"
                                                        y2="29.0337" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#130839" />
                                            <stop offset="0.360577" stop-color="#282251" />
                                            <stop offset="0.764423" stop-color="#793971" />
                                            <stop offset="1" stop-color="#CC7897" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </a>
                            <a href="#">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.62891 13.8111L16.9042 21.5175C18.672 22.8433 21.1026 22.8433 22.8705 21.5175L33.1457 13.811"
                                        stroke="url(#paint0_linear_1269_1036)" stroke-width="3.3146"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M31.4895 10.4961H8.28726C6.45666 10.4961 4.97266 11.9801 4.97266 13.8107V30.3837C4.97266 32.2143 6.45666 33.6983 8.28726 33.6983H31.4895C33.3201 33.6983 34.8041 32.2143 34.8041 30.3837V13.8107C34.8041 11.9801 33.3201 10.4961 31.4895 10.4961Z"
                                        stroke="url(#paint1_linear_1269_1036)" stroke-width="3.3146"
                                        stroke-linecap="round" />
                                    <defs>
                                        <linearGradient id="paint0_linear_1269_1036" x1="19.8873" y1="13.811"
                                                        x2="19.8873"
                                                        y2="22.5119" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#130839" />
                                            <stop offset="0.360577" stop-color="#282251" />
                                            <stop offset="0.764423" stop-color="#793971" />
                                            <stop offset="1" stop-color="#CC7897" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_1269_1036" x1="19.8884" y1="10.4961"
                                                        x2="19.8884"
                                                        y2="33.6983" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#130839" />
                                            <stop offset="0.360577" stop-color="#282251" />
                                            <stop offset="0.764423" stop-color="#793971" />
                                            <stop offset="1" stop-color="#CC7897" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <button class="btn btn-close btn-gradient" type="button">OK</button>
                </div>
            </div>
        </div>
    </div>
</section>
