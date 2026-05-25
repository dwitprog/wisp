<section class="page-38 banner" data-header-theme="gradient1">
    <div class="service-menu">
        <div class="service-menu-list">
            <a href="/services/full-service/">FULL </a>
            <a href="/services/performance-marketing/">Performance marketing </a>
            <a href="/services/audit-service/">AUDIT</a>
            <a href="/services/strategy-service/" class="active">Strategy </a>
            <a href="/services/consulting-service/">Consulting </a>
        </div>
    </div>
    <div class="title-desc color-white">
        <h1 class="title"><?php the_field('banner_title'); ?></h1>
        <p class="desc">
            <?php the_field('banner_text'); ?>
        </p>
    </div>
    <div class="line-wrapper">
        <span class="line"></span>
        <div class="numbers">
            <div class="number">
                <span></span>
                <span>1</span>
            </div>
            <div class="number">
                <span></span>
                <span>2</span>
            </div>
            <div class="number">
                <span></span>
                <span>3</span>
            </div>
        </div>
    </div>
    <?php if (have_rows('possibilities_list')) : ?>
        <div class="items">
            <?php while (have_rows('possibilities_list')) : the_row(); ?>
                <?php if (have_rows('possibilities_item_1')) : ?>
                    <?php while (have_rows('possibilities_item_1')) : the_row(); ?>
                        <div class="item">
                            <p class="title"> <?php the_sub_field('possibilities_item_1_title'); ?></p>
                            <p class="desc"> <?php the_sub_field('possibilities_item_1_text'); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php if (have_rows('possibilities_item_2')) : ?>
                    <?php while (have_rows('possibilities_item_2')) : the_row(); ?>
                        <div class="item">
                            <p class="title"> <?php the_sub_field('possibilities_item_2_title'); ?></p>
                            <p class="desc">
                                <?php the_sub_field('possibilities_item_2_text'); ?>
                            </p>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php if (have_rows('possibilities_item_3')) : ?>
                    <?php while (have_rows('possibilities_item_3')) : the_row(); ?>
                        <div class="item">
                            <p class="title"><?php the_sub_field('possibilities_item_3_title'); ?></p>
                            <p class="desc"><?php the_sub_field('possibilities_item_3_text'); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <div class="wrapper">
        <?php if (have_rows('insert_metrics')) : ?>
            <?php while (have_rows('insert_metrics')) : the_row(); ?>
                <div class="title"><?php the_sub_field('insert_metrics_title'); ?></div>
                <div class="item">
                    <p class="desc">
                        <?php the_sub_field('insert_metrics_text'); ?>
                    </p>
                    <div class="small">
                        <em>
                            <?php the_sub_field('insert_metrics_text_small'); ?>
                        </em>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
<section class="page-38 project-stages" data-header-theme="white">
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
<section class="page-38 have-a-questions" data-header-theme="gradient1">
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
                            <p class="custom-select_title">Platforms of interest</p>
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1.svg"
                                class="arrow arrow_default active" alt="arrow">
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1-active.svg"
                                class="arrow arrow_active" alt="arrow">
                        </div>
                        <div class="custom-select_list">
                            <div class="custom-select_item">
                                <input type="checkbox" name="platformsOfInterest[]"
                                       value="Bing ads" id="p38_platforms_1">
                                <label for="p38_platforms_1">
                                    <span>
                                    </span>
                                    Bing ads
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="platformsOfInterest[]" value="google ads"
                                       id="p38_platforms_2">
                                <label for="p38_platforms_2">
                                    <span>
                                    </span>
                                    google ads
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="platformsOfInterest[]" value="LinkedIn ads"
                                       id="p38_platforms_3">
                                <label for="p38_platforms_3">
                                    <span>
                                    </span>
                                    LinkedIn ads
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" name="platformsOfInterest[]" value="reddit ads"
                                       id="p38_platforms_4">
                                <label for="p38_platforms_4">
                                    <span>
                                    </span>
                                    reddit ads
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
                                       id="p38_services_price_1">
                                <label for="p38_services_price_1">
                                    <span>
                                    </span>
                                    not defined
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="5 000 $"
                                       id="p38_services_price_2">
                                <label for="p38_services_price_2">
                                    <span>
                                    </span>
                                    5 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="10 000 $"
                                       id="p38_services_price_3">
                                <label for="p38_services_price_3">
                                    <span>
                                    </span>
                                    10 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="15 000 $"
                                       id="p38_services_price_4">
                                <label for="p38_services_price_4">
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
                                                                <?php get_template_part('template-parts/form-social-icons', null, ['variant' => 'form', 'uid' => 'p38-form']); ?>
                        </div>
                    </div>
                </div>
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
                                                <?php get_template_part('template-parts/form-social-icons', null, ['variant' => 'success', 'uid' => 'p38-success']); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="page-38 faq-accordion" data-header-theme="gradient2">
    <div class="container">
        <?php if (have_rows('faq_list')) : ?>
            <?php while (have_rows('faq_list')) : the_row(); ?>
                <?php if (have_rows('faq_item')) : ?>
                    <?php while (have_rows('faq_item')) : the_row(); ?>
                        <div class="item">
                            <div class="title">
                                <p>
                                    <?php the_sub_field('faq_item_title'); ?>

                                </p>
                            </div>
                            <div class="content">
                                <p>
                                    <?php the_sub_field('faq_item_text'); ?>
                                </p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>
