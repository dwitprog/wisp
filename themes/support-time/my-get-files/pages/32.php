<section class="page-32 banner" data-header-theme="gradient1">
    <div class="service-menu">
        <div class="service-menu-list">
            <a href="/services/full-service/" class="active">FULL </a>
            <a href="/services/performance-marketing/">Performance marketing </a>
            <a href="/services/audit-service/">AUDIT</a>
            <a href="/services/strategy-service/">Strategy </a>
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
    <?php if (have_rows('audio_items_list')) : ?>
        <div class="wrapper">
            <?php while (have_rows('audio_items_list')) : the_row(); ?>
                <?php if (have_rows('audio_items_item_1')) : ?>
                    <?php while (have_rows('audio_items_item_1')) : the_row(); ?>
                        <div class="item" data-audio-item>
                            <p class="title">
                                <?php the_sub_field('audio_items_item_1_title'); ?>
                            </p>
                            <p class="desc">
                                <?php the_sub_field('audio_items_item_1_text'); ?>
                            </p>
                            <audio data-audio>
                                <source src="<?php the_sub_field('audio_items_item_1_link'); ?>" type="audio/mpeg">
                            </audio>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php if (have_rows('audio_items_item_2')) : ?>
                    <?php while (have_rows('audio_items_item_2')) : the_row(); ?>
                        <div class="item active" data-audio-item>
                            <p class="title">
                                <?php the_sub_field('audio_items_item_2_title'); ?>
                            </p>
                            <p class="desc">
                                <?php the_sub_field('audio_items_item_2_text'); ?>
                            </p>
                            <audio data-audio>
                                <source src="<?php the_sub_field('audio_items_item_2_link'); ?>" type="audio/mpeg">
                            </audio>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php if (have_rows('audio_items_item_3')) : ?>
                    <?php while (have_rows('audio_items_item_3')) : the_row(); ?>
                        <div class="item" data-audio-item>
                            <p class="title">
                                <?php the_sub_field('audio_items_item_3_title'); ?>
                            </p>
                            <p class="desc">
                                <?php the_sub_field('audio_items_item_3_text'); ?>
                            </p>
                            <audio data-audio>
                                <source src="<?php the_sub_field('audio_items_item_3_link'); ?>" type="audio/mpeg">
                            </audio>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <div class="sound-wrapper">
        <svg class="sound-wave" id="soundWave" viewBox="0 0 1419 285" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line x1="11.6296" y1="155.455" x2="11.6296" y2="124.521" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="26.0554" y1="164.77" x2="26.0554" y2="115.208" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="40.489" y1="152.616" x2="40.489" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="54.9226" y1="151.174" x2="54.9226" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="69.3562" y1="152.616" x2="69.3562" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="83.782" y1="148.287" x2="83.782" y2="131.691" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="98.2156" y1="152.616" x2="98.2156" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="112.653" y1="154.946" x2="112.653" y2="125.03" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="127.087" y1="152.616" x2="127.087" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="141.516" y1="161.275" x2="141.516" y2="118.702" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="155.946" y1="165.387" x2="155.946" y2="114.591" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="170.38" y1="154.06" x2="170.38" y2="125.918" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="184.809" y1="149.73" x2="184.809" y2="130.247" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="199.243" y1="165.432" x2="199.243" y2="114.547" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="213.673" y1="167.038" x2="213.673" y2="112.937" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="228.106" y1="161.507" x2="228.106" y2="118.47" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="242.536" y1="160.455" x2="242.536" y2="119.523" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="256.969" y1="153.692" x2="256.969" y2="126.285" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="271.399" y1="151.174" x2="271.399" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="285.836" y1="161.276" x2="285.831" y2="118.702" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="300.262" y1="151.174" x2="300.262" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="314.696" y1="157.869" x2="314.696" y2="122.109" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="329.13" y1="154.06" x2="329.13" y2="125.918" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="343.559" y1="159.995" x2="343.559" y2="119.983" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="357.993" y1="156.611" x2="357.993" y2="123.368" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="372.426" y1="157.241" x2="372.426" y2="122.737" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="386.856" y1="162.223" x2="386.856" y2="117.755" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="401.286" y1="152.616" x2="401.286" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="415.719" y1="151.174" x2="415.719" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="430.153" y1="167.048" x2="430.153" y2="112.929" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="444.579" y1="162.784" x2="444.579" y2="117.194" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="459.012" y1="161.573" x2="459.012" y2="118.405" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="473.446" y1="151.174" x2="473.446" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="487.88" y1="154.06" x2="487.88" y2="125.918" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="502.305" y1="158.423" x2="502.305" y2="121.553" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="516.739" y1="163.4" x2="516.739" y2="116.577" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="531.173" y1="164.669" x2="531.173" y2="115.309" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="545.606" y1="158.272" x2="545.606" y2="121.705" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="560.036" y1="152.616" x2="560.036" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="574.469" y1="163.701" x2="574.469" y2="116.276" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="588.903" y1="160.213" x2="588.903" y2="119.764" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="603.333" y1="178.594" x2="603.333" y2="101.384" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="617.762" y1="167.048" x2="617.762" y2="112.929" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="632.196" y1="172.821" x2="632.196" y2="107.156" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="646.63" y1="172.821" x2="646.63" y2="107.156" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="661.059" y1="187.253" x2="661.059" y2="92.7246" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="675.489" y1="198.798" x2="675.489" y2="81.1788" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="689.923" y1="216.116" x2="689.923" y2="63.8608" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="704.352" y1="231.991" x2="704.352" y2="47.9858" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="718.786" y1="231.991" x2="718.786" y2="47.9858" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="733.216" y1="216.116" x2="733.216" y2="63.8608" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="747.649" y1="198.798" x2="747.649" y2="81.1788" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="762.083" y1="187.253" x2="762.083" y2="92.7246" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="776.516" y1="178.594" x2="776.516" y2="101.384" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="790.946" y1="178.594" x2="790.946" y2="101.384" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="805.376" y1="187.253" x2="805.376" y2="92.7246" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="819.809" y1="184.366" x2="819.809" y2="95.6108" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="834.243" y1="164.162" x2="834.243" y2="115.815" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="848.673" y1="169.935" x2="848.673" y2="110.043" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="863.102" y1="157.613" x2="863.102" y2="122.364" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="877.536" y1="166.646" x2="877.536" y2="113.329" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="891.969" y1="163.298" x2="891.969" y2="116.679" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="906.399" y1="154.831" x2="906.399" y2="125.146" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="920.829" y1="161.566" x2="920.829" y2="118.411" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="935.262" y1="161.621" x2="935.262" y2="118.355" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="949.696" y1="151.174" x2="949.696" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="964.122" y1="154.542" x2="964.122" y2="125.437" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="978.559" y1="165.74" x2="978.559" y2="114.235" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="992.993" y1="166.208" x2="992.993" y2="113.768" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1007.43" y1="157.132" x2="1007.43" y2="122.844" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1021.86" y1="152.616" x2="1021.86" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1036.29" y1="152.616" x2="1036.29" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1050.72" y1="154.06" x2="1050.72" y2="125.918" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1065.15" y1="152.616" x2="1065.15" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1079.58" y1="149.73" x2="1079.58" y2="130.247" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1094.01" y1="154.612" x2="1094.01" y2="125.364" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1108.45" y1="149.73" x2="1108.45" y2="130.247" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1122.88" y1="151.174" x2="1122.88" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1137.31" y1="156.301" x2="1137.31" y2="123.678" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1151.74" y1="160.865" x2="1151.74" y2="119.113" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1166.17" y1="152.616" x2="1166.17" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1180.6" y1="152.616" x2="1180.6" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1195.04" y1="149.73" x2="1195.04" y2="130.247" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1209.47" y1="157.059" x2="1209.47" y2="122.919" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1223.9" y1="152.616" x2="1223.9" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1238.33" y1="148.287" x2="1238.33" y2="131.691" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1252.77" y1="154.498" x2="1252.77" y2="125.479" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1267.2" y1="160.809" x2="1267.2" y2="119.168" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1281.63" y1="152.616" x2="1281.63" y2="127.361" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1296.06" y1="163.407" x2="1296.06" y2="116.57" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1310.49" y1="149.73" x2="1310.49" y2="130.247" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1324.92" y1="154.06" x2="1324.92" y2="125.918" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1339.35" y1="154.06" x2="1339.35" y2="125.918" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1353.79" y1="151.174" x2="1353.79" y2="128.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1368.22" y1="157.486" x2="1368.22" y2="122.492" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1382.65" y1="158.24" x2="1382.65" y2="121.737" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1397.08" y1="154.06" x2="1397.08" y2="125.918" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
            <line x1="1409.2" y1="149.287" x2="1409.2" y2="129.804" stroke="white" stroke-width="3.60795"
                  stroke-linecap="round" />
        </svg>
        <div class="controls">
            <div class="controls-btn prev">
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.5015 1.11279V16.9729M15.8984 2.76712V15.9529C15.8984 16.9297 14.8078 17.5401 13.9352 17.0518L2.15591 10.4589C1.28337 9.97049 1.28337 8.74958 2.15591 8.26122L13.9352 1.6683C14.8078 1.17994 15.8984 1.79039 15.8984 2.76712Z"
                        stroke="white" stroke-width="3" />
                </svg>


            </div>
            <div class="controls-btn play">
                <svg class="pause" width="14" height="22" viewBox="0 0 14 22" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <line x1="2" y1="2" x2="2" y2="20" stroke="#A25984" stroke-width="4" stroke-linecap="round" />
                    <line x1="12" y1="2" x2="12" y2="20" stroke="#A25984" stroke-width="4" stroke-linecap="round" />
                </svg>
                <svg class="start" width="18" height="19" viewBox="0 0 18 19" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.2425 8.26113C16.1151 8.7495 16.1151 9.9704 15.2425 10.4588L3.46322 17.0517C2.59068 17.54 1.5 16.9296 1.5 15.9529V2.76704C1.5 1.79031 2.59068 1.17985 3.46322 1.66822L15.2425 8.26113Z"
                        fill="white" stroke="white" stroke-width="3" />
                </svg>

            </div>
            <div class="controls-btn next">
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.8969 1.11279V16.9729M1.5 2.76712V15.9529C1.5 16.9297 2.59068 17.5401 3.46322 17.0518L15.2425 10.4589C16.1151 9.97049 16.1151 8.74958 15.2425 8.26122L3.46322 1.6683C2.59068 1.17994 1.5 1.79039 1.5 2.76712Z"
                        stroke="white" stroke-width="3" />
                </svg>


            </div>
        </div>
    </div>
