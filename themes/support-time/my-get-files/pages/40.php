<section class="page-40 banner">
    <div class="service-menu"></div>
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
<section class="page-40 project-stages">
    <h2 class="section-title"><?php the_field('project_stages_section-title'); ?></h2>
    <div class="content">
        <div class="stages">
            <div class="line-container">
                <div class="line">
                </div>
                <span class="circle">
                    <span>
                        <span></span>
                    </span>
                </span>
            </div>
            <div class="items">
                <?php if (have_rows('project_stages_list')) : ?>
                    <?php $item_counter = 0; ?>
                    <?php while (have_rows('project_stages_list')) : the_row(); ?>

                        <?php if (have_rows('project_stages_item')) : ?>
                            <?php while (have_rows('project_stages_item')) : the_row(); ?>
                                <div class="item <?php echo $item_counter === 0 ? ' active' : ''; ?>">
                                    <span class="step"></span>
                                    <p class="title"> <?php the_sub_field('project_stages_item_title'); ?></p>
                                    <p class="desc">
                                        <?php the_sub_field('project_stages_item_text'); ?>
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
    </div>
    <picture class="image">
        <source media="(max-width:991.98px)"
                srcset="/wp-content/themes/support-time/assets/img/pages/7/project-stages-992.png">
        <source media="(max-width:1199.98px)"
                srcset="/wp-content/themes/support-time/assets/img/pages/7/project-stages-1200.png">
        <img src="/wp-content/themes/support-time/assets/img/pages/7/project-stages.png" alt="">
    </picture>
</section>
<section class="page-40 have-a-questions">
    <div class="container">
        <div class="content">
            <div class="section-title">
                <h2 class="color-white">CONTACT US</h2>
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
                    <div class="input-wrapper input-wrapper_scope">
                        <span class="required">*</span>
                        <input name="scope" type="text" placeholder="Scope">
                        <p>only data, only tracking, etc</p>
                    </div>
                    <div class="input-wrapper input-wrapper_duration">
                        <span class="required">*</span>
                        <input name="duration" type="text" placeholder="Duration">
                        <p>we need a second opinion, we would like to have an outside
                            opinion, we don’t know what to do at all, etc</p>
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
<section class="page-40 faq-accordion">
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
