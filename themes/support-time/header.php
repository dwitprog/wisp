<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body>
<header class="header" id="header">
    <div class="header-container">
        <a href="/" class="header-logo">
            <span class=" white">
                  <svg width="109" height="60" viewBox="0 0 109 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_781_87707)">
                    <path
                        d="M31.4678 15.631C28.7054 15.631 26.4151 16.5754 24.5971 18.4643C22.779 20.3295 21.87 22.7142 21.87 25.6184C21.87 28.5225 22.779 30.919 24.5971 32.8079C26.4151 34.6731 28.7054 35.6058 31.4678 35.6058C34.5609 35.6058 36.9574 34.3544 38.6573 31.8516H41.349C40.3809 33.6933 39.0469 35.1572 37.3469 36.2433C35.6706 37.3058 33.7109 37.837 31.4678 37.837C28.0679 37.837 25.211 36.6683 22.8971 34.3308C20.5832 31.9697 19.4263 29.0656 19.4263 25.6184C19.4263 22.1712 20.5832 19.2788 22.8971 16.9414C25.211 14.5803 28.0679 13.3997 31.4678 13.3997C33.7109 13.3997 35.6706 13.9428 37.3469 15.0289C39.0469 16.0914 40.3809 17.5434 41.349 19.3851H38.6573C36.9574 16.8823 34.5609 15.631 31.4678 15.631ZM41.1697 13.8601H43.8259L51.0154 34.4724L58.0279 13.8601H61.1445L68.3694 34.4724L75.3819 13.8601H77.9673L69.8923 37.3766H66.7757L59.5153 16.6935L52.5383 37.3766H49.4217L41.1697 13.8601ZM94.0839 37.3766L91.6048 31.7454H78.0757L75.5966 37.3766H73.0112L83.3527 13.8601H86.3631L96.6693 37.3766H94.0839ZM84.8402 16.4101L79.0674 29.5142H90.6131L84.8402 16.4101Z"
                        fill="white" />
                    <path
                        d="M108.011 57.2638C108.011 57.5313 107.931 57.7434 107.771 57.9002C107.612 58.0569 107.398 58.1445 107.13 58.163L108.094 59.4264H107.578L106.614 58.163H105.959V59.4264H105.544V56.3647H107.034C107.329 56.3647 107.565 56.4446 107.744 56.6045C107.922 56.7612 108.011 56.981 108.011 57.2638ZM107.439 57.6419C107.544 57.5528 107.596 57.4268 107.596 57.2638C107.596 57.1009 107.544 56.9749 107.439 56.8857C107.338 56.7966 107.203 56.752 107.034 56.752H105.959V57.7757H107.034C107.203 57.7757 107.338 57.7311 107.439 57.6419Z"
                        fill="white" />
                    <path
                        d="M0.828 4.08987C0.36 4.52987 0.06 4.74988 -0.072 4.74988C-0.14 4.74988 -0.174 4.70387 -0.174 4.61187C-0.174 4.51987 -0.138 4.38587 -0.066 4.20987C0.006 4.03387 0.078 3.87987 0.15 3.74787L0.258 3.55587C0.562 3.02387 0.792 2.64187 0.948 2.40987C1.016 2.30987 1.102 2.22587 1.206 2.15787C1.314 2.08587 1.414 2.04987 1.506 2.04987C1.538 2.04987 1.554 2.06387 1.554 2.09187C1.554 2.11187 1.54 2.14987 1.512 2.20587C1.464 2.29387 1.346 2.50387 1.158 2.83587C0.97 3.16787 0.858 3.36787 0.822 3.43587C0.658 3.72387 0.576 3.91587 0.576 4.01187C0.576 4.04787 0.588 4.06587 0.612 4.06587C0.652 4.06587 0.78 3.96587 0.996 3.76587C1.164 3.59787 1.386 3.35587 1.662 3.03987C1.674 3.02787 1.684 3.02187 1.692 3.02187C1.7 3.02187 1.704 3.02987 1.704 3.04587C1.704 3.12187 1.674 3.19587 1.614 3.26787C1.318 3.59587 1.056 3.86987 0.828 4.08987ZM1.626 1.70787C1.526 1.70787 1.476 1.64787 1.476 1.52787C1.476 1.41587 1.518 1.30387 1.602 1.19187C1.686 1.07587 1.778 1.01787 1.878 1.01787C1.998 1.01787 2.058 1.08587 2.058 1.22187C2.058 1.33387 2.012 1.44387 1.92 1.55187C1.828 1.65587 1.73 1.70787 1.626 1.70787Z"
                        fill="white" />
                    <path
                        d="M8.70052 0.434967C8.56914 0.303587 8.35614 0.303587 8.22476 0.434967L6.08379 2.57593C5.95241 2.70731 5.95241 2.92032 6.08379 3.0517C6.21517 3.18308 6.42818 3.18308 6.55956 3.0517L8.46264 1.14862L10.3657 3.0517C10.4971 3.18308 10.7101 3.18308 10.8415 3.0517C10.9729 2.92032 10.9729 2.70731 10.8415 2.57593L8.70052 0.434967ZM108.45 49.8412C108.581 49.7098 108.581 49.4968 108.45 49.3654L106.309 47.2245C106.178 47.0931 105.965 47.0931 105.833 47.2245C105.702 47.3558 105.702 47.5688 105.833 47.7002L107.736 49.6033L105.833 51.5064C105.702 51.6378 105.702 51.8508 105.833 51.9821C105.965 52.1135 106.178 52.1135 106.309 51.9821L108.45 49.8412ZM8.46264 49.6033H8.79906L8.79906 0.672852L8.46264 0.672852L8.12622 0.672852L8.12622 49.6033H8.46264ZM8.35156 49.6033V49.9397H8.46264V49.6033V49.2669H8.35156V49.6033ZM8.46264 49.6033V49.9397H108.212V49.6033V49.2669H8.46264V49.6033Z"
                        fill="white" />
                </g>
                <defs>
                    <clipPath id="clip0_781_87707">
                        <rect width="109" height="59.8091" fill="white" />
                    </clipPath>
                </defs>
            </svg>
            </span>
            <span class="gradient">
              <svg width="109" height="60" viewBox="0 0 109 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_781_88409)">
                <path
                    d="M31.4678 15.631C28.7054 15.631 26.4151 16.5754 24.5971 18.4643C22.779 20.3295 21.87 22.7142 21.87 25.6184C21.87 28.5225 22.779 30.919 24.5971 32.8079C26.4151 34.6731 28.7054 35.6058 31.4678 35.6058C34.5609 35.6058 36.9574 34.3544 38.6573 31.8516H41.349C40.3809 33.6933 39.0469 35.1572 37.3469 36.2433C35.6706 37.3058 33.7109 37.837 31.4678 37.837C28.0679 37.837 25.211 36.6683 22.8971 34.3308C20.5832 31.9697 19.4263 29.0656 19.4263 25.6184C19.4263 22.1712 20.5832 19.2788 22.8971 16.9414C25.211 14.5803 28.0679 13.3997 31.4678 13.3997C33.7109 13.3997 35.6706 13.9428 37.3469 15.0289C39.0469 16.0914 40.3809 17.5434 41.349 19.3851H38.6573C36.9574 16.8823 34.5609 15.631 31.4678 15.631ZM41.1697 13.8601H43.8259L51.0154 34.4724L58.0279 13.8601H61.1445L68.3694 34.4724L75.3819 13.8601H77.9673L69.8923 37.3766H66.7757L59.5153 16.6935L52.5383 37.3766H49.4217L41.1697 13.8601ZM94.0839 37.3766L91.6048 31.7454H78.0757L75.5966 37.3766H73.0112L83.3527 13.8601H86.3631L96.6693 37.3766H94.0839ZM84.8402 16.4101L79.0674 29.5142H90.6131L84.8402 16.4101Z"
                    fill="url(#paint0_linear_781_88409)" />
                <path
                    d="M108.011 57.2638C108.011 57.5313 107.931 57.7434 107.771 57.9002C107.612 58.0569 107.398 58.1445 107.13 58.163L108.094 59.4264H107.578L106.614 58.163H105.959V59.4264H105.544V56.3647H107.034C107.329 56.3647 107.565 56.4446 107.744 56.6045C107.922 56.7612 108.011 56.981 108.011 57.2638ZM107.439 57.6419C107.544 57.5528 107.596 57.4268 107.596 57.2638C107.596 57.1009 107.544 56.9749 107.439 56.8857C107.338 56.7966 107.203 56.752 107.034 56.752H105.959V57.7757H107.034C107.203 57.7757 107.338 57.7311 107.439 57.6419Z"
                    fill="url(#paint1_linear_781_88409)" />
                <path
                    d="M0.828 4.08987C0.36 4.52987 0.06 4.74988 -0.072 4.74988C-0.14 4.74988 -0.174 4.70387 -0.174 4.61187C-0.174 4.51987 -0.138 4.38587 -0.066 4.20987C0.006 4.03387 0.078 3.87987 0.15 3.74787L0.258 3.55587C0.562 3.02387 0.792 2.64187 0.948 2.40987C1.016 2.30987 1.102 2.22587 1.206 2.15787C1.314 2.08587 1.414 2.04987 1.506 2.04987C1.538 2.04987 1.554 2.06387 1.554 2.09187C1.554 2.11187 1.54 2.14987 1.512 2.20587C1.464 2.29387 1.346 2.50387 1.158 2.83587C0.97 3.16787 0.858 3.36787 0.822 3.43587C0.658 3.72387 0.576 3.91587 0.576 4.01187C0.576 4.04787 0.588 4.06587 0.612 4.06587C0.652 4.06587 0.78 3.96587 0.996 3.76587C1.164 3.59787 1.386 3.35587 1.662 3.03987C1.674 3.02787 1.684 3.02187 1.692 3.02187C1.7 3.02187 1.704 3.02987 1.704 3.04587C1.704 3.12187 1.674 3.19587 1.614 3.26787C1.318 3.59587 1.056 3.86987 0.828 4.08987ZM1.626 1.70787C1.526 1.70787 1.476 1.64787 1.476 1.52787C1.476 1.41587 1.518 1.30387 1.602 1.19187C1.686 1.07587 1.778 1.01787 1.878 1.01787C1.998 1.01787 2.058 1.08587 2.058 1.22187C2.058 1.33387 2.012 1.44387 1.92 1.55187C1.828 1.65587 1.73 1.70787 1.626 1.70787Z"
                    fill="url(#paint2_linear_781_88409)" />
                <path
                    d="M8.70052 0.434967C8.56914 0.303587 8.35614 0.303587 8.22476 0.434967L6.08379 2.57593C5.95241 2.70731 5.95241 2.92032 6.08379 3.0517C6.21517 3.18308 6.42818 3.18308 6.55956 3.0517L8.46264 1.14862L10.3657 3.0517C10.4971 3.18308 10.7101 3.18308 10.8415 3.0517C10.9729 2.92032 10.9729 2.70731 10.8415 2.57593L8.70052 0.434967ZM108.45 49.8412C108.581 49.7098 108.581 49.4968 108.45 49.3654L106.309 47.2245C106.178 47.0931 105.965 47.0931 105.833 47.2245C105.702 47.3558 105.702 47.5688 105.833 47.7002L107.736 49.6033L105.833 51.5064C105.702 51.6378 105.702 51.8508 105.833 51.9821C105.965 52.1135 106.178 52.1135 106.309 51.9821L108.45 49.8412ZM8.46264 49.6033H8.79906L8.79906 0.672852L8.46264 0.672852L8.12622 0.672852L8.12622 49.6033H8.46264ZM8.35156 49.6033V49.9397H8.46264V49.6033V49.2669H8.35156V49.6033ZM8.46264 49.6033V49.9397H108.212V49.6033V49.2669H8.46264V49.6033Z"
                    fill="url(#paint3_linear_781_88409)" />
                </g>
                <defs>
                <linearGradient id="paint0_linear_781_88409" x1="58.2822" y1="13.3766" x2="58.2822" y2="37.3766"
                                gradientUnits="userSpaceOnUse">
                <stop stop-color="#130839" />
                <stop offset="0.360577" stop-color="#282251" />
                <stop offset="0.764423" stop-color="#793971" />
                <stop offset="1" stop-color="#CC7897" />
                </linearGradient>
                <linearGradient id="paint1_linear_781_88409" x1="107.152" y1="54.4264" x2="107.152" y2="60.4264"
                                gradientUnits="userSpaceOnUse">
                <stop stop-color="#130839" />
                <stop offset="0.360577" stop-color="#282251" />
                <stop offset="0.764423" stop-color="#793971" />
                <stop offset="1" stop-color="#CC7897" />
                </linearGradient>
                <linearGradient id="paint2_linear_781_88409" x1="1" y1="-1.32813" x2="1" y2="7.67188"
                                gradientUnits="userSpaceOnUse">
                <stop stop-color="#130839" />
                <stop offset="0.360577" stop-color="#282251" />
                <stop offset="0.764423" stop-color="#793971" />
                <stop offset="1" stop-color="#CC7897" />
                </linearGradient>
                <linearGradient id="paint3_linear_781_88409" x1="58.2818" y1="0.672852" x2="58.2818" y2="49.6033"
                                gradientUnits="userSpaceOnUse">
                <stop stop-color="#130839" />
                <stop offset="0.360577" stop-color="#282251" />
                <stop offset="0.764423" stop-color="#793971" />
                <stop offset="1" stop-color="#CC7897" />
                </linearGradient>
                <clipPath id="clip0_781_88409">
                <rect width="109" height="59.8091" fill="white" />
                </clipPath>
                </defs>
                </svg>

          </span>

        </a>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'header_menu',
            'menu_class' => 'header-menu_list',
            'container' => 'nav',
            'container_class' => 'header-menu',
            'fallback_cb' => false,
            'depth' => 2,
        ));
        ?>
        <div class="header-end">
            <a href="#" class="header-phone">+1 000 000 00 00</a>
            <div class="changing-font-size">
                <button class="changing-font-size__btn">
                    <span class="white">
                        <svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 0.5C14.3106 0.5 16.2662 1.32422 18.1279 2.59961C19.875 3.79643 21.5054 5.36366 23.2656 7C21.5054 8.63634 19.875 10.2036 18.1279 11.4004C16.2662 12.6758 14.3106 13.5 12 13.5C9.69879 13.5 7.58749 12.5575 5.63672 11.2129C3.83659 9.97207 2.21296 8.41783 0.725586 7C2.21296 5.58217 3.83659 4.02793 5.63672 2.78711C7.58749 1.44249 9.69879 0.5 12 0.5Z"
                            stroke="white" />
                        <circle cx="12" cy="7" r="5" fill="white" />
                    </svg>
                    </span>
                    <span class="gradient">
                        <svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 0.5C14.3106 0.5 16.2662 1.32422 18.1279 2.59961C19.875 3.79643 21.5054 5.36366 23.2656 7C21.5054 8.63634 19.875 10.2036 18.1279 11.4004C16.2662 12.6758 14.3106 13.5 12 13.5C9.69879 13.5 7.58749 12.5575 5.63672 11.2129C3.83659 9.97207 2.21296 8.41783 0.725586 7C2.21296 5.58217 3.83659 4.02793 5.63672 2.78711C7.58749 1.44249 9.69879 0.5 12 0.5Z"
                            stroke="url(#paint0_linear_781_88284)" />
                        <circle cx="12" cy="7" r="5" fill="url(#paint1_linear_781_88284)" />
                        <defs>
                        <linearGradient id="paint0_linear_781_88284" x1="12" y1="0" x2="12" y2="14"
                                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#130839" />
                        <stop offset="0.360577" stop-color="#282251" />
                        <stop offset="0.764423" stop-color="#793971" />
                        <stop offset="1" stop-color="#CC7897" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_781_88284" x1="12" y1="2" x2="12" y2="12"
                                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#130839" />
                        <stop offset="0.360577" stop-color="#282251" />
                        <stop offset="0.764423" stop-color="#793971" />
                        <stop offset="1" stop-color="#CC7897" />
                        </linearGradient>
                        </defs>
                        </svg>

                    </span>
                </button>
                <div class="changing-font-size_wrapper">
                    <input type="range" min="1" max="6" step="1" name="fontSize" id="fontSize">
                    <div class="changing-font-size_container">
                        <div class="changing-font-size_line">
                            <span class="bold"></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span class="bold"></span>
                        </div>
                        <div class="changing-font-size_thumb">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_dn_1205_3567)">
                                    <rect x="2.62109" y="2.62085" width="22.1765" height="22.1765" rx="11.0882"
                                          fill="url(#paint0_radial_1205_3567)" />
                                    <rect x="2.9235" y="2.92326" width="21.5717" height="21.5717" rx="10.7858"
                                          stroke="#01001A" stroke-width="0.604813" />
                                    <rect x="2.9235" y="2.92326" width="21.5717" height="21.5717" rx="10.7858"
                                          stroke="url(#paint1_radial_1205_3567)" stroke-width="0.604813" />
                                </g>
                                <g filter="url(#filter1_i_1205_3567)">
                                    <ellipse cx="13.6564" cy="13.6321" rx="7.00015" ry="6.97861"
                                             fill="url(#paint2_radial_1205_3567)" />
                                </g>
                                <defs>
                                    <filter id="filter0_dn_1205_3567" x="0.000238061" y="-6.07967e-06" width="29.4335"
                                            height="29.4343" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feColorMatrix in="SourceAlpha" type="matrix"
                                                       values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                       result="hardAlpha" />
                                        <feOffset dx="1.00802" dy="1.00802" />
                                        <feGaussianBlur stdDeviation="1.81444" />
                                        <feComposite in2="hardAlpha" operator="out" />
                                        <feColorMatrix type="matrix"
                                                       values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix"
                                                 result="effect1_dropShadow_1205_3567" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                 result="shape" />
                                        <feTurbulence type="fractalNoise"
                                                      baseFrequency="4.9602112770080566 4.9602112770080566"
                                                      stitchTiles="stitch" numOctaves="3" result="noise" seed="1817" />
                                        <feColorMatrix in="noise" type="luminanceToAlpha" result="alphaNoise" />
                                        <feComponentTransfer in="alphaNoise" result="coloredNoise1">
                                            <feFuncA type="discrete"
                                                     tableValues="1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 " />
                                        </feComponentTransfer>
                                        <feComposite operator="in" in2="shape" in="coloredNoise1"
                                                     result="noise1Clipped" />
                                        <feFlood flood-color="rgba(151, 151, 151, 0.25)" result="color1Flood" />
                                        <feComposite operator="in" in2="noise1Clipped" in="color1Flood"
                                                     result="color1" />
                                        <feMerge result="effect2_noise_1205_3567">
                                            <feMergeNode in="shape" />
                                            <feMergeNode in="color1" />
                                        </feMerge>
                                        <feBlend mode="normal" in="effect2_noise_1205_3567"
                                                 in2="effect1_dropShadow_1205_3567" result="effect2_noise_1205_3567" />
                                    </filter>
                                    <filter id="filter1_i_1205_3567" x="6.65625" y="6.65344" width="18.0321"
                                            height="17.9894" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                 result="shape" />
                                        <feColorMatrix in="SourceAlpha" type="matrix"
                                                       values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                       result="hardAlpha" />
                                        <feOffset dx="4.03209" dy="4.03209" />
                                        <feGaussianBlur stdDeviation="2.41925" />
                                        <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1" />
                                        <feColorMatrix type="matrix"
                                                       values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                        <feBlend mode="normal" in2="shape" result="effect1_innerShadow_1205_3567" />
                                    </filter>
                                    <radialGradient id="paint0_radial_1205_3567" cx="0" cy="0" r="1"
                                                    gradientUnits="userSpaceOnUse"
                                                    gradientTransform="translate(9.67725 10.685) rotate(83.6598) scale(36.5121 40.3986)">
                                        <stop stop-color="#FFFEFF" />
                                        <stop offset="1" stop-color="#3F3A63" />
                                    </radialGradient>
                                    <radialGradient id="paint1_radial_1205_3567" cx="0" cy="0" r="1"
                                                    gradientUnits="userSpaceOnUse"
                                                    gradientTransform="translate(13.9936 13.9934) rotate(180) scale(11.3726 37.0846)">
                                        <stop stop-color="white" />
                                        <stop offset="1" stop-color="#100134" />
                                    </radialGradient>
                                    <radialGradient id="paint2_radial_1205_3567" cx="0" cy="0" r="1"
                                                    gradientUnits="userSpaceOnUse"
                                                    gradientTransform="translate(13.6564 13.6321) rotate(90) scale(21.215 12.5414)">
                                        <stop stop-color="#E98DD2" />
                                        <stop offset="1" stop-color="#5C3166" />
                                    </radialGradient>
                                </defs>
                            </svg>


                        </div>
                    </div>
                    <div class="changing-font-size_label">
                        <span class="small">Aa</span>
                        <span class="big">Aa</span>
                    </div>
                </div>
            </div>
        </div>
        <button class="mobile-menu-btn">
            <span></span><span></span><span></span>
        </button>
    </div>

</header>