</section>
<section class="page-32 project-stages" data-header-theme="white">
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
<section class="page-32 have-a-questions" data-header-theme="gradient1">
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
                            <p class="custom-select_title">Duration</p>
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1.svg"
                                class="arrow arrow_default active" alt="arrow">
                            <img
                                src="/wp-content/themes/support-time/assets/img/repeat-elements/form/custom-checkbox-arrow-1-active.svg"
                                class="arrow arrow_active" alt="arrow">
                        </div>
                        <div class="custom-select_list">
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="duration[]" value="monthly maintenance"
                                       id="p32_duration_1">
                                <label for="p32_duration_1">
                                    <span>
                                    </span>
                                    monthly maintenance
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="duration[]" value="support for a year"
                                       id="p32_duration_2">
                                <label for="p32_duration_2">
                                    <span>
                                    </span>
                                    support for a year
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
                                       id="p32_services_price_1">
                                <label for="p32_services_price_1">
                                    <span>
                                    </span>
                                    not defined
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="100 000 $"
                                       id="p32_services_price_2">
                                <label for="p32_services_price_2">
                                    <span>
                                    </span>
                                    100 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="150 000 $"
                                       id="p32_services_price_3">
                                <label for="p32_services_price_3">
                                    <span>
                                    </span>
                                    150 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="200 000 $"
                                       id="p32_services_price_4">
                                <label for="p32_services_price_4">
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
                            <a href="https://t.me/ComplexWisps" target="_blank" rel="noopener noreferrer">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M26.0696 3.99558C25.7487 4.01939 25.4337 4.09469 25.1366 4.21858H25.1326C24.8476 4.33158 23.4926 4.90158 21.4326 5.76558L14.0506 8.87458C8.75363 11.1046 3.54663 13.3006 3.54663 13.3006L3.60863 13.2766C3.60863 13.2766 3.24963 13.3946 2.87463 13.6516C2.64243 13.7983 2.44295 13.9913 2.28863 14.2186C2.10463 14.4886 1.95663 14.9016 2.01163 15.3286C2.10163 16.0506 2.56963 16.4836 2.90563 16.7226C3.24563 16.9646 3.56963 17.0776 3.56963 17.0776H3.57763L8.46063 18.7226C8.67963 19.4256 9.94863 23.5976 10.2536 24.5586C10.4336 25.1326 10.6086 25.4916 10.8276 25.7656C10.9323 25.9056 11.0586 26.0226 11.2066 26.1166C11.2835 26.1628 11.3662 26.1984 11.4526 26.2226L11.4026 26.2106C11.4176 26.2146 11.4296 26.2266 11.4406 26.2306C11.4806 26.2416 11.5076 26.2456 11.5586 26.2536C12.3316 26.4876 12.9526 26.0076 12.9526 26.0076L12.9876 25.9796L15.8706 23.3546L20.7026 27.0616L20.8126 27.1086C21.8196 27.5506 22.8396 27.3046 23.3786 26.8706C23.9216 26.4336 24.1326 25.8746 24.1326 25.8746L24.1676 25.7846L27.9016 6.65558C28.0076 6.18358 28.0346 5.74158 27.9176 5.31258C27.7976 4.8781 27.5189 4.50448 27.1366 4.26558C26.8161 4.07058 26.4443 3.97651 26.0696 3.99558ZM25.9686 6.04558C25.9646 6.10858 25.9766 6.10158 25.9486 6.22258V6.23358L22.2496 25.1636C22.2336 25.1906 22.2066 25.2496 22.1326 25.3086C22.0546 25.3706 21.9926 25.4096 21.6676 25.2806L15.7576 20.7496L12.1876 24.0036L12.9376 19.2136L22.5936 10.2136C22.9916 9.84358 22.8586 9.76558 22.8586 9.76558C22.8866 9.31158 22.2576 9.63258 22.2576 9.63258L10.0816 17.1756L10.0776 17.1556L4.24163 15.1906V15.1866L4.22663 15.1836L4.25663 15.1716L4.28863 15.1556L4.31963 15.1446C4.31963 15.1446 9.53063 12.9486 14.8276 10.7186C17.4796 9.60158 20.1516 8.47658 22.2066 7.60858C23.4254 7.09559 24.6454 6.58558 25.8666 6.07858C25.9486 6.04658 25.9096 6.04558 25.9686 6.04558Z" fill="white"/>
