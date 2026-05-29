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
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="5 000 $"
                                       id="p32_services_price_2">
                                <label for="p32_services_price_2">
                                    <span>
                                    </span>
                                    5 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="10 000 $"
                                       id="p32_services_price_3">
                                <label for="p32_services_price_3">
                                    <span>
                                    </span>
                                    10 000 $
                                </label>
                            </div>
                            <div class="custom-select_item">
                                <input type="checkbox" class="onlyOne" name="servicesPrice[]" value="15 000 $"
                                       id="p32_services_price_4">
                                <label for="p32_services_price_4">
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
                                                                <?php get_template_part('template-parts/form-social-icons', null, ['variant' => 'form', 'uid' => 'p32-form']); ?>
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
                                                <?php get_template_part('template-parts/form-social-icons', null, ['variant' => 'success', 'uid' => 'p32-success']); ?>
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
