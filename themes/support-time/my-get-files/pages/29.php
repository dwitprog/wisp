<?php
// Собираем все сервисы в массив
$services = array();

if (have_rows('services_list')) :
    while (have_rows('services_list')) : the_row();
        if (have_rows('services_item')) :
            while (have_rows('services_item')) : the_row();
                $services[] = array(
                    'title' => get_sub_field('services_title'),
                    'text' => get_sub_field('services_text'),
                    'link' => get_sub_field('services_link')
                );
            endwhile;
        endif;
    endwhile;
endif;
?>

<section class="page-29 services" data-header-theme="gradient2">
    <div class="container">
        <div class="content">
            <h1 class="color-white"><?php the_field('services_section_title'); ?></h1>
            <?php if (!empty($services)) :
                // Вывод первого сервиса отдельно
                if (isset($services[0])) :
                    ?>
                    <div class="item">
                        <p class="title"><?= $services[0]['title'] ?></p>
                        <p class="desc">
                            <?= $services[0]['text'] ?>
                        </p>
                        <a href="<?= $services[0]['link'] ?>" class="btn btn-gradient">
                            learn more
                            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.283315" y="0.283315" width="7.93283" height="7.93283" rx="3.96641"
                                      stroke="white"
                                      stroke-width="0.566631" />
                                <path d="M6.81641 3.98338L2.56668 1.52979V6.43696L6.81641 3.98338Z" fill="white" />
                            </svg>

                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($services)) : ?>
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php
                // Пропускаем первый элемент (с индексом 0)
                $other_services = array_slice($services, 1);
                if (!empty($other_services)) :
                    foreach ($other_services as $service) :
                        ?>
                        <div class="swiper-slide item">
                            <p class="title"><?= $service['title'] ?></p>
                            <p class="desc">
                                <?= $service['text'] ?>
                            </p>
                            <a href="<?= $service['link'] ?>" class="btn">
                                learn more
                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.283315" y="0.283315" width="7.93283" height="7.93283" rx="3.96641"
                                          stroke="url(#paint0_linear_1204_1247)" stroke-width="0.566631" />
                                    <path d="M7.13672 4.30576L2.88699 1.85218V6.75935L7.13672 4.30576Z"
                                          fill="url(#paint1_linear_1204_1247)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_1204_1247" x1="4.24973" y1="0" x2="4.24973"
                                                        y2="8.49946"
                                                        gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#130839" />
                                            <stop offset="0.360577" stop-color="#282251" />
                                            <stop offset="0.764423" stop-color="#793971" />
                                            <stop offset="1" stop-color="#CC7897" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_1204_1247" x1="7.13672" y1="4.30576"
                                                        x2="1.47041"
                                                        y2="4.30576" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#130839" />
                                            <stop offset="0.360577" stop-color="#282251" />
                                            <stop offset="0.764423" stop-color="#793971" />
                                            <stop offset="1" stop-color="#CC7897" />
                                        </linearGradient>
                                    </defs>
                                </svg>


                            </a>
                        </div>

                    <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div class="navigation">
                <button class="swiper-prev swiper-btn">
                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1.5015 1.11279V16.9729M15.8984 2.76712V15.9529C15.8984 16.9297 14.8078 17.5401 13.9352 17.0518L2.15591 10.4589C1.28337 9.97049 1.28337 8.74958 2.15591 8.26122L13.9352 1.6683C14.8078 1.17994 15.8984 1.79039 15.8984 2.76712Z"
                            stroke="white" stroke-width="3" />
                    </svg>

                </button>
                <div class="swiper-pagination">
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
    <?php endif; ?>
</section>