</svg>

                            </a>
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
                    <a href="#">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.64062 29.0337L4.50341 22.2625C3.35883 20.276 2.75776 18.0232 2.7607 15.7306C2.74746 8.50638 8.61419 2.63965 15.8245 2.63965C19.3239 2.63965 22.6097 3.99638 25.0838 6.47128C26.3033 7.68443 27.2699 9.12752 27.9276 10.7169C28.5853 12.3064 28.9211 14.0105 28.9154 15.7306C28.9154 22.9409 23.0487 28.8077 15.8377 28.8077C13.6427 28.8077 11.5008 28.2618 9.58496 27.2115L2.64062 29.0337ZM9.8914 24.8567L10.2906 25.096C11.9663 26.0876 13.8774 26.6113 15.8245 26.6126C21.8112 26.6126 26.6939 21.7307 26.6939 15.7431C26.6939 12.8433 25.5634 10.1033 23.5141 8.05492C22.5065 7.04156 21.3082 6.23764 19.9885 5.6895C18.6687 5.14134 17.2534 4.85981 15.8245 4.86112C9.82434 4.8619 4.94319 9.74383 4.94319 15.7314C4.94319 17.7798 5.51551 19.7892 6.60636 21.5187L6.85899 21.9311L5.75489 25.9483L9.8914 24.8567Z"
                                fill="url(#paint0_linear_1269_1031)" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M12.5637 10.2501C12.3244 9.70425 12.0585 9.69098 11.8323 9.69098C11.6327 9.67773 11.4191 9.67773 11.193 9.67773C10.9809 9.67773 10.6214 9.75727 10.3158 10.0902C10.0093 10.4224 9.17188 11.2076 9.17188 12.817C9.17188 14.4272 10.3423 15.9835 10.5021 16.1964C10.6612 16.4092 12.7633 19.8143 16.0897 21.1321C18.8562 22.2229 19.4153 22.0101 20.0141 21.943C20.6122 21.8768 21.9432 21.1586 22.2223 20.3867C22.4883 19.6288 22.4883 18.9636 22.4087 18.8302C22.3291 18.6977 22.1022 18.6174 21.7834 18.4443C21.4504 18.2852 19.8543 17.4868 19.5486 17.38C19.2422 17.2739 19.0293 17.2208 18.8164 17.5398C18.6036 17.8728 17.9782 18.6042 17.7794 18.817C17.5923 19.0299 17.3934 19.0564 17.0738 18.8966C16.7416 18.7374 15.6905 18.3913 14.4398 17.2739C13.4682 16.4084 12.8164 15.3316 12.6167 15.0127C12.4312 14.6798 12.5902 14.5066 12.7633 14.3468C12.9099 14.201 13.0963 13.9616 13.2561 13.7752C13.4152 13.5881 13.4682 13.4423 13.5883 13.2294C13.6944 13.0166 13.6414 12.817 13.5618 12.6579C13.4815 12.5113 12.8569 10.9019 12.5637 10.2501Z"
                                  fill="url(#paint1_linear_1269_1031)" />
                            <path opacity="0.3"
                                  d="M2.64062 29.0337L4.50341 22.2625C3.35883 20.276 2.75776 18.0232 2.7607 15.7306C2.74746 8.50638 8.61419 2.63965 15.8245 2.63965C19.3239 2.63965 22.6097 3.99638 25.0838 6.47128C26.3033 7.68443 27.2699 9.12752 27.9276 10.7169C28.5853 12.3064 28.9211 14.0105 28.9154 15.7306C28.9154 22.9409 23.0487 28.8077 15.8377 28.8077C13.6427 28.8077 11.5008 28.2618 9.58496 27.2115L2.64062 29.0337ZM9.8914 24.8567L10.2906 25.096C11.9663 26.0876 13.8774 26.6113 15.8245 26.6126C21.8112 26.6126 26.6939 21.7307 26.6939 15.7431C26.6939 12.8433 25.5634 10.1033 23.5141 8.05492C22.5065 7.04156 21.3082 6.23764 19.9885 5.6895C18.6687 5.14134 17.2534 4.85981 15.8245 4.86112C9.82434 4.8619 4.94319 9.74383 4.94319 15.7314C4.94319 17.7798 5.51551 19.7892 6.60636 21.5187L6.85899 21.9311L5.75489 25.9483L9.8914 24.8567Z"
                                  fill="url(#paint2_linear_1269_1031)" />
                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                  d="M12.5637 10.2501C12.3244 9.70425 12.0585 9.69098 11.8323 9.69098C11.6327 9.67773 11.4191 9.67773 11.193 9.67773C10.9809 9.67773 10.6214 9.75727 10.3158 10.0902C10.0093 10.4224 9.17188 11.2076 9.17188 12.817C9.17188 14.4272 10.3423 15.9835 10.5021 16.1964C10.6612 16.4092 12.7633 19.8143 16.0897 21.1321C18.8562 22.2229 19.4153 22.0101 20.0141 21.943C20.6122 21.8768 21.9432 21.1586 22.2223 20.3867C22.4883 19.6288 22.4883 18.9636 22.4087 18.8302C22.3291 18.6977 22.1022 18.6174 21.7834 18.4443C21.4504 18.2852 19.8543 17.4868 19.5486 17.38C19.2422 17.2739 19.0293 17.2208 18.8164 17.5398C18.6036 17.8728 17.9782 18.6042 17.7794 18.817C17.5923 19.0299 17.3934 19.0564 17.0738 18.8966C16.7416 18.7374 15.6905 18.3913 14.4398 17.2739C13.4682 16.4084 12.8164 15.3316 12.6167 15.0127C12.4312 14.6798 12.5902 14.5066 12.7633 14.3468C12.9099 14.201 13.0963 13.9616 13.2561 13.7752C13.4152 13.5881 13.4682 13.4423 13.5883 13.2294C13.6944 13.0166 13.6414 12.817 13.5618 12.6579C13.4815 12.5113 12.8569 10.9019 12.5637 10.2501Z"
                                  fill="url(#paint3_linear_1269_1031)" />
                            <defs>
                                <linearGradient id="paint0_linear_1269_1031" x1="15.778" y1="2.63965" x2="15.778"
                                                y2="29.0337" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                                <linearGradient id="paint1_linear_1269_1031" x1="15.8134" y1="9.67773" x2="15.8134"
                                                y2="22.005" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                                <linearGradient id="paint2_linear_1269_1031" x1="15.778" y1="2.63965" x2="15.778"
                                                y2="29.0337" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                                <linearGradient id="paint3_linear_1269_1031" x1="15.8134" y1="9.67773" x2="15.8134"
                                                y2="22.005" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                            </defs>
                        </svg>

                    </a>
                    <a href="#">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.62891 13.8111L16.9042 21.5175C18.672 22.8433 21.1026 22.8433 22.8705 21.5175L33.1457 13.811"
                                stroke="url(#paint0_linear_1269_1036)" stroke-width="3.3146" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M31.4895 10.4961H8.28726C6.45666 10.4961 4.97266 11.9801 4.97266 13.8107V30.3837C4.97266 32.2143 6.45666 33.6983 8.28726 33.6983H31.4895C33.3201 33.6983 34.8041 32.2143 34.8041 30.3837V13.8107C34.8041 11.9801 33.3201 10.4961 31.4895 10.4961Z"
                                stroke="url(#paint1_linear_1269_1036)" stroke-width="3.3146" stroke-linecap="round" />
                            <path opacity="0.3"
                                  d="M31.4895 10.4961H8.28726C6.45666 10.4961 4.97266 11.9801 4.97266 13.8107V30.3837C4.97266 32.2143 6.45666 33.6983 8.28726 33.6983H31.4895C33.3201 33.6983 34.8041 32.2143 34.8041 30.3837V13.8107C34.8041 11.9801 33.3201 10.4961 31.4895 10.4961Z"
                                  stroke="url(#paint2_linear_1269_1036)" stroke-width="3.3146" stroke-linecap="round" />
                            <path opacity="0.3"
                                  d="M6.62891 13.8111L16.9042 21.5175C18.672 22.8433 21.1026 22.8433 22.8705 21.5175L33.1457 13.811"
                                  stroke="url(#paint3_linear_1269_1036)" stroke-width="3.3146" stroke-linecap="round"
                                  stroke-linejoin="round" />
                            <defs>
                                <linearGradient id="paint0_linear_1269_1036" x1="19.8873" y1="13.811" x2="19.8873"
                                                y2="22.5119" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                                <linearGradient id="paint1_linear_1269_1036" x1="19.8884" y1="10.4961" x2="19.8884"
                                                y2="33.6983" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                                <linearGradient id="paint2_linear_1269_1036" x1="19.8884" y1="10.4961" x2="19.8884"
                                                y2="33.6983" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                                <linearGradient id="paint3_linear_1269_1036" x1="19.8873" y1="13.811" x2="19.8873"
                                                y2="22.5119" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#130839" />
                                    <stop offset="0.360577" stop-color="#282251" />
                                    <stop offset="0.764423" stop-color="#793971" />
                                    <stop offset="1" stop-color="#CC7897" />
                                </linearGradient>
                            </defs>
                        </svg>

                    </a>
                    <a href="#">
                        <svg width="29" height="30" viewBox="0 0 29 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M28.8493 14.8783C28.8493 23.0954 22.3911 29.7567 14.4247 29.7567C6.45814 29.7567 0 23.0954 0 14.8783C0 6.66126 6.45814 0 14.4247 0C22.3911 0 28.8493 6.66126 28.8493 14.8783ZM14.9415 10.9838C13.5386 11.5858 10.7345 12.8315 6.52943 14.7212C5.84658 15.0014 5.48887 15.2754 5.45632 15.5433C5.40129 15.9962 5.95103 16.1744 6.69961 16.4172C6.80145 16.4502 6.90695 16.4845 7.01511 16.5206C7.7516 16.7676 8.74233 17.0565 9.25736 17.068C9.72455 17.0784 10.246 16.8798 10.8217 16.472C14.7507 13.7364 16.7788 12.3538 16.906 12.3239C16.9959 12.3029 17.1203 12.2764 17.2047 12.3538C17.2891 12.4312 17.2808 12.5776 17.2718 12.6168C17.2174 12.8564 15.0595 14.9257 13.9427 15.9965C13.5947 16.3303 13.3477 16.567 13.2972 16.6212C13.1841 16.7423 13.0689 16.8569 12.9581 16.967C12.2739 17.6474 11.7607 18.1575 12.9865 18.9907C13.5756 19.3911 14.0469 19.7221 14.5171 20.0524C15.0306 20.4132 15.5429 20.773 16.2057 21.2211C16.3744 21.3352 16.5357 21.4538 16.6928 21.5693C17.2904 22.0088 17.8273 22.4037 18.4907 22.3406C18.8761 22.3041 19.2742 21.9302 19.4765 20.8153C19.9544 18.1803 20.8937 12.471 21.1108 10.1185C21.1298 9.91237 21.1059 9.64858 21.0867 9.53278C21.0674 9.41698 21.0273 9.25198 20.8813 9.12984C20.7085 8.9852 20.4418 8.9547 20.3223 8.95676C19.7798 8.96673 18.9474 9.26527 14.9415 10.9838Z"
                                  fill="url(#paint0_linear_1269_1041)" />
                            <defs>
                                <linearGradient id="paint0_linear_1269_1041" x1="14.4247" y1="0" x2="14.4247"
                                                y2="29.7567" gradientUnits="userSpaceOnUse">
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
        </div>
    </div>
</section>
<section class="page-32 faq-accordion" data-header-theme="gradient2">
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
